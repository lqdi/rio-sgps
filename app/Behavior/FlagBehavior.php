<?php
/**
 * rio-sgps
 * FlagBehavior.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 18/10/2018, 20:19
 */

namespace SGPS\Behavior;


use Carbon\Carbon;
use SGPS\Entity\Entity;
use SGPS\Entity\Flag;
use SGPS\Entity\FlagAttribution;
use SGPS\Services\ConditionalCheckerService;
use SGPS\Services\FlagAttributionService;

abstract class FlagBehavior {

	/**
	 * The flag attribution service.
	 * @var FlagAttributionService
	 */
	protected $attributionService;

	/**
	 * The conditional checker service
	 * @var ConditionalCheckerService
	 */
	protected $conditionalChecker;

	/**
	 * FlagBehavior constructor.
	 */
	public function __construct() {
		$this->attributionService = app()->make(FlagAttributionService::class);
		$this->conditionalChecker = app()->make(ConditionalCheckerService::class);
	}

	/**
	 * Map of flag behavior handler singletons.
	 * @var array
	 */
	protected static $_handlers = [];

	/**
	 * Hook: this is called for every active entity of the same type as the flags', when answers are saved to it.
	 * This is called even when the flag is not yet attributed.
	 *
	 * @param Flag $flag The flag whose behavior is being evaluated.
	 * @param Entity $entity The target entity.
	 * @param array $answers An associative array of answers given, indexed by their code.
	 */
	abstract public function hookAnswersUpdated(Flag $flag, Entity $entity, array $answers) : void;

	/**
	 * Gets the singleton instance of the flag behavior handler for the given flag.
	 * @param Flag $flag
	 * @return FlagBehavior
	 * @throws \Exception
	 */
	public static function getHandler(Flag $flag) : FlagBehavior {

		if(!class_exists($flag->behavior)) {
			throw new \Exception("Flag behavior class not implemented: {$flag->code} - {$flag->name} ({$flag->behavior})");
		}

		// Uses default flag behavior if given behavior class does not exist
		$behaviorClass = class_exists($flag->behavior)
			? $flag->behavior
			: DefaultFlag::class;

		// Looks for cached singleton instance
		if(!isset(self::$_handlers[$behaviorClass])) {
			self::$_handlers[$behaviorClass] = new $behaviorClass();
		}

		return self::$_handlers[$behaviorClass];
	}

	/**
	 * Hook: this is called daily on a cron job, on all flag attributions for this particular flag.
	 * This is called on all active and inactive flags, except for cancelled ones.
	 *
	 * @param Flag $flag The flag whose behavior is being evaluated.
	 * @param FlagAttribution $attribution The flag attribution being checked.
	 * @param Carbon $today Today's date.
	 */
	abstract public function hookDailyCron(Flag $flag, FlagAttribution $attribution, Carbon $today) : void;
}