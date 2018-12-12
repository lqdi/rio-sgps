<?php

namespace SGPS\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use SGPS\Services\ActivityLogService;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $activityLog;

    public function __construct(ActivityLogService $activityLogService) {
    	$this->activityLog = $activityLogService;
    }

	public function api_success(array $data = [], int $statusCode = 200, array $headers = []) {
    	$data['status'] = 'ok';
    	return response()->json($data, $statusCode, $headers);
    }

    public function api_failure(string $reason, array $data = [], int $statusCode = 422, array $headers = []) {
    	$data['status'] = 'failed';
    	$data['reason'] = $reason;
    	return response()->json($data, $statusCode, $headers);
    }

    public function api_exception(\Exception $ex, string $reason = 'unexpected_exception', array $data = [], int $statusCode = 500, array $headers = []) {
    	$data['status'] = 'failed';
    	$data['reason'] = $reason;
    	$data['message'] = $ex->getMessage();
    	return response()->json($data, $statusCode, $headers);
    }
}
