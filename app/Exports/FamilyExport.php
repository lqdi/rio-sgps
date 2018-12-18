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
use Maatwebsite\Excel\Concerns\WithMapping;
use SGPS\Entity\Family;
use SGPS\Entity\Question;

class FamilyExport implements FromCollection, WithHeadings, WithMapping {

	private $results = null;

	private $baseHeadings = [
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

	private $questionCodes = [];

	private $headings = [];

	public function __construct() {
		$families = Family::query()
			->with(['sector', 'residence', 'personInCharge', 'answers'])
			->get();

		$this->results = $families->map(function ($family) { /* @var $family \SGPS\Entity\Family */
			return collect($family->toExportArray(true));
		});

		$this->questionCodes = Question::query()
			->where('entity_type', 'family')
			->get(['code'])
			->pluck('code')
			->toArray();

		$this->headings = array_merge($this->baseHeadings, $this->questionCodes);
	}

	public function collection() {
		return $this->results;
	}

	public function map($family) : array {

		return collect($this->headings)
			->map(function ($key) use ($family) {
				return $family[$key] ?? '';
			})
			->toArray();
	}

	public function headings(): array {
		return $this->headings;
	}

}