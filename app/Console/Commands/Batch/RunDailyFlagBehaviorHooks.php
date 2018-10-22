<?php
/**
 * rio-sgps
 * RunDailyFlagBehaviorHooks.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 22/10/2018, 01:08
 */

namespace SGPS\Console\Commands\Batch;


use Carbon\Carbon;
use Illuminate\Console\Command;
use SGPS\Services\FlagBehaviorService;

class RunDailyFlagBehaviorHooks extends Command {

	protected $signature = 'batch:run_daily_flag_behavior_hooks';
	protected $description = 'Runs the daily hook for flag behaviors';

	public function handle(FlagBehaviorService $flagBehaviorService) {

		$today = Carbon::now();
		$flagBehaviorService->evaluateBehaviorsForDailyCron($today);

	}

}