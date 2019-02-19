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
use SGPS\Entity\Residence;
use SGPS\Entity\Sector;
use SGPS\Http\Controllers\Controller;
use SGPS\Services\FamilySearchService;
use SGPS\Utils\FamilyPermissionGrid;

class FamiliesController extends Controller {

	public function index(FamilySearchService $service) {

		$filters = array_merge($service->defaultCaseFilters, request('filters', []));

		$filterOptions = cache()->remember('family_filter_options', 60, function () {
			return [
				'sector_cre' => Sector::fetchAvailableGroupingCodes('cod_cre'),
				'sector_casdh' => Sector::fetchAvailableGroupingCodes('cod_casdh'),
				'sector_cap' => Sector::fetchAvailableGroupingCodes('cod_cap'),
			];
		});

		$query = Family::query()
			->notAlerts()
			->with(['residence', 'personInCharge', 'allFlagAttributions', 'allActiveFlags'])
			->orderBy('created_at', 'desc');

		$query = $service->applyFiltersToQuery($query, collect($filters));

		$families = $query->paginate(24);

		return view('families.families_index', compact('families', 'filters', 'filterOptions'));

	}

	public function go_to_residence(Residence $residence) {
		$family = $residence->families->first();
		return redirect()->route('families.show', [$family->id, '#residence']);
	}

	public function show(Family $family) {

		$this->currentUser->load('assignments');

		$family->load([
			'flags.groups',
			'members.flags.groups',
			'residence.flags.groups',
			'sector.equipments',
			'personInCharge',
			'allFlagAttributions',
			'caseOpenedBy'
		]);

		$permissions = FamilyPermissionGrid::build($this->currentUser, $family, $this->permissions);

		return view('families.families_view', compact('family', 'permissions'));

	}

}