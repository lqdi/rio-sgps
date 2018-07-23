<?php
/**
 * rio-sgps
 * WireframeController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 23/07/2018, 17:46
 */

namespace SGPS\Http\Controllers;


class WireframeController extends Controller {

	public function index() {
		$pages = collect(glob(resource_path('views/') . '*'))
			->map(function ($viewFile) {
				return str_replace('.blade.php', '', basename($viewFile));
			});
		
		return view('wireframe_index', compact('pages'));
	}

	public function view_page($view) {
		return view($view);
	}

}