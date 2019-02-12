<?php
return [

	'residence' => [
		'source' => 'families',
		'fields' => [
			'lat' => 'x',
			'lng' => 'y',
			'sector_id' => 'setor',
			'address' => 'logradouro',
			'territory' => 'comunidade',
			'reference' => 'referencia',
			'gis_global_id' => 'globalid',
		],
		'questions' => [
			'CE06A' => 'logradouro',
			'CE06B' => 'numero',
			'CE06D' => 'complemento',
			'CE06C' => 'cep',
			'CE08' => 'comunidade',
			'CE10' => 'referencia',
			'CE09' => 'obs',
			'CE20' => 'paredes',
			'CE21' => 'piso',
			'CE22' => 'flag_chuv',
			'CE23' => 'flag_vaso',
			'CE24' => 'flag_pia',
			'CE25' => 'agua',
			'CE26' => 'esgoto',
			'CE28' => 'flag_fogao',
			'CE29' => 'flag_filt',
			'CE30' => 'flag_gel',
		],
	],

	'family' => [
		'source' => 'families',
		'fields' => [
			'sector_id' => 'setor',
			'ipm_rate' => 'ipm',
			'ipm_risk_factor' => 'risco_ipm',
			'gis_global_id' => 'globalid',
		],
		'questions' => [
			'CE71' => 'entrevista',
			'CE73' => 'senha',
			'CE74' => 'data',
			'CE37' => 'preoc_anim',
			'CE38' => 'flag_mi',
			'CE39' => 'idade_mi',
			'CE113' => 'perf_renda',
		],
	],

	'person' => [
		'source' => 'members',
		'fields' => [
			'sector_id' => 'sector_id', // not present in entity; inherit from family
			'name' => 'nome',
			//'gender' => 'sexo',
			'dob' => 'nascimento',
			'rg' => 'rg',
			'cpf' => 'cpf',
			'gis_global_id' => 'globalid',
		],
		'questions' => [
			'CE48' => 'nome',
			'CE50' => 'parentesco',
			'CE52' => 'raca_cor',
			'CE51' => 'sexo',
			'CE41' => 'nis',
			'CE70' => 'nome_mae',
			'CE54' => 'gravida',
			'CE55' => 'flag_rn',
			'CE56' => 'flag_rg',
			'CE57' => 'rg',
			'CE58' => 'flag_cpf',
			'CE59' => 'cpf',
			'CE34' => 'flag_bf',
			'CE33' => 'flag_cfc',
			'CE35' => 'flag_bpc',
			'CE36' => 'flag_outro',
			'CE53' => 'nascimento',
			'CE63' => 'esc_5_anos',
			'CE62' => 'freq_esc',
			'CE66' => 'flag_vis',
			'CE67' => 'flag_aud',
			'CE68' => 'flag_fis',
			'CE69' => 'flag_ment',

		],
	]

];