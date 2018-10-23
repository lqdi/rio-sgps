<?php
/**
 * rio-sgps
 * PrintController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 23/10/2018, 13:50
 */

namespace SGPS\Http\Controllers\Web;


use SGPS\Http\Controllers\Controller;

class PrintController extends Controller {

	public function sample_print() {
		return view('print.encaminhamento_equipamento');
	}

}