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
use SGPS\Entity\Flag;

class FamilySearchService {

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
		if($filters->has('assigned_to') && strlen($filters['assigned_to']) > 0) {
			$query = $query->where(function ($sq) use ($filters) {
				return $this->filterByAssignment($sq, $filters['assigned_to']);
			});
		}
		if($filters->has('q') && strlen($filters['q']) > 0) {
			$query = $query->where(function ($sq) use ($filters) {
				return $this->filterByTextSearch($sq, $filters['q']);
			});
		}

		return $query;

	}

	public function filterByFlags(Builder $query, array $flags) : Builder {

		// TODO: refactor this
		// TODO: perhaps it is worth to refactor the AssignedFlag to always contain the family_id reference (flattens the query completely)

		$flagsByType = Flag::whereIn('id', $flags)->get()->groupBy('entity_type');

		if(sizeof($flagsByType['family'] ?? []) > 0) {
			$query->whereHas('flags', function($sq) use ($flagsByType) {
				return $sq->whereIn('flags.id', $flagsByType['family']);
			});
		}

		if(sizeof($flagsByType['residence'] ?? []) > 0) {
			$query->orWhereHas('residence.flags', function($sq) use ($flagsByType) {
				return $sq->whereIn('flags.id', $flagsByType['residence']);
			});
		}

		if(sizeof($flagsByType['person'] ?? []) > 0) {
			$query->orWhereHas('members.flags', function($sq) use ($flagsByType) {
				return $sq->whereIn('flags.id', $flagsByType['person']);
			});
		}


		return $query;
	}

	public function filterByStatus(Builder $query, string $statusMode) : Builder {
		// TODO: status = archived when no flags are applied on the family or any of the members/residence
		return $query;
	}

	public function filterByAssignment(Builder $query, string $assignmentMode) : Builder {
		// TODO: if filtering by to_me, whereHas('assignment') where('assignment.user_id', auth()->user()->id()
		return $query;
	}

	public function filterByTextSearch(Builder $query, string $searchQuery) : Builder {
		// TODO: match against? sphinx?
		// TODO: might be worth using Laravel Scout
		// TODO: create "query" body for the family with all searchable params (address, codes, names & CPFs of all members, etc)
		return $query;
	}

}