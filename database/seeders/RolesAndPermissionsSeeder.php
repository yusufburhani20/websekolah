<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // CMS
            "view posts", "create posts", "edit posts", "delete posts",
            "view pages", "create pages", "edit pages", "delete pages",
            "view teachers", "create teachers", "edit teachers", "delete teachers",
            "view documents", "create documents", "edit documents", "delete documents",
            "view menus", "create menus", "edit menus", "delete menus",
            "view messages", "delete messages",
            "view media", "upload media", "delete media",
            "manage settings",
            // PPDB
            "view ppdb", "manage ppdb", "verify ppdb payments", "decide ppdb selections",
            // Kurikulum
            "view curricula", "manage curricula", "view pkl", "manage pkl",
            "view bk", "manage bk",
            // Eskul
            "view extracurriculars", "manage extracurriculars",
            // LMS
            "view courses", "manage courses", "grade assignments",
            // Admin
            "manage users", "manage roles",
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(["name" => $perm, "guard_name" => "web"]);
        }

        // Super Admin — akses semua
        $superAdmin = Role::firstOrCreate(["name" => "super_admin", "guard_name" => "web"]);
        $superAdmin->syncPermissions(Permission::all());

        // Admin — semua kecuali manage roles
        $admin = Role::firstOrCreate(["name" => "admin", "guard_name" => "web"]);
        $admin->syncPermissions(Permission::whereNotIn("name", ["manage roles"])->get());

        // Editor — hanya CMS content
        $editor = Role::firstOrCreate(["name" => "editor", "guard_name" => "web"]);
        $editor->syncPermissions([
            "view posts", "create posts", "edit posts",
            "view pages", "create pages", "edit pages",
            "view teachers", "view documents",
            "view media", "upload media",
        ]);

        // Guru — LMS + view
        $guru = Role::firstOrCreate(["name" => "guru", "guard_name" => "web"]);
        $guru->syncPermissions([
            "view courses", "manage courses", "grade assignments",
            "view curricula", "view pkl",
        ]);

        // PPDB Officer
        $ppdbOfficer = Role::firstOrCreate(["name" => "ppdb_officer", "guard_name" => "web"]);
        $ppdbOfficer->syncPermissions([
            "view ppdb", "manage ppdb", "verify ppdb payments", "decide ppdb selections",
        ]);

        $this->command->info("✅ Roles & Permissions selesai dibuat.");
    }
}
