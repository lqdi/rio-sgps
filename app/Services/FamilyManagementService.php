<?php
/**
 * rio-sgps
 * FamilyManagementService.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 16/10/2018, 18:51
 */

namespace SGPS\Services;


use SGPS\Entity\Family;
use SGPS\Entity\Person;

class FamilyManagementService {

	public function addMemberToFamily(Family $family, string $memberName) : Person {

		return Person::create([
			'family_id' => $family->id,
			'residence_id' => $family->residence_id,
			'sector_id' => $family->sector_id,
			'name' => $memberName,
		]);

	}

}