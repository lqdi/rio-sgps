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

	public function mark_as_delivered(Family $family) {

		if(!$family->is_alert) {
			return redirect()->route('alerts.index')->with('error', 'family_not_alert');
		}

		$family->markAsDelivered();

		$this->activityLog->writeToFamilyLog($family, 'alert_marked_as_delivered', ['attempt' => $family->visit_attempt]);

		return redirect()->route('alerts.index')->with('success', 'family_delivered');

	}

	public function open_case(Family $family) {
		if(!$family->is_alert) {
			return redirect()->route('alerts.index')->with('error', 'family_not_alert');
		}

		$family->openCase(auth()->user());

		$this->activityLog->writeToFamilyLog($family, 'alert_case_opened');

		return redirect()->route('families.show', [$family->id]);
	}

	public function print_referral(Family $family) {
		$alerts = collect([$family]);

		// TODO: render print view
	}

	public function print_all_referrals(FamilySearchService $service) {

		$filters = request('filters', $service->defaultAlertFilters);

		$query = Family::query()
			->onlyAlerts()
			->with(['residence', 'personInCharge', 'allFlagAttributions', 'allActiveFlags'])
			->orderBy('created_at', 'desc');

		$query = $service->applyFiltersToQuery($query, collect($filters));
		$alerts = $query->get();

		// TODO: render print view

	}

}