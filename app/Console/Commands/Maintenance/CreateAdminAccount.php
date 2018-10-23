<?php
/**
 * rio-sgps
 * CreateAdminAccount.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinamba <aryel.tupinamba@lqdi.net>
 *
 * Created at: 05/09/2018, 18:55
 */

namespace SGPS\Console\Commands\Maintenance;


use Illuminate\Console\Command;
use SGPS\Constants\Role;
use SGPS\Entity\User;

class CreateAdminAccount extends Command {

	protected $signature = 'maintenance:create_admin';

	public function handle() {

		$name = $this->ask("Name", "Engineering LQDI");
		$email = $this->ask("E-mail", "dev@lqdi.net");
		$password = $this->ask("Password", "demo");

		$user = new User();
		$user->name = $name;
		$user->email = $email;
		$user->setPassword($password);
		$user->save();

		$user->assignRole(Role::ADMIN);

		$this->info("User created - ID: {$user->id}");

	}

}