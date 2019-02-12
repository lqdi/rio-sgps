<?php
/**
 * rio-sgps
 * ImportedFamily.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 26/12/2018, 14:02
 */

namespace SGPS\Entity\Survey;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use SGPS\Traits\NonIncrementingIndex;

/**
 * Class ImportedFamily
 * @package SGPS\Entity\Survey
 *
 * @property string $id
 * @property string $import_id
 * @property string $globalid
 * @property string $uniquerowid
 * @property string $objectid
 * @property string $entrevista
 * @property string $senha
 * @property string $data
 * @property string $setor
 * @property string $x
 * @property string $y
 * @property string $logradouro
 * @property string $numero
 * @property string $complement
 * @property string $cep
 * @property string $comunidade
 * @property string $referencia
 * @property string $obs
 * @property string $status_ent
 * @property string $ausente
 * @property string $flag_nis
 * @property string $nis
 * @property string $flag_bf
 * @property string $flag_cfc
 * @property string $flag_bpc
 * @property string $flag_outro
 * @property string $outro_prog
 * @property string $preoc_alim
 * @property string $flag_mi
 * @property string $idade_mi
 * @property string $numero_fam
 * @property string $paredes
 * @property string $piso
 * @property string $flag_chuv
 * @property string $flag_vaso
 * @property string $flag_pia
 * @property string $agua
 * @property string $esgoto
 * @property string $comodos
 * @property string $flag_fogao
 * @property string $flag_filt
 * @property string $flag_gel
 * @property string $renda_fam
 * @property string $renda_cpta
 * @property string $perf_renda
 * @property string $ipma1
 * @property string $ipma2
 * @property string $ipma3
 * @property string $ipmb4
 * @property string $ipmb5
 * @property string $ipmc6
 * @property string $ipmc7
 * @property string $ipmc8
 * @property string $ipmc9
 * @property string $ipmc10
 * @property string $ipmc11
 * @property string $ipm
 * @property string $risco_ipm
 * @property string $sem_ref
 * @property string $created_date
 * @property string $created_user
 * @property string $last_edited_date
 * @property string $last_edited_user
 * @property string $x1
 * @property string $y1
 *
 * @property SurveyImportJob $importJob
 * @property ImportedMember[]|Collection $members
 */
class ImportedFamily extends Model {

	use NonIncrementingIndex;

	protected $table = 'survey_import_families';
	protected static $unguarded = true;

	public function importJob() {
		return $this->hasOne(SurveyImportJob::class, 'id', 'import_id');
	}

	public function members() {
		return $this->hasMany(ImportedMember::class, 'family_id', 'id')->where('import_id', $this->import_id);
	}

}