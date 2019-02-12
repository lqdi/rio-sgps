<?php
/**
 * rio-sgps
 * ImportedMember.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 26/12/2018, 14:02
 */

namespace SGPS\Entity\Survey;


use Illuminate\Database\Eloquent\Model;
use SGPS\Traits\NonIncrementingIndex;

/**
 * Class ImportedMember
 * @package SGPS\Entity\Survey
 *
 * @property string $id
 * @property string $import_id
 * @property string $globalid
 * @property string $objectid
 * @property string $parentesco
 * @property string $nome
 * @property string $nome_soc
 * @property string $sexo
 * @property string $raca_cor
 * @property string $idade
 * @property string $seis_meses
 * @property string $nascimento
 * @property string $nome_mae
 * @property string $gravida
 * @property string $flag_rn
 * @property string $flag_rg
 * @property string $rg
 * @property string $flag_cpf
 * @property string $cpf
 * @property string $esc_5_anos
 * @property string $freq_esc
 * @property string $pos_renda
 * @property string $renda_memb
 * @property string $deficienc
 * @property string $tipo_defic
 * @property string $flag_vis
 * @property string $flag_aud
 * @property string $flag_fis
 * @property string $flag_ment
 * @property string $flag_outra
 * @property string $outra_def
 * @property string $flag_idade
 * @property string $flag_ipma1
 * @property string $flag_ipma2
 * @property string $flag_ipma3
 * @property string $parentrowid
 * @property string $created_date
 * @property string $created_user
 * @property string $last_edited_date
 * @property string $last_edited_user
 *
 * @property SurveyImportJob $importJob
 * @property ImportedFamily $family
 */
class ImportedMember extends Model {

	use NonIncrementingIndex;

	protected $table = 'survey_import_members';
	protected static $unguarded = true;

	public function importJob() {
		return $this->hasOne(SurveyImportJob::class, 'id', 'import_id');
	}

	public function family() {
		return $this->hasOne(ImportedFamily::class, 'id', 'family_id')->where('import_id', $this->import_id);
	}

}