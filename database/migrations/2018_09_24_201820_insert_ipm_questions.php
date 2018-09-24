<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use SGPS\Entity\Question;

class InsertIpmQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

	    $questions = [
		    [
		    	'code' => 'CE1',
			    'field_type' => 'coords',
			    'question' => 'Coordenadas Georeferenciadas',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE2',
			    'field_type' => 'image',
			    'question' => 'Fotografia da entrada',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE3',
			    'field_type' => 'number',
			    'question' => 'Código do Domicílio',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE4',
			    'field_type' => 'number',
			    'question' => 'Geocod',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE5',
			    'field_type' => 'number',
			    'question' => 'Setor Censitario',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE6',
			    'field_type' => 'texto',
			    'question' => 'Endereço',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE7',
			    'field_type' => 'texto',
			    'question' => 'Bairro',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE8',
			    'field_type' => 'texto',
			    'question' => 'Nome da Comunidade - se houver',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE9',
			    'field_type' => 'texto',
			    'question' => 'Comentário',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE10',
			    'field_type' => 'texto',
			    'question' => 'Ponto de Referência',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE11',
			    'field_type' => 'number',
			    'question' => 'Quantidade de famílias residentes localizadas no IPM',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE12',
			    'field_type' => 'number',
			    'question' => 'CAP',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE13',
			    'field_type' => 'text',
			    'question' => 'Clinica de Saude da Familia - CSF',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE14',
			    'field_type' => 'text',
			    'question' => 'Endereço da CSF (vinculado à Clínica)',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE15',
			    'field_type' => 'text',
			    'question' => 'Coordenadoria Regional de Educação - CRE',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE16',
			    'field_type' => 'text',
			    'question' => 'Endereço da CRE',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE17',
			    'field_type' => 'number',
			    'question' => 'CASDH',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE18',
			    'field_type' => 'text',
			    'question' => 'Centro de Referencia de Assistencia Social - CRAS',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE19',
			    'field_type' => 'text',
			    'question' => 'Endereço do CRAS',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE20',
			    'field_type' => 'yesnonullable',
			    'question' => 'Material predominante das paredes externas é alvenaria (tijolo ou concreto com ou sem revestimento)?',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE21',
			    'field_type' => 'yesnonullable',
			    'question' => 'Casa possui piso de madeira, cerâmica ou cimento?',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE22',
			    'field_type' => 'yesno',
			    'question' => 'A casa possui: Chuveiro',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE23',
			    'field_type' => 'yesno',
			    'question' => 'A casa possui: Vaso Sanitário',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE24',
			    'field_type' => 'yesno',
			    'question' => 'A casa possui: Pia  ',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE25',
			    'field_type' => 'yesnonullable',
			    'question' => 'Casa possui acesso regular à água proveniente de rede de distribuição?',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE26',
			    'field_type' => 'yesnonullable',
			    'question' => 'Casa possui esgotamento sanitário ligado a uma rede geral ou pluvial?',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE27',
			    'field_type' => 'number',
			    'question' => 'Número de cômodos que servem como dormitório deste domicílio:  ',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE28',
			    'field_type' => 'yesno',
			    'question' => 'Itens que a casa possui: Fogão a gás',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE29',
			    'field_type' => 'yesno',
			    'question' => 'Itens que a casa possui: Filtro de água',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE30',
			    'field_type' => 'yesno',
			    'question' => 'Itens que a casa possui: Geladeira ',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE31',
			    'field_type' => 'number',
			    'question' => 'Código da família',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE32',
			    'field_type' => 'number',
			    'question' => 'Numero de individuos na familia',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE33',
			    'field_type' => 'yesnonullable',
			    'question' => 'Família é beneficiária do programa Cartão Familia Carioca - CFC',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE34',
			    'field_type' => 'yesnonullable',
			    'question' => 'Família é beneficiária do programa Bolsa Família - BF',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE35',
			    'field_type' => 'yesnonullable',
			    'question' => 'Família é beneficiária do programa de Beneficio de Prestação Continuada - BPC',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE36',
			    'field_type' => 'yesnonullable',
			    'question' => 'Família é beneficiária de algum outro programa/benefício?',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE37',
			    'field_type' => 'yesnonullable',
			    'question' => 'Nos últimos 3 meses, os moradores da sua casa tiveram a preocupação de que os alimentos acabassem antes de poderem comprar ou receber mais comida?',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE38',
			    'field_type' => 'yesnonullable',
			    'question' => 'Nos últimos 5 anos, alguma criança de até 5 anos que morava nesta casa morreu? (relativa à data do IPM?)',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE39',
			    'field_type' => 'number',
			    'question' => 'Quantos anos a criança tinha quando morreu? ',
			    'conditions' => [
			    	['CE38', 'is_true'],
			    ],
			    'field_options' => [
			    	'min' => 0,
				    'max' => 14
			    ],
		    ],
		    [
		    	'code' => 'CE40',
			    'field_type' => 'yesnonullable',
			    'question' => 'A família possui algum integrante que devido ao envelhecimento, deficiência ou doença necessite de cuidados constantes de outra pessoa para realizar atividades básicas, tais como tomar banho, alimentar-se, locomover-se dentro da casa etc?',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE41',
			    'field_type' => 'number',
			    'question' => 'Numero do NIS do responsavel',
			    'conditions' => 'pedir formato número NIS',
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE42',
			    'field_type' => 'yesnonullable',
			    'question' => 'A família é atendida/acompanhada pelo CRAS de referência do território?',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE43',
			    'field_type' => 'yesnonullable',
			    'question' => 'A família é atendida/acompanhada pelo CREAS de referência do território?',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE44',
			    'field_type' => 'yesnonullable',
			    'question' => 'A família recebe atendimento da equipe de saúde da família?',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE45',
			    'field_type' => 'yesnonullable',
			    'question' => 'Algum membro da família está em acolhimento institucional?',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE46',
			    'field_type' => 'select_one',
			    'question' => 'Algum membro da família está em cumprimento de medida socioeducativa?',
			    'conditions' => null,
			    'field_options' => [
			    	1 - 'Sim, está cumprindo em meio aberto',
				    2 => 'Sim, está cumprindo em meio fechado,',
				    3 => 'Sim, mas está em situação de descumprimento,',
				    4 => 'Não há ninguém em situação de medida socioeducativa,',
				    99 => 'NS/NR',
			    ]
		    ],
		    [
		    	'code' => 'CE47',
			    'field_type' => 'number',
			    'question' => 'codigo do individuo',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE48',
			    'field_type' => 'text',
			    'question' => 'Nome do individuo',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE49',
			    'field_type' => 'text',
			    'question' => 'Nome social',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE50',
			    'field_type' => 'select_one',
			    'question' => 'condição na familia',
			    'conditions' => null,
			    'field_options' => [
			    	1 => 'PESSOA RESPONSÁVEL',
				    2 => 'CÔNJUGE,COMPANHEIRO(A)',
				    3 => 'FILHO (A), ENTEADO',
				    4 => 'PAI, MÃE, SOGRO (A)',
				    5 => 'NETO (A), BISNETO (A)',
				    6 => 'IRMÃ, IRMÃO',
				    7 => 'OUTRO PARENTE',
				    8 => 'AGREGADO (A)',
				    9 => 'PENSIONISTA/INQUILINO',
				    99 => 'NS/NR',
			    ]
		    ],
		    [
		    	'code' => 'CE51',
			    'field_type' => 'select_one',
			    'question' => 'sexo',
			    'conditions' => null,
			    'field_options' => [
			    	1 => 'Masculino',
	                2 => 'Feminino',
			    ]
		    ],
		    [
		    	'code' => 'CE52',
			    'field_type' => 'select_one',
			    'question' => 'raça/cor',
			    'conditions' => null,
			    'field_options' => [
				    1 => 'Branco',
				    2 => 'Preto',
				    3 => 'Amarelo',
				    4 => 'Pardo',
				    5 => 'Indígena',
			    ]
		    ],
		    [
		    	'code' => 'CE53',
			    'key' => 'age',
			    'field_type' => 'date',
			    'question' => 'data de nascimento',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE54',
			    'field_type' => 'yesnonullable',
			    'question' => 'Está grávida?',
			    'conditions' => [
			    	['CE51', 'eq', 2],
				    ['CE53', 'age_between', 10, 60],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE55',
			    'field_type' => 'yesno',
			    'question' => 'Possui CERTIDÃO DE NASCIMENTO',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE56',
			    'field_type' => 'yesno',
			    'question' => 'Possui  RG / CARTEIRA DE IDENTIDADE',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE57',
			    'field_type' => 'number',
			    'question' => 'Numero do RG (condição de o individuo é o responsavel-(CE50) e possui o documento-(CE56))',
			    'conditions' => [
			    	['CE50', 'eq', 1],
				    ['CE56', 'is_true'],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE58',
			    'field_type' => 'yesno',
			    'question' => 'Possui CPF',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE59',
			    'field_type' => 'number',
			    'question' => 'Numero do CPF (condição de o individuo é o responsavel-(CE50) e possui o documento - (CE58))',
			    'conditions' => [
			    	['CE50', 'eq', 1],
				    ['CE58', 'is_true']
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE60',
			    'field_type' => 'yesno',
			    'question' => 'Possui CARTEIRA DE TRABALHO',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE61',
			    'field_type' => 'yesno',
			    'question' => 'Possui TÍTULO DE ELEITOR',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE62',
			    'field_type' => 'select_one',
			    'question' => 'Frequenta escola ou creche (ou alguma instituição de ensino)?',
			    'conditions' => null,
			    'field_options' => [
					1 => 'SIM - rede municipal',
					2 => 'SIM - outra rede publica',
					3 => 'SIM - rede privada',
					4 => 'NÃO',
				]
		    ],
		    [
		    	'code' => 'CE63',
			    'field_type' => 'yesnonullable',
			    'question' => 'Possui 5 anos de estudos completos? (perguntado caso já tenha frequentado a escola- (CE62) e possua mais de 14 anos - (CE553))',
			    'conditions' => [
			    	['CE53', 'age_gt', 14],
				    ['CE62', 'is_true']
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE64',
			    'field_type' => 'select_one',
			    'question' => 'Na última semana, tinha algum trabalho remunerado ou jovem aprendiz? (Só para pessoas acima de 10 anos - (CE53))',
			    'conditions' => [
			    	['CE53', 'age_gt', 10],
			    ],
			    'field_options' => [
			    	1 => 'SIM',
	                2 => 'NÃO, MAS TEVE NÃO REMUNERADO',
	                3 => 'NÃO TEVE TRABALHO',
	                99 => 'NS/NR',
                ]
		    ],
		    [
		    	'code' => 'CE65',
			    'field_type' => 'yesnonullable',
			    'question' => 'No último mês, tomou alguma providência de fato para conseguir trabalho remunerado? (perguntado caso responda não - C64)',
			    'conditions' => [
			    	['C64', 'is_false'],
				    ['CE53', 'age_gt', 10],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE66',
			    'field_type' => 'select_one',
			    'question' => 'Tem dificuldade permanente de enxergar?',
			    'conditions' => null,
			    'field_options' => [
			    	1 => 'Sim, mas não consegue de modo algum',
	                2 => 'Sim, grande dificuldade',
	                3 => 'Sim, alguma dificuldade',
	                4 => 'Não nenhuma dificuldade',
                ]
		    ],
		    [
		    	'code' => 'CE67',
			    'field_type' => 'select_one',
			    'question' => 'Tem dificuldade permanente de ouvir?',
			    'conditions' => null,
			    'field_options' => [
			    	1 => 'Sim, mas não consegue de modo algum',
	                2 => 'Sim, grande dificuldade',
	                3 => 'Sim, alguma dificuldade',
	                4 => 'Não nenhuma dificuldade',
                ]
		    ],
		    [
		    	'code' => 'CE68',
			    'field_type' => 'select_one',
			    'question' => 'Tem dificuldade permanente de caminhar ou subir degraus?',
			    'conditions' => null,
			    'field_options' => [
			    	1 => 'Sim, mas não consegue de modo algum',
	                2 => 'Sim, grande dificuldade',
	                3 => 'Sim, alguma dificuldade',
	                4 => 'Não nenhuma dificuldade',
                ]
		    ],
		    [
		    	'code' => 'CE69',
			    'field_type' => 'yesno',
			    'question' => 'Tem alguma deficiência mental/intelectual permanente que limite as suas atividades habituais, como trabalhar, ir à escola, brincar, etc.?',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE70',
			    'field_type' => 'text',
			    'question' => 'Nome da mãe',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE71',
			    'field_type' => 'text',
			    'question' => 'Nome do recenseador',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE72',
			    'field_type' => 'text',
			    'question' => 'Login',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE73',
			    'field_type' => 'number',
			    'question' => 'Senha',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE74',
			    'field_type' => 'date',
			    'question' => 'data do preenchimento do questionario',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE75',
			    'field_type' => 'date',
			    'question' => 'data da primeira visita do Agente Comunitário de Saude - ACS (registrado quando ocorre o primeiro contato)',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE76',
			    'field_type' => 'date',
			    'question' => 'data da segunda visita do Agente Comunitário de Saude - ACS (caso não tenha comparecido)',
			    'conditions' => [
			    	['CE75', 'is_filled'],
				    ['CE75', 'before_today'],
				    ['CE108', 'is_not_filled'],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE78',
			    'field_type' => 'yesno',
			    'question' => 'família se mudou',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE79',
			    'field_type' => 'date',
			    'question' => 'data da mudança',
			    'conditions' => [
			    	['CE78', 'is_true']
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE80',
			    'field_type' => 'text',
			    'question' => 'Novo endereço caso seja conhecido - Rua/numero/Bairro/Cidade (avia ao IPP para reclassificação territoral)',
			    'conditions' => [
			    	['CE78', 'is_true']
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE81',
			    'field_type' => 'select_one',
			    'question' => 'Encaminhamento à CRE (perguntado em caso de alerta de criança fora da escola) (alerta condição 62)',
			    'conditions' => [
			    	['CE62', 'is_false']
			    ],
			    'field_options' => [
			    	1 => 'Confirmada existência de criança fora da escola e encaminhada pelo ACS',
	                2 => 'Confirmada existência pelo ACS mas não deseja ir à CRE',
	                3 => 'Não confirmada presença de criança fora da escola pelo ACS',
	                4 => 'Encaminhada a CRE pelo CRAS',
	                5 => 'Recebida pela CRE',
                ]
		    ],
		    [
		    	'code' => 'CE82',
			    'field_type' => 'date',
			    'question' => 'Data do encaminhamento a CRE',
			    'conditions' => [
			    	['CE81', 'is_one_of', [1, 4, 5]]
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE83',
			    'field_type' => 'select_one',
			    'question' => 'Indivíduo já estava cadastrado na Estratégia de Saúde da Família antes da visita Territórios Sociais?',
			    'conditions' => null,
			    'field_options' => [
			    	1 => 'sim',
	                2 => 'não e foi cadastrado',
	                3 => 'não e recusa o cadastro',
                ]
		    ],
		    [
		    	'code' => 'CE85',
			    'field_type' => 'date',
			    'question' => 'Em caso de entrega de Filtro - registro da data (acionado pelo alerta - (Alerta - 29)',
			    'conditions' => [
			    	['CE29' => 'is_false']
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE86',
			    'field_type' => 'yesno',
			    'question' => 'Beneficiários BF em dia com condicionalidade da saúde',
			    'conditions' => [
			    	['CE34', 'is_true']
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE87',
			    'field_type' => 'yesno',
			    'question' => 'Acompanhamento pelo ACS segundo protocolos de visitas para cada categoria de atendimento em dia (confirmação mensal se os atendimento de saúde está em dia)',
			    'conditions' => [
			    	['CE75', 'is_filled']
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE88',
			    'field_type' => 'date',
			    'question' => 'Início estimado da gravidez',
			    'conditions' => [
			    	['CE54', 'is_true'],
				    ['CE75', 'is_filled'],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE89',
			    'field_type' => 'yesno',
			    'question' => 'gestantes em acompanhamento pré-natal em dia (alerta mensal) (se condição "Grávida" estiver ligada) (duração máxima 9 meses, a partir da data estimada ou do registro da gravidez)',
			    'conditions' => [
			    	['CE54', 'is_true'],
				    ['CE75', 'is_filled'],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE90',
			    'field_type' => 'yesno',
			    'question' => 'para crianças, vacinação em dia  - colocar um verificador da idade da criança - (CE53))',
			    'conditions' => [
			    	['CE53', 'is_children'],
				    ['CE75', 'is_filled'],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE91',
			    'field_type' => 'yesno',
			    'question' => 'crianças menores de 6 anos com registro de avaliação de crescimento e desenvolvimento no prontuário em dia (alerta ativado pela idade para 1 e 2 anos  (CE53)',
			    'conditions' => [
			    	['CE53', 'age_lt', 6],
				    ['CE75', 'is_filled'],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE92',
			    'field_type' => 'yesnonullable',
			    'question' => 'Mulheres em idade fértil de 12 a 49 anos com informação de acompanhamento de planejamento reprodutivo no prontuário no último ano. (CE53)',
			    'conditions' => [
			    	['CE53', 'age_between', 12, 49],
				    ['CE51', 'eq', 2],
				    ['CE75', 'is_filled'],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE93',
			    'field_type' => 'date',
			    'question' => 'Data do último exame de colpocitologia para Mulheres entre 25 e 64 anos',
			    'conditions' => [
			    	['CE53', 'age_between', 25, 64],
				    ['CE51', 'eq', 2],
				    ['CE75', 'is_filled'],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE94',
			    'field_type' => 'yesnp',
			    'question' => 'Mulheres com necessidade de exame de colpocitologia anual',
			    'conditions' => [
			    	['CE51', 'eq', 2],
				    ['CE75', 'is_filled'],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE95',
			    'field_type' => 'date',
			    'question' => 'Data do último exame de mamografia para Mulheres entre 50 e 69 anos (fez? sim ou não. Alerta de dois anos a partir da data da última mamografia)',
			    'conditions' => [
			    	['CE51', 'eq', 2],
				    ['CE53', 'age_between', 50, 69],
				    ['CE75', 'is_filled'],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE96',
			    'field_type' => 'date',
			    'question' => 'Data da Chegada da família à CRE',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE97',
			    'field_type' => 'select_one',
			    'question' => 'Situação de matrícula na rede municipal',
			    'conditions' => [
			    	['CE53', 'age_between', 1, 14],
			    ],
			    'field_options' => [
			    	1 => 'Matriculada na rede municipal',
	                2 => 'Aguardando período de matrícula (entre novembro e janeiro)',
	                3 => 'Em fila de espera de creche',
	                4 => 'Não matriculada',
	                5 => 'Não deseja creche',
                ]
		    ],
		    [
		    	'code' => 'CE98',
			    'field_type' => 'yesno',
			    'question' => 'Localizado no sistema SME',
			    'conditions' => [
			    	['CE53', 'age_between', 1, 14],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE99',
			    'field_type' => 'number',
			    'question' => 'Número de matrícula',
			    'conditions' => [
			    	['CE97', 'eq', 1],
				    ['CE98', 'is_true'],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE100',
			    'field_type' => 'date',
			    'question' => 'Data da matrícula',
			    'conditions' => [
			    	['CE97', 'eq', 1],
				    ['CE98', 'is_true'],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE101',
			    'field_type' => 'text',
			    'question' => 'Nome da Escola',
			    'conditions' => [
			    	['CE97', 'eq', 1],
				    ['CE98', 'is_true'],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE102',
			    'field_type' => 'select_one',
			    'question' => 'Situação de frequência escolar (guardar a série histórica mensal)',
			    'conditions' => [
			    	['CE97', 'eq', 1],
				    ['CE98', 'is_true'],
			    ],
			    'field_options' => [
			    	1 => 'Frequente (até 1 falta no mês)',
	                2 => 'Infrequente Leve (de 2 a 3 faltas no mês)',
	                3 => 'Infrequente Grave (de 4 a 9 faltas no mês)',
	                4 => 'Risco de Abandono (a partir de 10 faltas no mês)',
	            ]
		    ],
		    [
		    	'code' => 'CE103',
			    'field_type' => 'date',
			    'question' => 'Data de chegada de individuo encaminhado à SMDEI (alerte do CRAS) ',
			    'conditions' => [
			    	['CE104', 'eq', 1]
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE104',
			    'field_type' => 'select_one',
			    'question' => 'Encaminhamento - curso de capacitação',
			    'conditions' => null,
			    'field_options' => [
			    	1 => 'Encaminhado pelo CRAS',
                    2 => 'recebido SMDEI sem inscrição',
                    3 => 'desistiu/sem vaga',
                    4 => 'inscritos',
                    5 => 'matriculado',
                    6 => 'concluido',
                    7 => 'abandono',
                ]
		    ],
		    [
		    	'code' => 'CE105',
			    'field_type' => 'select_one',
			    'question' => 'Encaminhamento  - emissão de CTPS (alerta para todos os parceiros quando o documento estiver com status de emitido, cai o alerta quando o status for documento entregue)',
			    'conditions' => [
			    	['CE104', 'eq', 1],
			    ],
			    'field_options' => [
			    	1 => 'Encaminhado pelo CRAS',
	                2 => 'Documento Emitido',
	                3 => 'Documento Entregue',
	                4 => 'Sem Possibilidade de Emissão',
                ]
		    ],
		    [
		    	'code' => 'CE106',
			    'field_type' => 'select_one',
			    'question' => 'Encaminhamento para intermediação de emprego',
			    'conditions' => [
			    	['CE104', 'eq', 1]
			    ],
			    'field_options' => [
			    	1 => 'Encaminhado pelo CRAS',
	                2 => 'Encaminhado para entrevista',
	                3 => 'Não encaminhado para entrevista',
                ]
		    ],
		    [
		    	'code' => 'CE107',
			    'field_type' => 'select_one',
			    'question' => 'Encaminhamento para vaga de Jovem Aprendiz',
			    'conditions' => [
			    	['CE104', 'eq', 1],
			    ],
			    'field_options' => [
			    	1 => 'Encaminhado pelo CRAS',
	                2 => 'Encaminhado para entrevista',
	                3 => 'Não encaminhado para entrevista',
                ]
		    ],
		    [
		    	'code' => 'CE108',
			    'field_type' => 'date',
			    'question' => 'Data de chegada da familia ao Centro de Referência da Ass. Social - CRAS',
			    'conditions' => [
			    	['CE75', 'is_filled'],
		        ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE109',
			    'field_type' => 'select_one',
			    'question' => 'Modo do contato da familia com o CRAS',
			    'conditions' => null,
			    'field_options' => [
			    	1 => 'Ida do responsavel ao CRAS',
	                2 => 'Visita de Assistente Social da SMASDH',
                ]
		    ],
		    [
		    	'code' => 'CE110',
			    'field_type' => 'select_one',
			    'question' => 'Está inscrito no sistema CadÚnico?',
			    'conditions' => null,
			    'field_options' => [
			    	1 => 'sim',
	                2 => 'não',
	                3 => 'não tem interesse',
			    ]
		    ],
		    [
		    	'code' => 'CE112',
			    'field_type' => 'yesno',
			    'question' => 'É elegível ao Bolsa Família?',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE113',
			    'field_type' => 'select_one',
			    'question' => 'Perfil da Renda per capita',
			    'conditions' => null,
			    'field_options' => [
			    	1 => 'Até R$89 per capita',
	                2 => 'De R$89,01 até R$178,00 per capita',
	                3 => 'De R$178,01 até meio salário mínimo per capita',
	                4 => 'Acima de meio salário mínimo per capita',
			    ]
		    ],
		    [
		    	'code' => 'CE114',
			    'field_type' => 'yesno',
			    'question' => 'Recebe Cartão Família Carioca?',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE115',
			    'field_type' => 'select_one',
			    'question' => 'PAIF - Serviço de Atenção Integral à Família',
			    'conditions' => null,
			    'field_options' => [
			    	1 => 'Atendido',
	                2 => 'Acompanhado',
	                3 => 'Recusou atendimento',
                ]
		    ],
		    [
		    	'code' => 'CE116',
			    'field_type' => 'yesno',
			    'question' => 'Família com membro participante de serviço de convivencia e fortalecimento de vinculos?',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE117',
			    'field_type' => 'yesno',
			    'question' => 'Em caso de não possuir REGISTRO CIVIL/CERTIDÃO DE NASCIMENTO - individuo encaminhado ao órgão competente?',
			    'conditions' => [
			    	['CE55', 'is_false'],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE118',
			    'field_type' => 'text',
			    'question' => 'Órgão para onde foi feito o encaminhamento',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE119',
			    'field_type' => 'yesno',
			    'question' => 'Em caso de não possuir CARTEIRA DE IDENTIDADE - individuo encaminhado ao órgão competente?',
			    'conditions' => [
			    	['CE56', 'is_false'],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE120',
			    'field_type' => 'text',
			    'question' => 'Órgão para onde foi feito o encaminhamento',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE121',
			    'field_type' => 'yesno',
			    'question' => 'Em caso de não possuir CPF - individuo encaminhado ao órgão competente?',
			    'conditions' => [
			    	['CE58', 'is_false'],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE122',
			    'field_type' => 'text',
			    'question' => 'Órgão para onde foi feito o encaminhamento',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE123',
			    'field_type' => 'yesno',
			    'question' => 'Em caso de não possuir TÍTULO DE ELEITOR - individuo encaminhado ao TRE?',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE124',
			    'field_type' => 'yesno',
			    'question' => 'Situação de Idoso em isolamento identificada',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE125',
			    'field_type' => 'yesno',
			    'question' => 'Situações de trabalho infantil e/ou violencia/exploração sexual identificada',
			    'conditions' => [
			    	['CE53', 'age_lt', 18],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE126',
			    'field_type' => 'yesno',
			    'question' => 'Situação de violencia física, psicológica ou negligencia identificada',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE127',
			    'field_type' => 'yesno',
			    'question' => 'Situação de violencia contra mulher identificada',
			    'conditions' => [
			    	['CE51', 'eq', 2],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE128',
			    'field_type' => 'yesno',
			    'question' => 'Membro da família em situação de rua',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE129',
			    'field_type' => 'yesno',
			    'question' => 'Encaminhado para ações de inclusão produtiva da SMASDH',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE130',
			    'field_type' => 'yesno',
			    'question' => 'Encaminhamento para o Centro de Referencia Especializado de Assistencia Social - CREAS',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE131',
			    'field_type' => 'yesno',
			    'question' => 'Outros encaminhamentos',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE132',
			    'field_type' => 'text',
			    'question' => 'Nome do encaminhamento',
			    'conditions' => [
			    	['CE131', 'is_true'],
			    ],
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE133',
			    'field_type' => 'number',
			    'question' => 'CNS',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE134',
			    'field_type' => 'date',
			    'question' => 'Data de entrada da família no Sistema TS (início do protocolo)',
			    'conditions' => null,
			    'field_options' => null,
		    ],
		    [
		    	'code' => 'CE135',
			    'field_type' => 'number',
			    'question' => 'NSEC - Núcleo de Saúde na Escola e na Creche',
			    'conditions' => null,
			    'field_options' => null,
		    ],
	    ];

	    $map = [
	    	'residence' => [
	    		'ipm' => ['CE1', 'CE2', 'CE3', 'CE4', 'CE5', 'CE6', 'CE7', 'CE8', 'CE9', 'CE10', 'CE11', 'CE12', 'CE13', 'CE14', 'CE15', 'CE16', 'CE17', 'CE18', 'CE19', 'CE20', 'CE21', 'CE22', 'CE23', 'CE24', 'CE25', 'CE26', 'CE27', 'CE28', 'CE29', 'CE30'],
			    'saude' => ['CE85'],
			    'educacao' => [],
			    'emprego' => [],
			    'assistencia' => [],
		    ],
		    'family' => [
		    	'ipm' => ['CE3', 'CE4', 'CE31', 'CE134', 'CE32', 'CE33', 'CE34', 'CE35', 'CE36', 'CE37', 'CE38', 'CE39', 'CE41', 'CE71', 'CE72', 'CE73', 'CE74'],
			    'saude' => ['CE75', 'CE76', 'CE78', 'CE79', 'CE80', 'CE81', 'CE82', 'CE83'],
			    'educacao' => ['CE96'],
			    'emprego' => [],
			    'assistencia' => ['CE108', 'CE109', 'CE78', 'CE79', 'CE80', 'CE110', 'CE41', 'CE34', 'CE112', 'CE113', 'CE114', 'CE115', 'CE116', 'CE124', 'CE125', 'CE126', 'CE127', 'CE128', 'CE46', 'CE129', 'CE35', 'CE81'],
		    ],
		    'person' => [
			    'ipm' => ['CE3', 'CE4', 'CE31', 'CE47', 'CE48', 'CE49', 'CE50', 'CE51', 'CE52', 'CE53', 'CE54', 'CE55', 'CE56', 'CE57', 'CE58', 'CE59', 'CE62', 'CE63', 'CE70'],
			    'saude' => ['CE86', 'CE133', 'CE87', 'CE54', 'CE89', 'CE90', 'CE91', 'CE92', 'CE93', 'CE94', 'CE95'],
			    'educacao' => ['CE97', 'CE98', 'CE99', 'CE100', 'CE101', 'CE102', 'CE66', 'CE67', 'CE68', 'CE69'],
			    'emprego' => ['CE103', 'CE104', 'CE105', 'CE106', 'CE107'],
	            'assistencia' => ['CE55', 'CE117', 'CE118', 'CE56', 'CE57', 'CE119', 'CE120', 'CE58', 'CE59', 'CE121', 'CE122', 'CE60', 'CE105', 'CE61', 'CE123', 'CE66', 'CE67', 'CE68', 'CE69', 'CE130', 'CE131', 'CE132', 'CE104', 'CE106', 'CE107', 'CE62', 'CE63', 'CE64', 'CE65'],
		    ],
	    ];

	    $qdb = collect([]);
	    $catdb = [
	    	'ipm' => collect([]),
		    'saude' => collect([]),
		    'educacao' => collect([]),
		    'emprego' => collect([]),
		    'assistencia' => collect([]),
	    ];

	    foreach($questions as $q) {
	    	$qdb[$q['code']] = new Question();
	    	$qdb[$q['code']]->fill($q);
	    }

	    foreach($map as $entityType => $categoryMap) {
	    	foreach($categoryMap as $categoryKey => $questionCodes) {
	    		$catdb[$categoryKey]->merge($questionCodes);

	    		foreach($questionCodes as $code) {
	    			$qdb[$code]->entity_type = $entityType;
	    			//$qdb[$code]->save();

				    // TODO: resolve design issue -> the same question have different entity types depending on category
				    // TODO: maybe move entity_type to the association between question and questioncategory?
				    // TODO: there's a missing key called 'dimension'; how relevant is it?
			    }
		    }
	    }




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
