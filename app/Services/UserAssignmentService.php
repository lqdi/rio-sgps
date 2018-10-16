<?php
/**
 * rio-sgps
 * UserAssignmentService.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 14/10/2018, 20:59
 */

namespace SGPS\Services;


use SGPS\Entity\Entity;
use SGPS\Entity\User;
use SGPS\Entity\UserAssignment;

class UserAssignmentService {

	/**
	 * Fetches an existing assignment between user and targeted entity.
	 * If an assignment is not found, returns null.
	 * @param User $user
	 * @param Entity $entity
	 * @return null|UserAssignment
	 */
	public function fetchExistingAssignment(User $user, Entity $entity) : ?UserAssignment {
		return $user->assignments()
			->where('entity_type', $entity->getEntityType())
			->where('entity_id', $entity->getEntityID())
			->first();
	}

	/**
	 * Assigns a user to a target entity.
	 * Will make the appropriate checks not to duplicate an existing assignment.
	 * If an assignment already exists, it will not be changed.
	 * @param User $user The assigned user
	 * @param Entity $entity The target entity
	 * @param string $assignmentType The assignment type; @see UserAssignment::TYPE_*
	 * @throws \InvalidArgumentException If the assignment type is not valid.
	 * @return UserAssignment The existing/created assignment
	 */
	public function assignUserToEntity(User $user, Entity $entity, string $assignmentType) : UserAssignment {

		if(!in_array($assignmentType, UserAssignment::TYPES)) {
			throw new \InvalidArgumentException("Invalid user assignment type: {$assignmentType}");
		}

		$existingAssignment = $this->fetchExistingAssignment($user, $entity);

		if($existingAssignment) {
			return $existingAssignment;
		}

		return UserAssignment::assignUserToEntity($user, $entity, $assignmentType);
	}

	/**
	 * Removes an user assignment.
	 * Will check if an assignment exists, and delete it if it does.
	 * Will do nothing if an assignment does not exist.
	 * @param User $user The previously assigned user
	 * @param Entity $entity The previously targeted entity
	 * @throws \Exception
	 */
	public function unassignUserFromEntity(User $user, Entity $entity) {

		$existingAssignment = $this->fetchExistingAssignment($user, $entity);

		if(!$existingAssignment) return;

		$existingAssignment->delete();
	}

}