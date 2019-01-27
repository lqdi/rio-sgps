<?php
/**
 * rio-sgps
 * TestCerberusAuthentication.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2019
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 27/01/2019, 18:03
 */

namespace SGPS\Console\Commands\Maintenance;


use Illuminate\Console\Command;
use SGPS\Integrations\Cerberus\CerberusClient;
use SGPS\Services\CerberusAuthenticationService;

class TestCerberusAuthentication extends Command {

	protected $signature = 'maintenance:test_cerberus_auth';

	public function handle(CerberusClient $cerberus) {

		$this->info("Cerberus endpoint: {$cerberus->getEndpointBase()}");

		$cpf = $this->ask("CPF: ", "37093435858");
		$password = $this->secret("Senha: ", true);

		$result = $cerberus->authenticateUser($cpf, $password);

		dd($result);


	}

}