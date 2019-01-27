<?php
/**
 * rio-sgps
 * CerberusService.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2019
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 27/01/2019, 18:02
 */

namespace SGPS\Services;


use Illuminate\Auth\AuthenticationException;
use SGPS\Constants\UserLevel;
use SGPS\Entity\User;
use SGPS\Integrations\Cerberus\CerberusClient;
use SGPS\Integrations\Cerberus\CerberusUser;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CerberusAuthenticationService {

	/**
	 * CERBERUS API client.
	 * Injected by the Laravel container.
	 *
	 * @var CerberusClient
	 */
	private $client = null;

	public function __construct(CerberusClient $cerberusClient) {
		$this->client = $cerberusClient;
	}

	/**
	 * Attempts to authenticate a user against the CERBERUS system.
	 * If successful, will login the user into the local session.
	 * If not, will throw an exception.
	 * If the user is valid on CERBERUS but does not exist locally, it will create one.
	 *
	 * @param string $login The user login (CPF or matrícula).
	 * @param string $password The user password (in cleartext).
	 * @param bool $remember Should this session be remembered?
	 * @return User The logged/created user.
	 * @throws AuthenticationException If the user is not found (cerberus_user_not_found).
	 * @throws AuthenticationException If the user is not active (cerberus_user_not_active).
	 * @throws AccessDeniedHttpException If the returned user does not have CPF or matrícula (cerberus_user_has_no_login_data).
	 */
	public function authenticate(string $login, string $password, bool $remember = false) : User {
		$cerberusUser = $this->client->authenticateUser($login, $password);

		if(is_null($cerberusUser)) { // Checks if the response from the server was a valid object
			throw new AuthenticationException('cerberus_user_not_found');
		}

		if(!$cerberusUser->ativo) { // Checks if the flag for the user is active
			throw new AuthenticationException('cerberus_user_not_active');
		}

		// Check if user has either email, CPF or Matricula so we can search locally for them
		if(is_null($cerberusUser->email) && is_null($cerberusUser->cpf) && is_null($cerberusUser->matricula)) {
			throw new AccessDeniedHttpException('cerberus_user_has_no_login_data');
		}

		// Looks for the local user with these credentials
		$user = $this->findUserWithCerberusLogon($cerberusUser);

		// If not found, we create one
		if(!$user) {
			$user = $this->createUserWithCerberusLogon($cerberusUser);
		}

		// Login the user into the current session
		auth()->login($user, $remember);

		return $user;
	}

	/**
	 * Finds a user by their CERBERUS logon data.
	 * Will look for email, CPF or matrícula (registration_number)
	 * @param CerberusUser $cerberusUser The CERBERUS logon data. @see self::authenticate
	 * @return User|null|object The user object, or null if not found.
	 */
	public function findUserWithCerberusLogon(CerberusUser $cerberusUser) {
		return User::query()
			->where('email', $cerberusUser->email)
			->orWhere('cpf', $cerberusUser->cpf)
			->orWhere('registration_number', $cerberusUser->matricula)
			->first();
	}

	/**
	 * Creates a user based on their CERBERUS logon data.
	 * @param CerberusUser $cerberusUser The CERBERUS logon data. @see self::authenticate
	 * @return User The created local user.
	 */
	public function createUserWithCerberusLogon(CerberusUser $cerberusUser) : User {

		return User::createFromExternal(
			$cerberusUser->nome,
			$cerberusUser->email,
			$cerberusUser->cpf,
			$cerberusUser->matricula,
			$this->resolveUserLevel($cerberusUser),
			'cerberus'
		);

	}

	/**
	 * Resolves a local user level based on CERBERUS logon list of profiles (perfis).
	 * Basically, the highest profile found 'wins'.
	 *
	 * @param CerberusUser $cerberusUser The CERBERUS logon data. @see self::authenticate
	 * @return string The corresponding local user level @see \SGPS\Constants\UserLevel
	 */
	public function resolveUserLevel(CerberusUser $cerberusUser) {
		$profiles = collect($cerberusUser->perfis);

		if($profiles->contains('ADMINISTRADOR')) {
			return UserLevel::ADMIN;
		}

		if($profiles->contains('GESTOR')) {
			return UserLevel::GESTOR;
		}

		if($profiles->contains('COORDENADOR')) {
			return UserLevel::COORDENADOR;
		}

		return UserLevel::OPERADOR;
	}


}