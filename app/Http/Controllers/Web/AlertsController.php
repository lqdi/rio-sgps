<?php
/**
 * rio-sgps
 * AlertsController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 23/10/2018, 13:42
 */

namespace SGPS\Http\Controllers\Web;


use SGPS\Entity\Family;
use SGPS\Entity\Sector;
use SGPS\Http\Controllers\Controller;
use SGPS\Services\FamilySearchService;

class AlertsController extends Controller {

	public function index(FamilySearchService $service) {

		$filters = request('filters', $service->defaultAlertFilters);

		$query = Family::query()
			->onlyAlerts()
			->with(['residence', 'personInCharge', 'allFlagAttributions', 'allActiveFlags'])
			->orderBy('created_at', 'desc');

		$query = $service->applyFiltersToQuery($query, collect($filters));

		$alerts = $query->paginate(24);
		$sectors = Sector::all();

		return view('alerts.alerts_index', compact('alerts', 'filters', 'sectors'));
	}

}