<?php

namespace SGPS\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use SGPS\Services\ActivityLogService;
use SGPS\Services\UserPermissionsService;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	/**
	 * The activity log service.
	 * Use this to query or register new activity in the system.
	 *
	 * @var ActivityLogService
	 */
    public $activityLog;

	/**
	 * The user permissions service.
	 * Use this to check user permissions against actions, entities, etc.
	 *
	 * @var UserPermissionsService
	 */
    public $permissions;

	/**
	 * The current user.
	 * Will be null if not logged in.
	 *
	 * @var \SGPS\Entity\User|\Illuminate\Contracts\Auth\Authenticatable|null
	 */
    public $currentUser;

	/**
	 * Controller constructor.
	 * Default auto-wiring for services.
	 *
	 * @param ActivityLogService $activityLogService
	 * @param UserPermissionsService $permissionsService
	 */
    public function __construct(ActivityLogService $activityLogService, UserPermissionsService $permissionsService) {
    	$this->activityLog = $activityLogService;
    	$this->permissions = $permissionsService;

	    $this->middleware(function ($request, $next) {
		    $this->currentUser = auth()->user();
		    return $next($request);
	    });
    }

	/**
	 * Generates successful API response.
	 *
	 * @param array $data
	 * @param int $statusCode
	 * @param array $headers
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function api_success(array $data = [], int $statusCode = 200, array $headers = []) {
    	$data['status'] = 'ok';
    	return response()->json($data, $statusCode, $headers);
    }

	/**
	 * Generates failure API response, with reason parameter.
	 *
	 * @param string $reason
	 * @param array $data
	 * @param int $statusCode
	 * @param array $headers
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function api_failure(string $reason, array $data = [], int $statusCode = 422, array $headers = []) {
    	$data['status'] = 'failed';
    	$data['reason'] = $reason;
    	return response()->json($data, $statusCode, $headers);
    }

	/**
	 * Generates unexpected exception API response.
	 *
	 * @param \Exception $ex
	 * @param string $reason
	 * @param array $data
	 * @param int $statusCode
	 * @param array $headers
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function api_exception(\Exception $ex, string $reason = 'unexpected_exception', array $data = [], int $statusCode = 500, array $headers = []) {
    	$data['status'] = 'failed';
    	$data['reason'] = $reason;
    	$data['message'] = $ex->getMessage();
    	return response()->json($data, $statusCode, $headers);
    }
}
