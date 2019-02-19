<?php
/**
 * rio-sgps
 * FamilyImportService.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 26/12/2018, 15:21
 */

namespace SGPS\Services;


use Excel;
use SGPS\Entity\Entity;
use SGPS\Entity\Family;
use SGPS\Entity\Person;
use SGPS\Entity\Question;
use SGPS\Entity\QuestionAnswer;
use SGPS\Entity\Residence;
use SGPS\Entity\Survey\ImportedFamily;
use SGPS\Entity\Survey\ImportedMember;
use SGPS\Entity\Survey\SurveyImportJob;
use SGPS\Importers\SurveyFamilyCSV;
use SGPS\Importers\SurveyPersonCSV;
use SGPS\Utils\MapUtils;

class FamilyImportService {

	/**
	 * @var EntityFieldLinkService
	 */
	private $entityFieldLinkService;

	/**
	 * @var FlagBehaviorService
	 */
	private $flagBehaviorService;

	public function __construct(EntityFieldLinkService $entityFieldLinkService, FlagBehaviorService $flagBehaviorService) {

		$this->entityFieldLinkService = $entityFieldLinkService;
		$this->flagBehaviorService = $flagBehaviorService;
	}

	/**
	 * Processes the CSVs for the given import job.
	 *
	 * @param SurveyImportJob $importJob
	 * @param string $disk
	 */
	public function readFromCSV(SurveyImportJob $importJob, string $disk = 'static_data') : void {

		logger("[FamilyImportService.readFromCSV] Loading families...");
		Excel::import(new SurveyFamilyCSV($importJob), $importJob->families_csv, $disk);

		logger("[FamilyImportService.readFromCSV] Loading members...");
		Excel::import(new SurveyPersonCSV($importJob), $importJob->members_csv, $disk);

	}

	/**
	 * Builds tje family structure based on the completed import job.
	 *
	 * @param SurveyImportJob $importJob
	 * @throws \Exception
	 */
	public function buildFamilyStructure(SurveyImportJob $importJob) : void {

		logger("[FamilyImportService.buildFamilyStructure] Building structure for {$importJob->num_families_read} families and {$importJob->num_persons_read} persons read");

		foreach($importJob->families as $family) { /* @var $family \SGPS\Entity\Survey\ImportedFamily */
			$this->importFamily($importJob, $family);
		}

		$importJob->save();

		logger("[FamilyImportService.buildFamilyStructure] Import completed");
		logger("[FamilyImportService.buildFamilyStructure] Families: \t {$importJob->num_families_imported} imported \t {$importJob->num_families_skipped}");
		logger("[FamilyImportService.buildFamilyStructure] Persons: \t {$importJob->num_persons_imported} imported \t {$importJob->num_persons_skipped}");

	}

	/**
	 * Imports a single family in the system, cascading the entities beneath it.
	 *
	 * @param SurveyImportJob $importJob
	 * @param ImportedFamily $importedFamily
	 * @throws \Exception
	 */
	public function importFamily(SurveyImportJob $importJob, ImportedFamily $importedFamily) : void {

		$existingFamily = Family::find($importedFamily->id); /* @var $existingFamily Family|null */

		if(!$existingFamily) {

			$residence = new Residence();

			MapUtils::mapProperties($residence, $importedFamily, config('import_map.residence.fields'));

			$residence->save();

			$this->mapEntityAnswers($residence, $importedFamily, config('import_map.residence.questions'));

			logger("[FamilyImportService.importFamily] Imported #{$residence->id} \t residence \t {$residence->shortcode}");

			$family = new Family();
			$family->is_alert = true;
			$family->visit_attempt = 1;
			$family->visit_status = Family::VISIT_PENDING_AGENT;
			$family->id = $importedFamily->id;
			$family->residence_id = $residence->id;

			MapUtils::mapProperties($family, $importedFamily, config('import_map.family.fields'));

			$family->save();

			$this->mapEntityAnswers($family, $importedFamily, config('import_map.family.questions'));

			logger("[FamilyImportService.importFamily] Imported #{$family->id} \t family \t {$family->shortcode}");

			$importJob->raiseCounter('num_families_imported');

		} else {
			logger("[FamilyImportService.importFamily] Skipped family #{$importedFamily->id}, already exists... (using existing)");

			$importJob->raiseCounter('num_families_skipped');

			$family = $existingFamily;
			$residence = $family->residence;
		}

		foreach($importedFamily->members as $importedMember) {
			$this->importMember($importJob, $residence, $family, $importedFamily, $importedMember);
		}

	}

