<?php
return [

	'person' => [
		'CE48' => ['name', \SGPS\Entity\Question::TYPE_TEXT], // Nome
		'CE49' => ['name', \SGPS\Entity\Question::TYPE_TEXT], // Nome social
		'CE53' => ['dob', \SGPS\Entity\Question::TYPE_DATE],
		'CE57' => ['rg', \SGPS\Entity\Question::TYPE_NUMERIC],
		'CE59' => ['cpf', \SGPS\Entity\Question::TYPE_NUMERIC],
	],

	'family' => [

	],

	'residence' => [
		'CE6' => ['address', \SGPS\Entity\Question::TYPE_TEXT],
		'CE7' => ['territory', \SGPS\Entity\Question::TYPE_TEXT],
		'CE10' => ['reference', \SGPS\Entity\Question::TYPE_TEXT],
	],

];