<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
		$admin = Role::create(['name' => 'admin']);
		Role::create(['name' => 'client']);
		Role::create(['name' => 'user']);

		$users = User::all();
		foreach($users as $user) {
			$user->assignRole($admin);
		}
	}
}
