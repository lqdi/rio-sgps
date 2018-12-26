<?php
/**
 * rio-sgps
 * CsvUtils.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 26/12/2018, 15:48
 */

namespace SGPS\Utils;


use Carbon\Carbon;

class CsvUtils {

	public static function convertDecimalString(?string $in) : ?string {
		if(!$in) return $in;
		return str_replace(',', '.', str_replace(['.', ' '], '', $in));
	}

	public static function convertDateString(?string $in) : ?string {
		// from: 16/10/2018 03:00:00

		if(!$in) return $in;
		if(strlen(trim($in)) !== 19) throw new \InvalidArgumentException("Invalid CSV date: {$in}");

		return Carbon::createFromFormat('d/m/Y H:i:s', $in)->toDateTimeString();
	}

}