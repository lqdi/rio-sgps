<?php
/**
 * rio-sgps
 * EntityFieldLinkService.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 22/10/2018, 20:36
 */

namespace SGPS\Services;


use SGPS\Entity\Entity;

class EntityFieldLinkService {

	/**
	 * @param Entity $entity
	 * @param array $answers
	 * @return bool
	 */
	public function updateEntityFields(Entity $entity, array $previousAnswers, array $answers) : bool {

		$linkedFields = config('question_links.' . $entity->getEntityType());
		$hasChanges = false;

		foreach($linkedFields as $questionCode => $linkParams) {

			$fieldName = $linkParams[0];
			$fieldType = $linkParams[1];

			// Question was not answered
			if(!isset($answers[$questionCode])) continue;

			// Field is not fillable in entity
			if(!$entity->isFillable($fieldName)) continue;

			// Values are the same
			if(isset($previousAnswers[$questionCode]) && strval($answers[$questionCode]) === strval($previousAnswers[$questionCode])) continue;

			// Sets the entity field
			$entity->$fieldName = $answers[$questionCode];

			$hasChanges = true;

		}

		if($hasChanges) {
			$entity->save();
		}

		return $hasChanges;
	}

}