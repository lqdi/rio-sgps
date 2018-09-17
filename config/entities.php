<?php
return [

	'types' => [
		'person',
		'residence',
		'family',
	],

	'type' => [
		'person' => [
			'name' => 'Indivíduo',
			'parent' => 'family',
		],

		'residence' => [
			'name' => 'Residência',
			'parent' => null
		],

		'family' => [
			'name' => 'Família',
			'parent' => 'residence',
		],
	],

	'anchor' => 'family',

];