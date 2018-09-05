<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\SGPS\Entity\User::class, function (Faker $faker) {
	return [
		'id' => $faker->uuid,
		'name' => $faker->name,
		'email' => $faker->unique()->safeEmail,
		'group_id' => $faker->uuid,
		'registration_number' => '',
		'cpf' => '',
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(\SGPS\Entity\Group::class, function (Faker $faker) {
	return [
		'id' => $faker->uuid,
		'name' => $faker->company,
	];
});

$factory->define(\SGPS\Entity\Flag::class, function (Faker $faker) {
	return [
		'id' => $faker->uuid,
		'code' => $faker->ean8,
		'name' => $faker->words(3, true),
		'description' => $faker->paragraph,
		'triggers' => null,
		'is_visible' => true,
	];
});

$factory->define(\SGPS\Entity\Residence::class, function (Faker $faker) {
	return [
		'id' => $faker->uuid,
		'sector_code' => $faker->postcode,
		'lat' => $faker->latitude,
		'lng' => $faker->longitude,
		'address' => $faker->streetAddress,
		'territory' => $faker->city,
		'reference' => null,
		'gis_global_id' => $faker->uuid,
	];
});

$factory->define(\SGPS\Entity\Family::class, function (Faker $faker) {
	return [
		'id' => $faker->uuid,
		 'residence_id' => $faker->uuid,
		 'person_in_charge_id' => $faker->uuid,
		 'ipm_rate' => $faker->randomFloat(3, 0, 4),
		 'ipm_risk_factor' => rand(1, 4),
		 'visit_status' => $faker->randomElement(['pending', 'completed']),
		 'visit_attempt' => rand(1,2),
		 'visit_last' => $faker->date(),
		 'gis_global_id' => $faker->uuid,
	];
});

$factory->define(\SGPS\Entity\Person::class, function (Faker $faker) {
	return [
		'id' => $faker->uuid,
		'residence_id' => $faker->uuid,
		'family_id' => $faker->uuid,
		'name' => $faker->name,
		'nis' => $faker->numerify('########'),
		'cpf' => $faker->numerify('###########'),
		'rg' => $faker->numerify('#########'),
		'phone_number' => $faker->numerify('###########'),
		'gis_global_id' => $faker->uuid,
	];
});
