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
use SGPS\Services\FlagAssignmentService;

class FlagsController extends Controller {

	public function index() {

		$flags = Flag::all();

		return $this->api_success([
			'flags' => $flags
		]);

	}

	public function cancel(Flag $flag, FlagAssignmentService $service) {
		// TODO: implement
	}

	public function add_to_entity(string $entity_type, string $entity_id, FlagAssignmentService $service) {

		$flag = Flag::findOrFail(request('flag_id')); /* @var $flag Flag */
		$referenceDate = Carbon::createFromFormat('Y-m-d', request('reference_date'));
		$deadline = intval(request('deadline'));

		$entity = Entity::fetchByID($entity_type, $entity_id);

		if($service->doesFlagExistInEntity($entity, $flag)) {
			return $this->api_failure('flag_already_exists');
		}

		$service->assignFlagToEntity($entity, $flag, $referenceDate, $deadline);

		return $this->api_success();

	}

}