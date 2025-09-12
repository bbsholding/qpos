<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use App\Models\Setting;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StartUpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = User::create([
            'name' => 'Mr Admin',
            'email' => 'demo@qtecsolution.net',
            'password' => bcrypt("password"),
            'username' => uniqid()
        ]);
        Customer::create([
            'name' => "Client Ambulant",
            'phone' => "password",
        ]);
        Supplier::create([
            'name' => "Propre Fournisseur",
            'phone' => "password",
        ]);
        $role = Role::create(['name' => 'Admin']);
        $user->syncRoles($role);
        $this->call([
            UnitSeeder::class,
            CurrencySeeder::class,
            RolePermissionSeeder::class,
        ]);
    }
}
