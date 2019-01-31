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
use SGPS\Entity\Person;
use SGPS\Entity\Question;
use SGPS\Entity\QuestionAnswer;
use SGPS\Http\Controllers\Controller;
use SGPS\Services\FamilyManagementService;

class FamiliesController extends Controller {

	public function add_member(Family $family, FamilyManagementService $service) {

		if(!$this->permissions->canEditEntity($this->currentUser, $family)) {
			return $this->api_failure('user_cannot_edit_entity');
		}

		$memberName = request('member_name');

		$member = $service->addMemberToFamily($family, $memberName);

		$this->activityLog->writeToFamilyLog($family, "member_added", ['member' => $member]);

		return $this->api_success([
			'member_id' => $member->id,
		]);
	}

	public function archive_member(Family $family, Person $member, FamilyManagementService $service) {

		if(!$this->permissions->canEditEntity($this->currentUser, $family)) {
			return $this->api_failure('user_cannot_edit_entity');
		}

		$reason = request('reason');

		if($member->family_id !== $family->id) {
			return $this->api_failure('member_not_from_family');
		}

		try {
			$service->archiveFamilyMember($family, $member, $reason);
		} catch (\Exception $e) {
			return $this->api_exception($e);
		}

		$this->activityLog->writeToFamilyLog($family, "member_archived", ['member' => $member, 'reason' => $reason]);

		return $this->api_success();

	}

}