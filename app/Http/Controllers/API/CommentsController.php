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


use SGPS\Constants\UserLevel;
use SGPS\Entity\Comment;
use SGPS\Entity\Entity;
use SGPS\Entity\User;
use SGPS\Http\Controllers\Controller;

class CommentsController extends Controller {

	public function fetch_thread(string $type, string $id) {

		$thread = Comment::fetchThreadFromEntity($type, $id);
		$currentUser = auth()->user();

	 	$thread = $thread->map(function ($comment) use ($currentUser) { /* @var $comment Comment */
			$comment->is_owned_by_me = $comment->isOwnedBy($currentUser);
			return $comment;
		});

		return $this->api_success([
			'comments' => $thread
		]);
	}

	public function post_comment(string $type, string $id) {

		$user = auth()->user(); /* @var $user User */
		$message = request('message');
		$entity = Entity::fetchByID($type, $id);

		if(!$entity) {
			return $this->api_failure('invalid_entity_reference');
		}

		if(strlen(trim($message)) <= 0) {
			return $this->api_success();
		}

		Comment::post($type, $id, $user, $message);

		$this->activityLog->writeToFamilyLog($entity, "added_comment", ['message' => $message]);

		return $this->api_success();
	}

	public function delete_comment(Comment $comment) {

		if(!$comment->isOwnedBy(auth()->user()) && auth()->user()->level !== UserLevel::ADMIN) {
			return $this->api_failure('not_allowed', [], 403);
		}

		$comment->delete();

		return $this->api_success();

	}

	public function update_comment(Comment $comment) {

		if(!$comment->isOwnedBy(auth()->user()) && auth()->user()->level !== UserLevel::ADMIN) {
			return $this->api_failure('not_allowed', [], 403);
		}

		$comment->message = request('message');
		$comment->save();

		return $this->api_success();

	}

}