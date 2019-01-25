<?php
/**
 * rio-sgps
 * GeographyImportService.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2019
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 2019-01-25, 16:25
 */

namespace SGPS\Services;


use Excel;
use SGPS\Importers\SeedEquipmentsCSV;
use SGPS\Importers\SeedSectorsCSV;

class GeographyImportService {

    public function readEquipmentsFromCSV(string $csvFile, string $disk = 'static_data') : void {

        logger("[GeographyImportService.readEquipmentsFromCSV] Loading equipments...");
        Excel::import(new SeedEquipmentsCSV(), $csvFile, $disk);

    }

    public function readSectorsFromCSV(string $csvFile, string $disk = 'static_data') : void {

        logger("[GeographyImportService.readSectorsFromCSV] Loading sectors...");
        Excel::import(new SeedSectorsCSV(), $csvFile, $disk);

    }


}
