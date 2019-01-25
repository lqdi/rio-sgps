<?php
/**
 * rio-sgps
 * ParseUploadedGeographyImport.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2019
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 2019-01-25, 16:23
 */

namespace SGPS\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SGPS\Services\GeographyImportService;

class ParseUploadedGeographyImport implements ShouldQueue {

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $equipmentsCSV;
    protected $sectorsCSV;

    public function __construct(string $equipmentsCSV, string $sectorsCSV) {
        $this->equipmentsCSV = $equipmentsCSV;
        $this->sectorsCSV = $sectorsCSV;
    }

    public function handle(GeographyImportService $service) {

        $service->readEquipmentsFromCSV($this->equipmentsCSV, 'local');
        $service->readSectorsFromCSV($this->sectorsCSV, 'local');

    }

    public function failed(\Exception $ex) {
        logger()->error("[Job:ParseUploadedGeographyImport] Failed: {$ex->getMessage()}", [
            'equipments_csv' => $this->equipmentsCSV,
            'sectors_csv' => $this->sectorsCSV,
        ]);
    }
}
