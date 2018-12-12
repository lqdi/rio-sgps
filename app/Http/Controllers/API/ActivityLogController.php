<?php
/**
 * rio-sgps
 * ActivityLogController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 12/12/2018, 16:48
 */

namespace SGPS\Http\Controllers\API;


use SGPS\Entity\Entity;
use SGPS\Http\Controllers\Controller;

class ActivityLogController extends Controller {

	public function fetch_thread(Entity $entity) {

		if($entity->getEntityType() !== 'family') {
			return $this->api_failure('not_allowed', [], 403);
		}

		$max = max( intval(request('max', 32)), 128);
		$offset = intval(request('offset', 0));

		$entries = $this->activityLog->fetchFamilyLog($entity, $max, $offset);

		// TODO: filter data depending on event?

		return $this->api_success([
			'entries' => $entries
		]);

	}

}