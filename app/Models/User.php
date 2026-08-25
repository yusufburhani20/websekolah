<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        "name",
        "username",
        "email",
        "password",
        "foto",
    ];

    protected $hidden = [
        "password",
        "remember_token",
    ];

    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password"          => "hashed",
        ];
    }

    // Izinkan akses Filament Panel untuk super_admin dan admin
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole(["super_admin", "admin", "editor", "ppdb_officer", "guru"]);
    }
}
