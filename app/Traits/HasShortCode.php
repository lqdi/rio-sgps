<?php
/**
 * rio-sgps
 * HasShortCode.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 14/09/2018, 16:31
 */

namespace SGPS\Traits;


use SGPS\Utils\Shortcode;

trait HasShortCode {

	protected static function bootHasShortCode() {
		static::creating(function ($model) {
			if(isset($model->shortcode)) return;
			$prefix = 'RJ-' . substr(get_called_class(), 0, 1) . '-';
			$model->shortcode = Shortcode::generate($prefix);
		});
	}

}