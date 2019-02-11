<?php
/**
 * rio-sgps
 * ReportsController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2019
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 11/02/2019, 21:45
 */

namespace SGPS\Http\Controllers\API;


use Cache;
use SGPS\Entity\Reports;
use SGPS\Http\Controllers\Controller;

class ReportsController extends Controller {

	public function all_metrics() {

		$metrics = Cache::remember('Reports::all_metrics', 60, function() {
			return [
				'qty_visits' => Reports::qtyVisits(),
				'qty_young_referred_to_smdei' => Reports::qtyYoungReferredToSMDEI(),
				'qty_adult_referred_to_smdei' => Reports::qtyAdultReferredToSMDEI(),
				'qty_families_referred_to_cras' => Reports::qtyFamiliesReferredToCRAS(),
				'qty_families_arrived_at_cras' => Reports::qtyFamiliesArrivedAtCRAS(),
				'qty_recipients_bf' => Reports::qtyRecipientsBF(),
				'qty_persons_without_documentation' => Reports::qtyPersonsWithoutDocumentation(),
				'qty_persons_with_cadunico' => Reports::qtyPersonsWithCadUnico(),
				'qty_children_enrolled_at_ei' => Reports::qtyChildrenEnrolledAtEI(),
				'qty_children_enrolled_at_ef' => Reports::qtyChildrenEnrolledAtEF(),
			];
		});

		return response()->json(['status' => 'ok', 'metrics' => $metrics]);

	}

}