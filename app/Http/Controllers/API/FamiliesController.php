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
 * Created at: 16/10/2018, 18:46
 */

namespace SGPS\Http\Controllers\API;


use SGPS\Entity\Family;
use SGPS\Http\Controllers\Controller;
use SGPS\Services\FamilyManagementService;

class FamiliesController extends Controller {

	public function add_member(Family $family, FamilyManagementService $service) {
		$memberName = request('member_name');

		$member = $service->addMemberToFamily($family, $memberName);

		$this->activityLog->writeToFamilyLog($family, "member_added", ['member' => $member]);

		return $this->api_success([
			'member_id' => $member->id,
		]);
	}

}