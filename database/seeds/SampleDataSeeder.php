<?php

use SGPS\Entity\Family;
use SGPS\Entity\Flag;
use SGPS\Entity\Group;
use SGPS\Entity\Person;
use SGPS\Entity\Residence;
use SGPS\Entity\Sector;
use SGPS\Entity\Equipment;

/**
 * rio-sgps
 * SampleDataSeeder.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 05/09/2018, 19:40
 */

class SampleDataSeeder extends \Illuminate\Database\Seeder {

	public function run() {

		$faker = \Faker\Factory::create('pt_BR');;

		$equipmentsPerType = collect(Equipment::TYPES)
			->map(function ($type) {
				return factory(Equipment::class, 5)->create(['type' => $type]);
			});

		$sectors = factory(Sector::class, 3)
			->create()
			->each(function($sector) use ($equipmentsPerType, $faker) { /* @var $sector Sector */

				foreach($equipmentsPerType as $type => $equipments) {
					$randomEquipment = $faker->randomElement($equipments);
					$sector->equipments()->syncWithoutDetaching([$randomEquipment->id]);
				}

			})
			->pluck('id');

		$residences = factory(Residence::class, 5)
			->create(['sector_id' => $faker->randomElement($sectors)])
			->each(function (Residence $residence) use ($faker) {

				$numFamilies = rand(0, 100) > 75 ? 2 : 1;

				$residence->_families = factory(Family::class, $numFamilies)->create([
					'sector_id' => $residence->sector_id,
					'residence_id' => $residence->id,
				])->each(function (Family $family) use ($residence) {

					$persons = factory(Person::class, rand(1, 4))->create([
						'sector_id' => $residence->sector_id,
						'residence_id' => $residence->id,
						'family_id' => $family->id,
					]);

					$family->person_in_charge_id = $persons->first()->id;
					$family->save();

					$family->_persons = $persons;

				});

			});

		//factory(Group::class, 6)->create();
		//factory(Flag::class, 15)->create()
		Flag::all()
			->each(function (Flag $flag) use ($faker, $residences) {

				switch($flag->entity_type) {
					case 'residence':
						$residences->random(rand(1,3))->each(function (Residence $residence) use ($faker, $flag) {
							$residence->flags()->attach($flag->id, ['residence_id' => $residence->id, 'sector_id' => $residence->sector_id, 'reference_date' => $faker->dateTimeThisYear->format('Y-m-d')]);
						});

						break;

					case 'family':
						$residences->random(rand(2, 4))->each(function (Residence $residence) use ($faker, $flag) {
							$residence->_families->random(rand(1, sizeof($residence->_families)))->each(function (Family $family) use ($faker, $flag) {
								$family->flags()->attach($flag->id, ['residence_id' => $family->residence_id, 'sector_id' => $family->sector_id, 'reference_date' => $faker->dateTimeThisYear->format('Y-m-d')]);
							});
						});

						break;

					case 'person':
						$residences->each(function (Residence $residence) use ($faker, $flag) {
							$residence->_families->random(rand(1, sizeof($residence->_families)))
								->each(function (Family $family) use ($faker, $flag) {

									$family->_persons->random(rand(1, sizeof($family->_persons)))
										->each(function (Person $person) use ($faker, $flag) {
											$person->flags()->attach($flag->id, ['residence_id' => $person->residence_id, 'sector_id' => $person->sector_id,  'reference_date' => $faker->dateTimeThisYear->format('Y-m-d')]);
										});

							});
						});

						break;
				}

			});

	}

}