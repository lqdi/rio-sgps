<?php
/**
 * rio-sgps
 * SurveyPersonCSV.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 21/12/2018, 18:01
 */

namespace SGPS\Importers;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use SGPS\Entity\Survey\ImportedMember;
use SGPS\Entity\Survey\SurveyImportJob;
use SGPS\Utils\CsvUtils;
use SGPS\Utils\UuidUtils;

class SurveyPersonCSV implements WithHeadingRow, ToCollection, WithCustomCsvSettings {

	public $importJob;

	public function __construct(SurveyImportJob $importJob) {
		$this->importJob = $importJob;
	}

	public function collection(Collection $array) {

		foreach($array as $member) { /* @var $member \Illuminate\Support\Collection */
			$member['id'] = UuidUtils::fromSurveyGUID($member['objectid']);
			$member['import_id'] = $this->importJob->id;
			$member['family_id'] = UuidUtils::fromSurveyGUID($member['parentrowid']);

			$this->convertDates($member);
			$this->convertGender($member);

			// Remove columns with no header
			$member = $member->filter(function ($value, $key) {
				return strlen(strval($key)) > 0;
			});

			ImportedMember::create($member->toArray());

			logger()->debug("[survey_importer.member] Found: #{$member['id']} -> {$member['nome']}");
		}

	}

	public function convertDates(&$member) {
		if(!isset($member['nascimento'])) return;
		$member['nascimento'] = CsvUtils::convertDateString($member['nascimento']);
	}

	private function convertGender(&$member) {
		if(!isset($member['sexo'])) return;
		$member['sexo'] = $member['sexo'] === 'M' ? 1 : 2;
	}

	public function getCsvSettings(): array {
		return [
			'input_encoding' => 'UTF-8',
			'delimiter' => ';',
		];
	}

}