<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $guarded = [];

    protected $casts = [
        "show_hero_text" => "boolean",
        "info_sekolah_aktif" => "boolean",
        "show_profil" => "boolean",
        "show_sambutan" => "boolean",
        "show_statistik" => "boolean",
        "show_keunggulan" => "boolean",
        "show_program" => "boolean",
        "show_chart" => "boolean",
        "show_program_utama" => "boolean",
        "header_akreditasi_aktif" => "boolean",
        "header_pendaftaran_aktif" => "boolean",
        "header_pendaftaran_newtab" => "boolean",
        "sidebar_show_sosmed" => "boolean",
        "sidebar_show_artikel" => "boolean",
        "popup_aktif" => "boolean",
    ];
}
