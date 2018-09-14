<?php
/**
 * rio-sgps
 * DashboardController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 05/09/2018, 19:16
 */

namespace SGPS\Http\Controllers\Web;


use SGPS\Http\Controllers\Controller;

class DashboardController extends Controller {

	public function index() {
		return view('dashboard.operator_dashboard');
	}

}