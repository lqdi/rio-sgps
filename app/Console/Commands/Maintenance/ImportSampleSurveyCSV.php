<?php
/**
 * rio-sgps
 * ImportSurveyCSV.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 26/12/2018, 13:37
 */

namespace SGPS\Console\Commands\Maintenance;


use Illuminate\Console\Command;
use SGPS\Diagnostics\QueryAnalyser;
use SGPS\Entity\Survey\SurveyImportJob;
use SGPS\Services\FamilyImportService;

class ImportSampleSurveyCSV extends Command {

	protected $signature = "maintenance:import_sample_survey_csv";

	const CSV_FAMILIES = 'demo_familias.csv';
	const CSV_MEMBERS = 'demo_membros.csv';

	public $queryAnalyser;

	public function handle(FamilyImportService $service) {

		$this->queryAnalyser = new QueryAnalyser();
		$this->queryAnalyser->listen();

		$importJob = SurveyImportJob::createFromFiles(self::CSV_FAMILIES, self::CSV_MEMBERS);

		$this->info("Begin import job: {$importJob->id}");

		$importJob->updateStage(SurveyImportJob::STAGE_CSV_READ);
		$service->readFromCSV($importJob);

		$importJob->refreshReadCounts();

		$this->info("Read {$importJob->num_families_read} families and {$importJob->num_persons_read} persons");

		$this->info("Building family structures...");

		$importJob->updateStage(SurveyImportJob::STAGE_GENERATE_FAMILIES);
		$service->buildFamilyStructure($importJob);

		$this->info("Completed!");

		$this->info("Query stats:");

		dump($this->queryAnalyser->analyseTypeCount());

		$importJob->updateStage(SurveyImportJob::STAGE_COMPLETED);

	}

}