<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ["username" => "admin"],
            [
                "name"     => "Super Admin",
                "email"    => "admin@smk-idrisiyyah.sch.id",
                "username" => "admin",
                "password" => bcrypt("Admin@2026!"),
            ]
        );
        $admin->assignRole("super_admin");

        $this->command->info("✅ Admin user dibuat:");
        $this->command->info("   Username : admin");
        $this->command->info("   Password : Admin@2026!");
        $this->command->info("   ⚠️  Segera ganti password setelah login pertama!");
    }
}
