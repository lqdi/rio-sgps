<?php
/**
 * rio-sgps
 * FamiliesController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 14/09/2018, 16:19
 */

namespace SGPS\Http\Controllers\Web;


use SGPS\Entity\Family;
use SGPS\Entity\Flag;
use SGPS\Http\Controllers\Controller;
use SGPS\Services\FamilySearchService;

class FamiliesController extends Controller {

	public function index(FamilySearchService $service) {

		$defaultFilters = [
			'status' => 'ongoing',
			'assigned_to' => 'all',
			'flags' => [],
			'q' => '',
		];

		$filters = request('filters', $defaultFilters);

		$query = Family::query()
			->with(['residence', 'personInCharge', 'allFlagAttributions', 'allActiveFlags'])
			->orderBy('created_at', 'desc');

		$query = $service->applyFiltersToQuery($query, collect($filters));

		$families = $query->paginate(24);

		return view('families.families_index', compact('families', 'filters'));

	}

	public function show(Family $family) {

		$family->load(['members.flags', 'residence.flags', 'personInCharge', 'allFlagAttributions']);

		return view('families.families_view', compact('family'));

	}

}