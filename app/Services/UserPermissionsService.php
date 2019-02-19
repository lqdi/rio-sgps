<?php
/**
 * rio-sgps
 * UserPermissionsService.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2019
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 27/01/2019, 20:09
 */

namespace SGPS\Services;

use SGPS\Constants\UserLevel;
use SGPS\Entity\Entity;
use SGPS\Entity\User;
use SGPS\Entity\UserAssignment;

class UserPermissionsService {

	const ASSIGNMENTS_THAT_CAN_EDIT = [UserAssignment::TYPE_ACTING, UserAssignment::TYPE_CREATOR];

	private $userAssignmentService;

	public function __construct(UserAssignmentService $userAssignmentService) {
		$this->userAssignmentService = $userAssignmentService;
	}

	/**
	 * Checks if an user can perform the given action.
	 * Will be checked by their user level.
	 * @param User $user
	 * @param string $action
	 * @return bool
	 */
	public function canPerformAction(User $user, string $action) : bool {

		if(in_array($action, config('user_level_permissions.' . $user->level, []))) {
			return true;
		}

		$isAllowedByGroupPerms = ($user->getGroupCodes()->first(function ($groupCode) use ($action) {
			return in_array($action, config('group_permissions.' . $groupCode, []));
		}) !== null);

		if($isAllowedByGroupPerms) {
			return true;
		}

		return false;
	}

	/**
	 * Checks if the user can view the given entity, by checking the following specifications:
	 * - Any user can view anything.
	 * @param User $user
	 * @param Entity $entity
	 * @return bool
	 */
	public function canViewEntity(User $user, Entity $entity) : bool {
		return true;
	}

	/**
	 * Checks if the user can edit the given entity, by checking the following specifications:
	 * - Admins & gestores can edit everything;
	 * - Coordenadores can edit when linked to groups/equipments;
	 * - Operador can edit when linked to own equipaments.
	 *
	 * @param User $user
	 * @param Entity $entity
	 * @return bool
	 */
	public function canEditEntity(User $user, Entity $entity) : bool {

		if($user->hasLevel(UserLevel::GESTOR)) {
			return true;
		}

		$parentFamily = $entity->getEntityType() === 'person'
			? $entity->family
			: $entity;

		if($parentFamily->getEntityType() === 'family' && $user->isAssignedToEntity($parentFamily, self::ASSIGNMENTS_THAT_CAN_EDIT)) {
			return true;
		}

		if($user->hasLevel(UserLevel::COORDENADOR) && $this->userHasGroupsForEntityFlags($user, $entity)) {
			return true;
		}

		return $this->userHasAnyEntityEquipment($user, $entity);

	}

	/**
	 * Checks if the user shares any groups with the flags applied to the entity.
	 * @param User $user
	 * @param Entity $entity
	 * @return bool
	 */
	public function userHasGroupsForEntityFlags(User $user, Entity $entity) {

		$groupIDsToSearchFor = $entity->resolveLinkedGroups()->pluck('id');
		$userGroupIDs = $user->groups->pluck('id');

		return $userGroupIDs->intersect($groupIDsToSearchFor)->isNotEmpty();

	}

	/**
	 * Checks if the user shares any equipments with the entity.
	 * @param User $user
	 * @param Entity $entity
	 * @return bool
	 */
	public function userHasAnyEntityEquipment(User $user, Entity $entity) {

		// Gets the list of equipment IDs for the entity sector.
		$equipmentIDsToSearchFor = $entity->resolveLinkedEquipments()->pluck('id');
		$userEquipmentIDs = $user->equipments->pluck('id');

		//dump($entity->getEntityType(), $equipmentIDsToSearchFor->toArray(), $userEquipmentIDs->toArray());

		return $userEquipmentIDs->intersect($equipmentIDsToSearchFor)->isNotEmpty();

	}

}