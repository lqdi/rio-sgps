<?php

use SGPS\Entity\Family;
use SGPS\Entity\Flag;
use SGPS\Entity\Group;
use SGPS\Entity\Person;
use SGPS\Entity\Residence;

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

		$residences = factory(Residence::class, 20)->create()
			->each(function (Residence $residence) {

				$residence->_families = factory(Family::class, rand(1, 3))->create([
					'residence_id' => $residence->id,
				])->each(function (Family $family) use ($residence) {

					$persons = factory(Person::class, rand(1, 6))->create([
						'residence_id' => $residence->id,
						'family_id' => $family->id,
					]);

					$family->person_in_charge_id = $persons->first()->id;
					$family->save();

					$family->_persons = $persons;

				});

			});

		factory(Group::class, 6)->create();
		factory(Flag::class, 30)->create()
			->each(function (Flag $flag) use ($faker, $residences) {

				$entity = collect(['residence', 'family', 'person'])->random();

				switch($entity) {
					case 'residence':
						$residences->random(rand(4,8))->each(function (Residence $residence) use ($faker, $flag) {
							$residence->flags()->attach($flag->id, ['reference_date' => $faker->date()]);
						});

						break;

					case 'family':
						$residences->random(rand(8, 12))->each(function (Residence $residence) use ($faker, $flag) {
							$residence->_families->random(rand(1, sizeof($residence->_families)))->each(function (Family $family) use ($faker, $flag) {
								$family->flags()->attach($flag->id, ['reference_date' => $faker->date()]);
							});
						});

						break;

					case 'person':
						$residences->random(rand(12, 20))->each(function (Residence $residence) use ($faker, $flag) {
							$residence->_families->random(rand(1, sizeof($residence->_families)))
								->each(function (Family $family) use ($faker, $flag) {

									$family->_persons->random(rand(1, sizeof($family->_persons)))
										->each(function (Person $person) use ($faker, $flag) {
											$person->flags()->attach($flag->id, ['reference_date' => $faker->date()]);
										});

							});
						});

						break;
				}

			});

	}

}