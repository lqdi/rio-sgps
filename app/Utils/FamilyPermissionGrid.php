<?php
/**
 * rio-sgps
 * FamilyPermissionGrid.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2019
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 27/01/2019, 20:52
 */

namespace SGPS\Utils;


use Illuminate\Support\Collection;
use SGPS\Entity\Entity;
use SGPS\Entity\Family;
use SGPS\Entity\User;
use SGPS\Services\UserPermissionsService;

class FamilyPermissionGrid {

	protected $grid;

	protected function __construct(Collection $grid) {
		$this->grid = $grid;
	}

	public function canEdit(Entity $entity) : bool {
		return $this->canEditWithID($entity->getEntityID());
	}

	public function canView(Entity $entity) : bool {
		return $this->canViewWithID($entity->getEntityID());
	}

	public function canViewWithID(string $entityID) : bool{
		if(!isset($this->grid[$entityID]['view'])) return false;
		return $this->grid[$entityID]['view'];
	}

	public function canEditWithID(string $entityID) : bool{
		if(!isset($this->grid[$entityID]['edit'])) return false;
		return $this->grid[$entityID]['edit'];
	}

	public static function build(User $user, Family $family, UserPermissionsService $permissionsService) {

		$grid = $family
			->fetchLinkedEntities()
			->keyBy('id')
			->map(function ($entity) use ($permissionsService, $user) {
				return [
					'id' => $entity->id,
					'view'=> $permissionsService->canViewEntity($user, $entity),
					'edit' => $permissionsService->canEditEntity($user, $entity),
				];
			});


		return new self($grid);
	}

}