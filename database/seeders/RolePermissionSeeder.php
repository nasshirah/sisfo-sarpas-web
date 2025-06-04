<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        
        // Buat roles
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);
        // Buat user admin & assign role
        $adminUser = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $adminUser->assignRole($admin);
        // Buat user biasa & assign role
        $normalUser = User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);
        $normalUser->assignRole($user);
    }
}

