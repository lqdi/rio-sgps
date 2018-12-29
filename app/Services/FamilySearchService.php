<?php
/**
 * rio-sgps
 * FamilySearchService.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 17/10/2018, 12:35
 */

namespace SGPS\Services;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use SGPS\Entity\Family;
use SGPS\Entity\Flag;
use SGPS\Utils\Sanitizers;

class FamilySearchService {

	public $defaultCaseFilters = [
		'status' => 'ongoing',
		'assigned_to' => 'all',
		'flags' => [],
		'q' => '',
	];

	public $defaultAlertFilters = [
		'visit_status' => 'pending',
		'sector_id' => '',
		'q' => '',
	];

	public function applyFiltersToQuery(Builder $query, Collection $filters) : Builder {

		if($filters->has('flags') && is_array($filters['flags']) && sizeof($filters['flags']) > 0) {
			$query = $query->where(function ($sq) use ($filters) {
				return $this->filterByFlags($sq, $filters['flags']);
			});
		}
		if($filters->has('status') && strlen($filters['status']) > 0) {
			$query = $query->where(function ($sq) use ($filters) {
				return $this->filterByStatus($sq, $filters['status']);
			});
		}

		if($filters->has('sector_id') && strlen($filters['sector_id']) > 0) {
			$query = $query->where('sector_id', $filters['sector_id']);
		}

		if($filters->has('visit_status') && strlen($filters['visit_status']) > 0) {
			$query = $query->where(function ($sq) use ($filters) {
				return $this->filterByVisitStatus($sq, $filters['visit_status']);
			});
		}
		if($filters->has('assigned_to') && strlen($filters['assigned_to']) > 0) {
			$query = $query->where(function ($sq) use ($filters) {
				return $this->filterByAssignment($sq, $filters['assigned_to']);
			});
		}

		if($filters->has('q') && strlen($filters['q']) > 0) {
			$searchQuery = Sanitizers::clearForSearch($filters['q']);
			$foundInIndex = $this->buildTextSearch($searchQuery)->get();

			$query = $query->whereIn('id', $foundInIndex->pluck('id'));
		}

		return $query;

	}

	public function filterByFlags(Builder $query, array $flags) : Builder {

		return $query->whereHas('allFlagAttributions', function($sq) use ($flags) {
			return $sq->whereIn('flag_id', $flags);
		});

	}

	public function filterByStatus(Builder $query, string $statusMode) : Builder {

		$filterCompletedOrCancelled = function ($sq) {
			return $sq->where('is_cancelled', false)->where('is_completed', false);
		};

		return ($statusMode === 'archived')
			? $query->whereHas('allFlagAttributions', $filterCompletedOrCancelled, '=', 0)
			: $query->whereHas('allFlagAttributions', $filterCompletedOrCancelled, '>', 0);

	}

	public function filterByVisitStatus(Builder $query, string $statusMode) : Builder {

		switch($statusMode) {
			case 'pending':
				return $query->whereIn('visit_status', [Family::VISIT_PENDING_AGENT, Family::VISIT_LATE_TO_CRAS]);
			case 'delivered':
				return $query->whereIn('visit_status', [Family::VISIT_DELIVERED]);
			case 'noshow':
				return $query->whereIn('visit_status', [Family::VISIT_PENDING_TECHNICAL_VISIT]);
		}

	}

	public function filterByAssignment(Builder $query, string $assignmentMode) : Builder {
		if($assignmentMode === 'all') return $query;

		return $query->whereHas('assignments', function ($sq) {
			$sq->where('user_id', auth()->id());
		});
	}

	public function buildTextSearch(string $searchQuery) : \Laravel\Scout\Builder {
		return Family::search($searchQuery);
	}

}