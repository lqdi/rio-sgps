<?php
/**
 * rio-sgps
 * DashboardController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 05/09/2018, 19:16
 */

namespace SGPS\Http\Controllers\Web;


use SGPS\Entity\FlagAttribution;
use SGPS\Entity\UserAssignment;
use SGPS\Http\Controllers\Controller;

class DashboardController extends Controller {

	public function post_login() {
		return view('dashboard.post_login_cover');
	}

	public function index() {
		$user = auth()->user(); /* @var $user \SGPS\Entity\User */
		$user->load(['groups', 'equipments.sectors']);

		$groupCodes = $user->groups->pluck('code');
		$sectorIDs = $user->equipments
			->map(function ($equipment) {
				return $equipment->sectors->pluck('id');
			})
			->flatten();

		$myGroupAttributions = FlagAttribution::fetchAllUnderGroups($groupCodes, ['entity', 'flag', 'residence'], 32);
		$myEquipmentAttributions = FlagAttribution::fetchAllUnderSectors($sectorIDs, ['entity', 'flag', 'residence'], 32);
		$myAssignments = UserAssignment::fetchByUser($user, ['entity.personInCharge', 'entity.residence']);

		return view('dashboard.operator_dashboard', compact('user',  'myGroupAttributions', 'myEquipmentAttributions', 'myAssignments'));
	}

}