<?php
/**
 * rio-sgps
 * CheckUserLevel.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2019
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 27/01/2019, 19:12
 */

namespace SGPS\Http\Middleware;


use Auth;
use Closure;
use Illuminate\Auth\AuthenticationException;
use SGPS\Entity\User;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CheckUserLevel {

	/**
	 * @param $request
	 * @param Closure $next
	 * @param string|null $level
	 * @return mixed
	 * @throws AuthenticationException
	 */
	public function handle($request, Closure $next, $level) {

		$user = Auth::guard()->user(); /* @var $user User */

		if(!$user) {
			throw new AuthenticationException('unauthenticated');
		}

		if(!$user->hasLevel($level)) {
			throw new AccessDeniedHttpException('insufficient_permissions');
		}

		return $next($request);
	}


}