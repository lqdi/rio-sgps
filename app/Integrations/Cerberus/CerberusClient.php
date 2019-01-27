<?php
/**
 * rio-sgps
 * Cerberus.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2019
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 27/01/2019, 18:08
 */

namespace SGPS\Integrations\Cerberus;


use Illuminate\Config\Repository as Config;
use SGPS\Integrations\AbstractHttpClient;

class CerberusClient extends AbstractHttpClient {

	private $endpoint;
	private $environment;
	private $systemID;
	private $systemCode;
	private $apiKey;

	public function __construct(Config $config) {
		$this->endpoint = $config->get('cerberus.endpoint');
		$this->environment = $config->get('cerberus.environment');
		$this->systemID = $config->get('cerberus.system_id');
		$this->systemCode = $config->get('cerberus.system_code');
		$this->apiKey = $config->get('cerberus.api_key');
	}

	public function getEndpointBase(): string {
		return $this->endpoint;
	}

	public function authenticateUser(string $login, string $password) : ?CerberusUser {

		$response = $this->get(
			'seam/resource/v1/permissoes',
			[
				"ambiente: {$this->environment}",
				"provedor: {$this->systemID}",
				"consumidor: {$this->systemID}",
				"chaveAcesso: {$this->apiKey}",
				"usuario: {$login}",
				"senhaUsuario: {$password}",
			]
		);

		return new CerberusUser($response->content);

	}
}