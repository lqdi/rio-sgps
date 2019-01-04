<?php
/**
 * rio-sgps
 * CheckLateAlerts.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2019
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 04/01/2019, 10:56
 */

namespace SGPS\Console\Commands\Batch;


use Illuminate\Console\Command;
use SGPS\Entity\Family;

class CheckLateAlerts extends Command {

	protected $signature = 'batch:check_late_alerts';
	protected $description = '';

	public function handle() {

		$lateAlerts = Family::fetchAlertsLateToCRAS();

		if(sizeof($lateAlerts) <= 0) {
			$this->info("No late alerts found!");
			return;
		}

		$this->info("Updating " . sizeof($lateAlerts) . " late alerts...");

		foreach($lateAlerts as $alert) { /* @var $alert \SGPS\Entity\Family */
			$alert->returnToPending();
			$this->comment("Updated late alert: {$alert->id} / {$alert->shortcode}");
		}

		$this->info("Done!");

	}

}