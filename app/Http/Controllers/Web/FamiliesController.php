<?php
/**
 * rio-sgps
 * FamiliesController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 14/09/2018, 16:19
 */

namespace SGPS\Http\Controllers\Web;


use SGPS\Entity\Family;
use SGPS\Entity\Flag;
use SGPS\Http\Controllers\Controller;

class FamiliesController extends Controller {

	public function index() {

		$families = Family::query()
			->with(['residence', 'personInCharge', 'flags'])
			->orderBy('created_at', 'desc')
			->paginate(24);

		$flags = Flag::all();

		return view('families.families_index', compact('families', 'flags'));

	}

}