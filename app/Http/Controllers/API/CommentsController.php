<?php
/**
 * rio-sgps
 * CommentsController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 17/09/2018, 18:13
 */

namespace SGPS\Http\Controllers\API;


use SGPS\Entity\Comment;
use SGPS\Entity\Entity;
use SGPS\Entity\User;
use SGPS\Http\Controllers\Controller;

class CommentsController extends Controller {

	public function fetch_thread(string $type, string $id) {
		$thread = Comment::fetchThreadFromEntity($type, $id);

		return $this->api_success([
			'comments' => $thread
		]);
	}

	public function post_comment(string $type, string $id) {

		$user = auth()->user(); /* @var $user User */
		$message = request('message');
		$entity = Entity::fetchByID($type, $id);

		// TODO: validate request (can user post comments? is message present? does entity exist?)

		Comment::post($type, $id, $user, $message);

		$this->activityLog->writeToFamilyLog($entity, "added_comment", ['message' => $message]);

		return $this->api_success();
	}

}