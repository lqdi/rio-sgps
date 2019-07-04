<?php
/**
 * rio-sgps
 * SurveyFamilyCSV.php
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
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use SGPS\Entity\Survey\ImportedFamily;
use SGPS\Entity\Survey\SurveyImportJob;
use SGPS\Utils\CsvUtils;
use SGPS\Utils\UuidUtils;

class SurveyFamilyCSV implements WithHeadingRow, ToCollection, WithCustomCsvSettings {

	public $importJob;

	protected $decimalColumns = [
		'x',
		'y',
		'ipma1',
		'ipma2',
		'ipma3',
		'ipmb4',
		'ipmb5',
		'ipmc6',
		'ipmc7',
		'ipmc8',
		'ipmc9',
		'ipmc10',
		'ipmc11',
		'ipm',
		'x1',
		'y1',
	];

	public function __construct(SurveyImportJob $importJob) {
		$this->importJob = $importJob;
	}

	public function collection(Collection $array) {

		foreach($array as $family) { /* @var $family \Illuminate\Support\Collection */
			$family['id'] = UuidUtils::fromSurveyGUID($family['uniquerowid']);
			$family['import_id'] = $this->importJob->id;

			$this->convertIpmRisk($family);
			$this->convertDates($family);
			$this->convertDecimals($family);

			// Remove columns with no header
			$family = $family->filter(function ($value, $key) {
				return strlen(strval($key)) > 0;
			});

			ImportedFamily::create($family->toArray());

			logger()->debug("[survey_importer.family] Found: #{$family['id']} -> {$family['logradouro']}");
		}

	}

	private function convertIpmRisk(&$family) {
		if(!isset($family['risco_ipm'])) return;
		$family['risco_ipm'] = intval(substr($family['risco_ipm'], 6));
	}

	private function convertDates(&$family) {
		if(!isset($family['data'])) return;
		$family['data'] = CsvUtils::convertDateString($family['data']);
	}

	private function convertDecimals(&$family) {
		foreach($this->decimalColumns as $column) {
			if(!isset($family[$column])) continue;
			$family[$column] = CsvUtils::convertDecimalString($family[$column]);
		}
	}

	public function getCsvSettings(): array {
		return [
			'input_encoding' => 'UTF-8',
			'delimiter' => ';',
		];
	}

}