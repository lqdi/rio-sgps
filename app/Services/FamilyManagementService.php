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

	/**
	 * Adds a member to the family.
	 * @param Family $family
	 * @param string $memberName
	 * @return Person
	 */
	public function addMemberToFamily(Family $family, string $memberName) : Person {

		return Person::create([
			'family_id' => $family->id,
			'residence_id' => $family->residence_id,
			'sector_id' => $family->sector_id,
			'name' => $memberName,
		]);

	}

	/**
	 * Archives a member from the family.
	 * @param Family $family
	 * @param Person $member
	 * @param string $reason
	 * @throws \Exception
	 */
	public function archiveFamilyMember(Family $family, Person $member, string $reason) : void {
		$member->archive($reason);
	}

}