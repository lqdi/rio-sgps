<?php
/**
 * rio-sgps
 * SurveyImportJob.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 26/12/2018, 14:01
 */

namespace SGPS\Entity\Survey;


use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use SGPS\Traits\IndexedByUUID;

/**
 * Class SurveyImportJob
 * @package SGPS\Entity
 *
 * @property string $id
 * @property string $families_csv
 * @property string $members_csv
 * @property string $stage
 * @property string $exception_message
 * @property object $exception_object
 * @property int $num_families_read
 * @property int $num_families_imported
 * @property int $num_families_skipped
 * @property int $num_persons_read
 * @property int $num_persons_imported
 * @property int $num_persons_skipped
 *
 * @property ImportedMember[]|Collection $members
 * @property ImportedFamily[]|Collection $families
 *
 */
class SurveyImportJob extends Model {

	use IndexedByUUID;

	const STAGE_PENDING_START = 'pending_start';
	const STAGE_CSV_READ = 'csv_read';
	const STAGE_GENERATE_FAMILIES = 'gen_families';
	const STAGE_COMPLETED = 'completed';
	const STAGE_FAILED = 'failed';

	protected $table = "survey_import_jobs";
	protected $fillable = [
		'families_csv',
		'members_csv',
		'stage',
		'exception_string',
		'exception_object',
		'num_families_read',
		'num_families_imported',
		'num_families_skipped',
		'num_persons_read',
		'num_persons_imported',
		'num_persons_skipped',
	];

	protected $casts = [
		'exception_object' => 'object',
	];

	public function members() {
		return $this->hasMany(ImportedMember::class, 'import_id', 'id');
	}

	public function families() {
		return $this->hasMany(ImportedFamily::class, 'import_id', 'id');
	}

	public function refreshReadCounts() {
		$this->num_families_read = ImportedFamily::where('import_id', $this->id)->count();
		$this->num_persons_read = ImportedMember::where('import_id', $this->id)->count();
		$this->save();
	}

	public function updateStage(string $stage) : void {
		$this->stage = $stage;
		$this->save();
	}

	public function updateException(\Exception $exception) : void {
		$this->exception_message = substr($exception->getMessage(), 0, 255);
		$this->exception_object = json_encode($exception);
		$this->save();
	}

	public function raiseCounter($counter) : void {
		if(!$this->$counter) {
			$this->$counter = 0;
		}

		$this->$counter += 1;
	}

	public function printDebugTree(Command $command) {
		foreach($this->families as $family) { /* @var $family \SGPS\Entity\Survey\ImportedFamily */
			$command->comment("=> Family #{$family->id} \t [{$family->logradouro}]");

			foreach($family->members as $member) { /* @var $family \SGPS\Entity\Survey\ImportedMember */
				$command->comment("\t Member #{$member->id} \t\t [{$member->nome}]");
			}
		}
	}

	public static function createFromFiles(string $familiesCSV, string $membersCSV) : self {
		return self::create([
			'families_csv' => $familiesCSV,
			'members_csv' => $membersCSV,
			'stage' => self::STAGE_PENDING_START,
		]);
	}

}