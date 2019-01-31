<?php
/**
 * rio-sgps
 * ResidenceExport.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 18/12/2018, 15:28
 */

namespace SGPS\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use SGPS\Entity\Question;
use SGPS\Entity\Residence;
use SGPS\Services\FamilySearchService;

class ResidenceExport implements FromCollection, WithHeadings, WithMapping {

	private $results = null;

	private $baseHeadings = [
		'ID',
		'Código',
		'Setor',
		'Bairro',
		'AP',
		'RA',
		'RP',
		'CAP',
		'CASDH',
		'CMS',
		'CRAS',
		'CRE',
		'ESF',
		'Endereço',
		'Referência',
		'Latitude',
		'Longitude',
	];

	private $questionCodes = [];

	private $headings = [];

	public function __construct(array $filters = [], FamilySearchService $service) {
		$query = Residence::query()
			->with(['sector', 'answers'])
			->whereHas('families', function ($sq) use ($service, $filters) {
				$service->applyFiltersToQuery($sq, collect($filters));
				return $sq;
			})
			->orderBy('created_at', 'desc');

		$residences = $query->get();

		$this->results = $residences->map(function ($residence) { /* @var $residence \SGPS\Entity\Residence */
			return collect($residence->toExportArray(true));
		});

		$this->questionCodes = Question::query()
			->where('entity_type', 'residence')
			->get(['code'])
			->pluck('code')
			->toArray();

		$this->headings = array_merge($this->baseHeadings, $this->questionCodes);
	}

	public function collection() {
		return $this->results;
	}

	public function map($residence) : array {

		return collect($this->headings)
			->map(function ($key) use ($residence) {
				return $residence[$key] ?? '';
			})
			->toArray();
	}

	public function headings(): array {
		return $this->headings;
	}

}