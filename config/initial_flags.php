<?php
return [
	'F001' => [
		'code' => 'F001',
		'entity_type' => 'residence',
		'name' => 'Sem Filtro d´Água',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE29', 'is_filled'],
			['CE29', 'is_false'],
		],
		'groups' => ['SMS'],
	],
	'F002' => [
		'code' => 'F002',
		'entity_type' => 'family',
		'name' => 'Recebe BF',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE34', 'is_filled'],
			['CE34', 'is_true'],
		],
		'groups' => [],
	],
	'F003' => [
		'code' => 'F003',
		'entity_type' => 'family',
		'name' => 'Recebe BPC',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE35', 'is_filled'],
			['CE35', 'is_true'],
		],
		'groups' => [],
	],
	'F004' => [
		'code' => 'F004',
		'entity_type' => 'family',
		'name' => 'Insegurança Alimentar',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE37', 'is_filled'],
			['CE37', 'is_true'],
		],
		'groups' => [],
	],
	'F005' => [
		'code' => 'F005',
		'entity_type' => 'family',
		'name' => 'Sem ESF',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE44', 'is_filled'],
			['CE44', 'is_true'],
		],
		'groups' => ['SMS'],
	],
	'F006' => [
		'code' => 'F006',
		'entity_type' => 'family',
		'name' => 'Medida socioeducativa',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE46', 'is_filled'],
			['CE46', 'is_one_of', [1, 2]],
		],
		'groups' => ['SMASDH'],
	],
	'F007' => [
		'code' => 'F007',
		'entity_type' => 'family',
		'name' => 'Descumprimento de medida socioeducativa',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE46', 'is_filled'],
			['CE46', 'eq', 3],
		],
		'groups' => ['SMASDH'],
	],
	'F008' => [
		'code' => 'F008',
		'entity_type' => 'person',
		'name' => 'Gravidez',
		'behavior' => '\\SGPS\\Behavior\\PregnancyFlag',
		'conditions' =>  [
			['CE54', 'is_filled'],
			['CE54', 'is_true'],
		],
		'groups' => [],
	],
	'F009' => [
		'code' => 'F009',
		'entity_type' => 'person',
		'name' => 'Documentação Pendente',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			[
				'or',
				[
					['CE55', 'is_filled'],
					['CE55', 'is_one_of', [2,3,99]],
				],
				[
					['CE56', 'is_filled'],
					['CE56', 'is_false'],
				],
				[
					['CE58', 'is_filled'],
					['CE58', 'is_false'],
				]
			]
		],
		'groups' => ['SMASDH'],
	],
	'F010' => [
		'code' => 'F010',
		'entity_type' => 'person',
		'name' => 'Fora da Escola',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			[
				'or',
				[
					['CE62', 'is_filled'],
					['CE62', 'is_one_of', [4, 5]],
					['CE53', 'is_filled'],
					['CE53', 'age_lt', 18],
				],
				[
					['CE81', 'is_filled'],
					['CE81', 'eq', 2],
				]
			]
		],
		'groups' => ['SMS', 'SME'],
	],
	'F011' => [
		'code' => 'F011',
		'entity_type' => 'person',
		'name' => 'Trabalho Infantil (ou violação de direitos?)',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE64', 'is_filled'],
			['CE64', 'is_true'],
			['CE53', 'is_filled'],
			['CE53', 'age_lt', 14],
		],
		'groups' => ['SMASDH'],
	],
	'F017' => [
		'code' => 'F017',
		'entity_type' => 'family',
		'name' => 'Mudou-se local ignorado',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE78', 'is_filled'],
			['CE78', 'is_true'],
			['CE80', 'is_empty'],
		],
		'groups' => [],
	],
	'F021' => [
		'code' => 'F021',
		'entity_type' => 'family',
		'name' => 'Descumprimento condicionalidade saúde',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE86', 'is_filled'],
			['CE86', 'is_false'],
		],
		'groups' => ['SMS', 'SMASDH'],
	],
	'F022' => [
		'code' => 'F022',
		'entity_type' => 'family',
		'name' => 'Visita da ESF pendente',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE87', 'is_filled'],
			['CE87', 'days_since_gt', 31],
		],
		'groups' => ['SMS'],
	],
	'F024' => [
		'code' => 'F024',
		'entity_type' => 'person',
		'name' => 'Pré-natal atrasado',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE89', 'is_filled'],
			['CE89', 'is_true'],
		],
		'groups' => ['SMS'],
	],
	'F025' => [
		'code' => 'F025',
		'entity_type' => 'person',
		'name' => 'Vacinação não confirmada',
		'behavior' => '\\SGPS\\Behavior\\VaccinationFlag',
		'conditions' =>  [
			['CE90', 'is_filled'],
			['CE90', 'is_false'],
		],
		'groups' => ['SMS'],
	],
	'F026' => [
		'code' => 'F026',
		'entity_type' => 'person',
		'name' => 'Avaliação de crescimento não confirmada',
		'behavior' => '\\SGPS\\Behavior\\GrowthEvaluationFlag',
		'conditions' =>  [
			['CE91', 'is_filled'],
			['CE91', 'is_false'],
		],
		'groups' => [],
	],
	'F027' => [
		'code' => 'F027',
		'entity_type' => 'person',
		'name' => 'Exame colpocitologia não confirmado',
		'behavior' => '\\SGPS\\Behavior\\ColpocitologyFlag',
		'conditions' =>  [
			['CE93', 'is_empty'],
		],
		'groups' => ['SMS'],
	],
	'F028' => [
		'code' => 'F028',
		'entity_type' => 'person',
		'name' => 'Mamografia não confirmada',
		'behavior' => '\\SGPS\\Behavior\\MammographyFlag',
		'conditions' =>  [
			['CE95', 'is_empty'],
		],
		'groups' => ['SMS'],
	],
	'F029' => [
		'code' => 'F029',
		'entity_type' => 'person',
		'name' => 'Não matriculada',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE97', 'is_filled'],
			['CE97', 'is_one_of', [2, 4]],
		],
		'groups' => ['SMS', 'SMASDH'],
	],
	'F030' => [
		'code' => 'F030',
		'entity_type' => 'person',
		'name' => 'Infrequência escolar',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE102', 'is_filled'],
			['CE102', 'neq', 1],
		],
		'groups' => ['SMS', 'SMASDH'],
	],
	'F032' => [
		'code' => 'F032',
		'entity_type' => 'family',
		'name' => 'sem CadÚnico',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE110', 'is_filled'],
			['CE110', 'is_false'],
		],
		'groups' => [],
	],
	'F033' => [
		'code' => 'F033',
		'entity_type' => 'family',
		'name' => 'Elegível BF',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE112', 'is_filled'],
			['CE112', 'is_true'],
			['CE34', 'is_filled'],
			['CE34', 'is_false'],
		],
		'groups' => [],
	],
	'F034' => [
		'code' => 'F034',
		'entity_type' => 'family',
		'name' => 'Extrema pobreza',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE113', 'is_filled'],
			['CE113', 'eq', 1],
		],
		'groups' => [],
	],
	'F035' => [
		'code' => 'F035',
		'entity_type' => 'family',
		'name' => 'Acompanhamento PAIF',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE115', 'is_filled'],
			['CE115', 'eq', 2],
		],
		'groups' => [],
	],
	'F036' => [
		'code' => 'F036',
		'entity_type' => 'family',
		'name' => 'Violação de direitos do idoso',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
						['CE124', 'is_filled'],
						['CE124', 'is_true'],
		],
		'groups' => [],
	],

	'F037' => [
		'code' => 'F037',
		'entity_type' => 'family',
		'name' => 'Violação de direitos da criança',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE125', 'is_filled'],
			['CE125', 'is_true'],
		],
		'groups' => [],
	],

	'F038' => [
		'code' => 'F038',
		'entity_type' => 'family',
		'name' => 'Violência física ou psicológica',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE126', 'is_filled'],
			['CE126', 'is_true'],
		],
		'groups' => [],
	],

	'F039' => [
		'code' => 'F039',
		'entity_type' => 'family',
		'name' => 'Violência contra mulher',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE127', 'is_filled'],
			['CE127', 'is_true'],
		],
		'groups' => [],
	],

	'F040' => [
		'code' => 'F040',
		'entity_type' => 'family',
		'name' => 'Membro em situação de rua',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE128', 'is_filled'],
			['CE128', 'is_true'],
		],
		'groups' => [],
	],

	'F041' => [
		'code' => 'F041',
		'entity_type' => 'person',
		'name' => 'Deficiente visual',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE66', 'is_filled'],
			['CE66', 'is_one_of', [1,2,3]],
		],
		'groups' => ['SMS'],
	],

	'F042' => [
		'code' => 'F042',
		'entity_type' => 'person',
		'name' => 'Deficiente auditivo',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE67', 'is_filled'],
			['CE67', 'is_one_of', [1,2,3]],
		],
		'groups' => ['SMS'],
	],

	'F043' => [
		'code' => 'F043',
		'entity_type' => 'person',
		'name' => 'Deficiente físico',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE68', 'is_filled'],
			['CE68', 'is_one_of', [1,2,3]],
		],
		'groups' => ['SMS'],
	],

	'F044' => [
		'code' => 'F044',
		'entity_type' => 'person',
		'name' => 'Deficiente mental',
		'behavior' => '\\SGPS\\Behavior\\DefaultFlag',
		'conditions' =>  [
			['CE69', 'is_filled'],
			['CE69', 'is_one_of', [1,2,3]],
		],
		'groups' => ['SMS'],
	],
];