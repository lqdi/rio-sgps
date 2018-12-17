<?php
/**
 * rio-sgps
 * FamilyExport.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 17/12/2018, 19:13
 */

namespace SGPS\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use SGPS\Entity\Family;
use SGPS\Entity\Question;

class FamilyExport implements FromCollection {

	private $results = null;
	private $headings = [];

	public function __construct() {
		$families = Family::query()
			->with(['sector', 'residence', 'personInCharge', 'answers'])
			->get();

		$this->results = $families->map(function ($family) { /* @var $family \SGPS\Entity\Family */
			return collect($family->toExportArray(true));
		});
	}

	public function collection() {
		return $this->results;
	}

	public function headings(): array {

		// TODO: fix this by correctly building the responses array with ordered headers

		$baseHeadings = [
			'ID',
			'Código',
			'Responsável',
			'Setor',
			'Bairro',
			'AP',
			'RA',
			'RP',
			'Endereço',
			'Referência',
			'Latitude',
			'Longitude',
		];

		$questionHeadings = Question::query()
			->where('entity_type', 'family')
			->get(['code'])
			->pluck('code')
			->toArray();

		return array_merge($baseHeadings, $questionHeadings);
	}

}