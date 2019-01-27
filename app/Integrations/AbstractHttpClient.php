<?php
/**
 * rio-sgps
 * CurlHttpService.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2019
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 27/01/2019, 18:08
 */

namespace SGPS\Integrations;

use Curl;

abstract class AbstractHttpClient {

	const HTTP_SUCCESS_CODES = [200, 201, 202, 204];

	public abstract function getEndpointBase() : string;

	public function getEndpointURL(string $path) : string {
		return str_finish($this->getEndpointBase(), '/') . $path;
	}

	protected function getDefaultHeaders() : array {
		return [
			'Accept: application/json'
		];
	}

	protected function buildRequest(string $path, array $headers = []) {

		$requestHeaders = array_merge($this->getDefaultHeaders(), $headers);

		return Curl::to($this->getEndpointURL($path))
			->withContentType('application/json')
			->asJsonResponse()
			->returnResponseObject()
			->withHeaders($requestHeaders);
	}

	protected function parseResponse($response) {

		if(!is_array($response) && !is_object($response)) {
			return json_decode($response, true);
		}

		return $response;
	}

	public function post(string $path, array $payload, array $headers = []) {

		$response = $this->buildRequest($path, $headers)
			->withData(json_encode($payload))
			->post();

		return $this->parseResponse($response);

	}

	public function put(string $path, array $payload, array $headers = []) {

		$response = $this->buildRequest($path, $headers)
			->withData(json_encode($payload))
			->put();

		return $this->parseResponse($response);

	}

	public function get(string $path, array $headers = []) {

		$response = $this->buildRequest($path, $headers)->get();

		return $this->parseResponse($response);

	}

	public function delete(string $path, array $headers = []) {

		$response = $this->buildRequest($path, $headers)->delete();

		return $this->parseResponse($response);

	}

}