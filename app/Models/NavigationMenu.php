<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NavigationMenu extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function children()
    {
        return $this->hasMany(NavigationMenu::class, 'parent_id')->where('status', 'aktif')->orderBy('urutan');
    }
}
