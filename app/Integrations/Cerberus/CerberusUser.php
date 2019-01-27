<?php
/**
 * rio-sgps
 * CerberusUser.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2019
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 27/01/2019, 18:44
 */

namespace SGPS\Integrations\Cerberus;


class CerberusUser {

	public $email;
	public $cpf;
	public $matricula;
	public $nome;
	public $ativo;

	public $perfis = [];

	public function __construct($apiResponse) {
		$this->email = strval($apiResponse->usuario->email ?? null);
		$this->cpf = strval($apiResponse->usuario->cpf ?? null);
		$this->matricula = strval($apiResponse->usuario->matricula ?? null);
		$this->nome = strval($apiResponse->usuario->nome ?? null);
		$this->ativo = boolval($apiResponse->usuario->ativo ?? false);

		$this->perfis = (array) $apiResponse->perfis;
	}

}