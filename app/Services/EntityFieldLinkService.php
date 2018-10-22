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

	public function updateEntityFields(Entity $entity, array $answers) {

		$linkedFields = config('question_links.' . $entity->getEntityType());

		foreach($linkedFields as $questionCode => $linkParams) {

			$fieldName = $linkParams[0];
			$fieldType = $linkParams[1];

			// Question was not answered
			if(!isset($answers[$questionCode])) continue;

			// Field is not fillable in entity
			if(!$entity->isFillable($fieldName)) continue;

			// Values are the same
			if($answers[$questionCode] === $entity->$fieldName) continue;

			// Sets the entity field
			$entity->$fieldName = $answers[$questionCode];

		}

		$entity->save();
	}

}