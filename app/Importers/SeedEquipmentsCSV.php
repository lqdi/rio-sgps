<?php
/**
 * rio-sgps
 * SeedEquipmentsCSV.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2019
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 21/01/2019, 09:15
 */
namespace SGPS\Importers;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use SGPS\Entity\Equipment;

class SeedEquipmentsCSV implements WithHeadingRow, ToCollection, WithCustomCsvSettings {

    public function collection(Collection $array) {

        foreach($array as $data) { /* @var $data \Illuminate\Support\Collection */

            if(!isset($data['codequip']) || $data['codequip'] === null) continue;

            $equipmentID = strval($data['codequip']);

            $equipment = Equipment::findOrNew($equipmentID);
            $equipment->id = $equipmentID;
            $equipment->code = $equipmentID;
            $equipment->group_code = strval(trim($data['codsecr']));
            $equipment->type = $this->convertType($data);
            $equipment->name = strval($data['nomeequip'] ?? '');
            $equipment->address = strval($data['addrequip'] ?? '');
            $equipment->save();

            logger()->debug("[geo_importer.equipments] Found: #{$data['codequip']} ({$data['tipoequip']} -> {$equipment->type}) -> {$data['nomeequip']}: {$equipment->id}");
        }

    }

    private function convertType($data) : string {
        //$equipmentType = trim(strtolower(substr($data['tipoequip'] ?? '', 0, 4)));
        $equipmentType = $data['nomeequip'] ?? $data['id']; // some CRAS dont have name, but have CRAS in ID (???)
        $equipmentType = trim(substr(strtolower($equipmentType), 0, strpos($equipmentType, ' ')));
        switch ($equipmentType) {
            case "us": return Equipment::TYPE_UBS;
            case "unidade": return Equipment::TYPE_UBS; // this is for temp name fix
            case "cras": return Equipment::TYPE_CRAS;
            case "cmte": return Equipment::TYPE_CMTE;
            case "centro": return Equipment::TYPE_CMTE; // this is for temp name fix
            case "cre": return Equipment::TYPE_CRE;
            case "sms": return Equipment::TYPE_SMS;
            default: return "UNKNOWN";
        }
    }

    public function getCsvSettings(): array {
        return [
            'input_encoding' => 'UTF-8',
            'delimiter' => ';',
        ];
    }

}
