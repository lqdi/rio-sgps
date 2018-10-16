<?php
/**
 * rio-sgps
 * AssignmentsController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 14/10/2018, 21:01
 */

namespace SGPS\Http\Controllers\API;


use SGPS\Entity\Entity;
use SGPS\Entity\User;
use SGPS\Http\Controllers\Controller;
use SGPS\Services\UserAssignmentService;

class AssignmentsController extends Controller {

	public function index(Entity $entity) {

		$assignments = $entity->assignments()
			->with('user')
			->get();

		return $this->api_success([
			'assignments' => $assignments,
		]);

	}

	public function fetch_assignable_users(Entity $entity, UserAssignmentService $service) {

		// TODO: filter by entity (equipment / sector)

		$users = User::all()->sortBy('name');

		return $this->api_success([
			'users' => $users
		]);

	}

	public function assign(Entity $entity, UserAssignmentService $service) {

		$user = User::findOrFail(request('user_id'));
		$assignmentType = request('assignment_type');

		try {

			$assignment = $service->assignUserToEntity($user, $entity, $assignmentType);

		} catch (\Exception $ex) {
			return $this->api_exception($ex);
		}

		return $this->api_success([
			'assignment_id' => $assignment->id
		]);
	}

	public function unassign(Entity $entity, UserAssignmentService $service) {

		$user = User::findOrFail(request('user_id'));

		try {
			$service->unassignUserFromEntity($user, $entity);
		} catch (\Exception $ex) {
			return $this->api_exception($ex);
		}

		return $this->api_success();

	}

}