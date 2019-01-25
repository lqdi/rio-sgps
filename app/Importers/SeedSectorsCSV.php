<?php
/**
 * rio-sgps
 * SeedSectorsCSV.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2019
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 2019-01-25, 16:12
 */

namespace SGPS\Importers;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use SGPS\Entity\Equipment;
use SGPS\Entity\Sector;

class SeedSectorsCSV implements WithHeadingRow, ToCollection, WithCustomCsvSettings {

    public function collection(Collection $array) {

        foreach($array as $data) { /* @var $data \Illuminate\Support\Collection */

            if(!isset($data['codsetor'])) continue;

            $sectorID = strval($data['codsetor']);

            $sector = Sector::findOrNew($sectorID);
            $sector->id = $sectorID;
            $sector->name = "{$sectorID} {$data['nomebairro']}";
            $sector->cod_bairro = $data['codbairro'];
            $sector->cod_ra = $data['codra'];
            $sector->cod_rp = $data['codrp'];
            $sector->cod_ap = $data['codap'];
            $sector->cod_cap = $data['cap'];
            $sector->cod_cms = $data['cms'];
            $sector->cod_esf = $data['esf'];
            $sector->cod_casdh = $data['casdh'];
            $sector->cod_cras = $data['cras'];
            $sector->cod_cre = $data['cre'];
            $sector->save();

            $this->attachExistingEquipments($sector, [
                $sector->cod_ra,
                $sector->cod_rp,
                $sector->cod_ap,
                $sector->cod_cap,
                $sector->cod_cms,
                $sector->cod_esf,
                $sector->cod_casdh,
                $sector->cod_cras,
                $sector->cod_cre,
            ]);

            logger()->debug("[geo_importer.sectors] Found: #{$data['codsetor']} -> {$data['nomebairro']} {$data['nomera']} {$data['nomerp']}: {$sector->id}");
        }

    }

    public function attachExistingEquipments(Sector $sector, array $equipmentIDList) : void {

        $foundEquipments = Equipment::query()->whereIn('id', $equipmentIDList)->get();
        $sector->equipments()->syncWithoutDetaching($foundEquipments->pluck('id'));

    }

    public function getCsvSettings(): array {
        return [
            'input_encoding' => 'UTF-8',
            'delimiter' => ';',
        ];
    }
}
