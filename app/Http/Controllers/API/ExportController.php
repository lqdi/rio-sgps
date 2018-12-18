<?php
/**
 * rio-sgps
 * ExportController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 17/12/2018, 18:33
 */

namespace SGPS\Http\Controllers\API;


use Excel;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use SGPS\Exports\FamilyExport;
use SGPS\Http\Controllers\Controller;
use SGPS\Services\FamilySearchService;

class ExportController extends Controller {

	public function export_families(FamilySearchService $service) {

		$filters = request('filters', []);

		$fileName = uniqid(time(), true) . '.xls';
		$downloadURL = url('storage/export/' . $fileName);
		$exportPath = 'public/export/' . $fileName;

		try {
			Excel::store(new FamilyExport($filters, $service), $exportPath);
		} catch (Exception $e) {
			return $this->api_exception($e);
		} catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
			return $this->api_failure('xls_failed', ['error' => $e]);
		}

		return $this->api_success([
			'download_url' => $downloadURL,
		]);

	}

}