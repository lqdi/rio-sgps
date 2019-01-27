<?php
/**
 * rio-sgps
 * FlagsController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 09/10/2018, 20:00
 */

namespace SGPS\Http\Controllers\API;


use Carbon\Carbon;
use SGPS\Entity\Entity;
use SGPS\Entity\Flag;
use SGPS\Http\Controllers\Controller;
use SGPS\Services\FlagAttributionService;

class FlagsController extends Controller {

	public function index() {

		$flags = Flag::all();

		return $this->api_success([
			'flags' => $flags
		]);

	}

	public function cancel(Entity $entity, Flag $flag, FlagAttributionService $service) {

		if(!$this->permissions->canEditEntity($this->currentUser, $entity)) {
			return $this->api_failure('user_cannot_edit_entity');
		}

		if(!$service->isFlagAttributedToEntity($entity, $flag)) {
			return $this->api_failure('flag_not_assigned');
		}

		$service->cancelFlagAttribution($entity, $flag);
		$this->activityLog->writeToFamilyLog($entity, "flag_cancelled", ['entity' => $entity->toBasicJson(), 'flag' => $flag->toBasicJson()]);


		return $this->api_success();
	}

	public function complete(Entity $entity, Flag $flag, FlagAttributionService $service) {

		if(!$this->permissions->canEditEntity($this->currentUser, $entity)) {
			return $this->api_failure('user_cannot_edit_entity');
		}

		if(!$service->isFlagAttributedToEntity($entity, $flag)) {
			return $this->api_failure('flag_not_assigned');
		}

		$service->completeFlagAttribution($entity, $flag);
		$this->activityLog->writeToFamilyLog($entity, "flag_completed", ['entity' => $entity->toBasicJson(), 'flag' => $flag->toBasicJson()]);


		return $this->api_success();
	}

	public function add_to_entity(Entity $entity, FlagAttributionService $service) {

		if(!$this->permissions->canEditEntity($this->currentUser, $entity)) {
			return $this->api_failure('user_cannot_edit_entity');
		}

		$flag = Flag::findOrFail(request('flag_id')); /* @var $flag Flag */
		$referenceDate = Carbon::createFromFormat('Y-m-d', request('reference_date'));
		$deadline = intval(request('deadline'));

		if($service->isFlagAttributedToEntity($entity, $flag)) {
			return $this->api_failure('flag_already_exists');
		}

		$service->attributeFlagToEntity($entity, $flag, $referenceDate, $deadline);
		$this->activityLog->writeToFamilyLog($entity, "flag_added", ['entity' => $entity->toBasicJson(), 'flag' => $flag->toBasicJson()]);


		return $this->api_success();

	}

}