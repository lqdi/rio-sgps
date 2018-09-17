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
 * Created at: 17/09/2018, 19:08
 */

namespace SGPS\Http\Controllers\Admin;


use SGPS\Http\Controllers\Controller;

class DashboardController extends Controller {

	public function index() {
		return view('admin.admin_dashboard');
	}

}