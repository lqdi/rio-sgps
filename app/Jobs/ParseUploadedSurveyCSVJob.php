<?php
/**
 * rio-sgps
 * ImportSurveyCSVJob.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2019
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 13/01/2019, 17:29
 */

namespace SGPS\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use SGPS\Entity\Survey\SurveyImportJob;
use SGPS\Services\FamilyImportService;

class ParseUploadedSurveyCSVJob implements ShouldQueue {

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $importJob;

    public function __construct(SurveyImportJob $importJob) {
        $this->importJob = $importJob;
    }

    public function handle(FamilyImportService $service) {

    	$this->importJob->updateStage(SurveyImportJob::STAGE_CSV_READ);

	    $service->readFromCSV($this->importJob, 'local');

	    $this->importJob->refreshReadCounts();

	    $this->importJob->updateStage(SurveyImportJob::STAGE_GENERATE_FAMILIES);

	    $service->buildFamilyStructure($this->importJob);

	    $this->importJob->updateStage(SurveyImportJob::STAGE_COMPLETED);

    }

    public function failed(\Exception $ex) {
	    $this->importJob->updateStage(SurveyImportJob::STAGE_FAILED);
	    $this->importJob->updateException($ex);
    }
}
