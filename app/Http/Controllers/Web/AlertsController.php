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


use SGPS\Entity\Equipment;
use SGPS\Entity\Family;
use SGPS\Entity\Sector;
use SGPS\Http\Controllers\Controller;
use SGPS\Services\FamilySearchService;

class AlertsController extends Controller {

	public function index(FamilySearchService $service) {

		$filters = array_merge($service->defaultAlertFilters, request('filters', []));

        $filterOptions = cache()->remember('family_filter_options', 60, function () {
            return [
                'sector_cre' => Sector::fetchAvailableGroupingCodes('cod_cre'),
                'sector_casdh' => Sector::fetchAvailableGroupingCodes('cod_casdh'),
                'sector_cap' => Sector::fetchAvailableGroupingCodes('cod_cap'),
            ];
        });

		$query = Family::query()
			->with([
				'residence',
				'sector',
				'flags.groups',
				'personInCharge',
			])
			->onlyAlerts()
			->orderBy('created_at', 'desc');

		$query = $service->applyFiltersToQuery($query, collect($filters));

		$alerts = $query->paginate(24);

		return view('alerts.alerts_index', compact('alerts', 'filters', 'filterOptions'));
	}

	public function mark_as_delivered(Family $family) {

		if(!$family->is_alert) {
			return redirect()->route('alerts.index')->with('error', 'family_not_alert');
		}

		if(!$this->permissions->canEditEntity($this->currentUser, $family)) {
			return $this->api_failure('user_cannot_edit_entity');
		}

		$family->markAsDelivered();

		$this->activityLog->writeToFamilyLog($family, 'alert_marked_as_delivered', ['attempt' => $family->visit_attempt]);

		return redirect()->route('alerts.index')->with('success', 'family_delivered');

	}

	public function open_case(Family $family) {
		if(!$family->is_alert) {
			return redirect()->route('alerts.index')->with('error', 'family_not_alert');
		}

		if(!$this->permissions->canEditEntity($this->currentUser, $family)) {
			return redirect()->route('alerts.index')->with('error', 'user_cannot_edit_entity');
		}

		$family->openCase(auth()->user());

		$this->activityLog->writeToFamilyLog($family, 'alert_case_opened');

		return redirect()->route('families.show', [$family->id]);
	}

	public function print_referral(Family $family) {

		$family->load(['personInCharge', 'residence', 'sector', 'sector.equipments']);

		if(!$family->sector) {
			die("Código de setor não cadastrado no sistema: {$family->sector_id}");
		}

		$cras = $family->sector->equipments->where('type', Equipment::TYPE_CRAS)->first();

		if(!$cras) {
			die("Setor {$family->sector_id} não possui uma CRAS associada!");
		}

		$cre = $family->sector->equipments->where('type', Equipment::TYPE_CRE)->first();

		if(!$cre) {
			die("Setor {$family->sector_id} não possui uma CRE associada!");
		}

		return view('print.alert_forwarding_single', [
			'alert' => $family,
			'cras' => $cras,
			'cre' => $cre
		]);
	}

	public function print_all_referrals(FamilySearchService $service) {

		$filters = request('filters', $service->defaultAlertFilters);

		$query = Family::query()
			->onlyAlerts()
			->with(['personInCharge', 'residence', 'sector', 'sector.equipments'])
			->orderBy('created_at', 'asc');

		$query = $service->applyFiltersToQuery($query, collect($filters));
		$alerts = $query->get()->map(function ($family) {
			if(!$family->sector) {
				die("Código de setor não cadastrado no sistema: {$family->sector_id}");
			}

			$cras = $family->sector->equipments->where('type', Equipment::TYPE_CRAS)->first();

			if(!$cras) {
				die("Setor {$family->sector_id} não possui uma CRAS associada!");
			}

			$cre = $family->sector->equipments->where('type', Equipment::TYPE_CRE)->first();

			if(!$cre) {
				die("Setor {$family->sector_id} não possui uma CRE associada!");
			}

			$family->cras = $cras;
			$family->cre = $cre;

			return $family;
		});


		return view('print.alert_forwarding_multiple', compact('alerts'));

	}

}
