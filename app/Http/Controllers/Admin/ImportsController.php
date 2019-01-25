<?php
/**
 * rio-sgps
 * ImportsController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2019
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 13/01/2019, 17:31
 */

namespace SGPS\Http\Controllers\Admin;


use SGPS\Entity\Survey\SurveyImportJob;
use SGPS\Http\Controllers\Controller;
use SGPS\Jobs\ParseUploadedGeographyImport;
use SGPS\Jobs\ParseUploadedSurveyCSVJob;

class ImportsController extends Controller {

	public function dashboard() {

		$jobs = SurveyImportJob::query()->orderBy('created_at', 'desc')->take(6)->get();
		return view('admin.imports_dashboard', compact('jobs'));

	}

	public function import_survey_csv() {

		$importUUID = uniqid('import_', true);
		$familiesCSV = request()->file('families_csv')->storeAs('import/survey', "families_{$importUUID}.csv");
		$membersCSV = request()->file('members_csv')->storeAs('import/survey', "members_{$importUUID}.csv");;

		$importJob = SurveyImportJob::createFromFiles($familiesCSV, $membersCSV);

		dispatch(new ParseUploadedSurveyCSVJob($importJob));

		return redirect()->route('admin.imports.dashboard')->with('success', 'import_queued');

	}

	public function import_geography_csv() {
        $importUUID = uniqid('import_', true);

        $equipmentsCSV = request()->file('equipments_csv')->storeAs('import/geo', "equipments_{$importUUID}.csv");
        $sectorsCSV = request()->file('sectors_csv')->storeAs('import/geo', "sectors_{$importUUID}.csv");;

        dispatch(new ParseUploadedGeographyImport($equipmentsCSV, $sectorsCSV));

        return redirect()->route('admin.imports.dashboard')->with('success', 'import_queued');
    }

}