	/**
	 * Imports a single member of a family.
	 *
	 * @param SurveyImportJob $importJob
	 * @param Residence $residence
	 * @param Family $family
	 * @param ImportedFamily $importedFamily
	 * @param ImportedMember $importedMember
	 * @throws \Exception
	 */
	public function importMember(SurveyImportJob $importJob, Residence $residence, Family $family, ImportedFamily $importedFamily, ImportedMember $importedMember) : void {

		if(Person::where('id', $importedMember->id)->exists()) {
			logger("[FamilyImportService.importMember] Skipped #{$importedMember->id}, already exists...");
			$importJob->raiseCounter('num_persons_skipped');
			return;
		}

		$person = new Person();
		$person->id = $importedMember->id;
		$person->residence_id = $residence->id;
		$person->family_id = $family->id;

		MapUtils::mapProperties($person, $family, config('import_map.person.fields'));
		MapUtils::mapProperties($person, $residence, config('import_map.person.fields'));
		MapUtils::mapProperties($person, $importedMember, config('import_map.person.fields')); // Last one takes precedence (eg, for gis_global_id)

		$person->save();

		if(intval($importedMember->parentesco) === 1) {
			$family->person_in_charge_id = $person->id;
			$family->save();
		}

		$this->mapEntityAnswers($person, $importedMember, config('import_map.person.questions'));

		logger("[FamilyImportService.importMember] Imported #{$person->id} \t person \t {$person->shortcode}");

		$importJob->raiseCounter('num_persons_imported');
	}

	private $_questionsByCode = [];

	/**
	 * Quickly looks up a question by it's code.
	 * Has a local class cache.
	 *
	 * @param string $code
	 * @return null|Question
	 */
	private function getQuestionByCode(string $code) : ?Question {
		if(!isset($this->_questionsByCode[$code])) {
			$this->_questionsByCode[$code] = Question::fetchByCode($code);
		}

		return $this->_questionsByCode[$code];
	}

	/**
	 * Triggers changes for entities by checking updated fields and flag behavior classes.
	 *
	 * @param Entity $entity
	 * @param array $answers
	 * @throws \Exception
	 */
	public function triggerEntityChanges(Entity $entity, array $answers) {
		$this->entityFieldLinkService->updateEntityFields($entity, [], $answers);
		$this->flagBehaviorService->evaluateBehaviorsForAnswers($entity, $answers);
	}


	/**
	 * Maps a set of imported entity data to entity properties and entity answers.
	 * Will create the answers when relevant.
	 * Will trigger the necessary changes for flag attributions and entity back updates.
	 *
	 * @param Entity $entity
	 * @param $importedEntity
	 * @param array $mappingConfig
	 * @throws \Exception
	 */
	protected function mapEntityAnswers(Entity $entity, $importedEntity, array $mappingConfig) {
		$answerGrid = [];

		MapUtils::mapProperties($answerGrid, $importedEntity, $mappingConfig);

		foreach ($answerGrid as $questionCode => $value) {
			$question = $this->getQuestionByCode($questionCode);

			if(!$question) {
				logger("[FamilyImportService.mapEntityAnswers] Failed to locate question with code: {$questionCode}");
				return;
			}

			QuestionAnswer::forceCreate($entity, $question, $value);
		}

		$this->triggerEntityChanges($entity, $answerGrid);
	}

}