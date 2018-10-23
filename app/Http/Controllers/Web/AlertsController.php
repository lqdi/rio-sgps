<?php
/**
 * rio-sgps
 * AlertsController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 23/10/2018, 13:42
 */

namespace SGPS\Http\Controllers\Web;


use SGPS\Http\Controllers\Controller;

class AlertsController extends Controller {

	public function index() {
		return view('alerts.alerts_index');
	}

}