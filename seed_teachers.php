<?php

$data = [
    ['nama' => 'TIKA RAHMAWATI', 'kategori' => 'Guru', 'link_web' => 'https://sites.google.com/view/tika-rahmawati', 'urutan' => 2, 'aktif' => 1],
    ['nama' => 'AbduRahman Arif', 'kategori' => 'Guru', 'link_web' => 'https://sites.google.com/guru.smk.belajar.id/website-guru-arif', 'urutan' => 3, 'aktif' => 1],
    ['nama' => 'Ahmad Dani', 'kategori' => 'Guru', 'link_web' => 'https://sites.google.com/view/dashboard-ahmaddani', 'urutan' => 4, 'aktif' => 1],
    ['nama' => 'Muhammad Agni Nur', 'kategori' => 'Guru', 'link_web' => 'https://sites.google.com/view/websmkag/smk', 'urutan' => 5, 'aktif' => 1],
    ['nama' => 'Ani Nuriyani', 'kategori' => 'Guru', 'link_web' => 'https://sites.google.com/view/ani-nuriyani/halaman-muka', 'urutan' => 6, 'aktif' => 1],
    ['nama' => 'Yusfiah Latifah', 'kategori' => 'Guru', 'link_web' => 'https://sites.google.com/view/poyula/portal-yusfiah-latifah', 'urutan' => 7, 'aktif' => 1],
    ['nama' => 'Alis Tati Hartati, S.Pd', 'kategori' => 'Guru', 'link_web' => 'https://sites.google.com/view/alistatihartati/halaman-muka', 'urutan' => 8, 'aktif' => 1],
    ['nama' => 'VITA FATIMAH', 'kategori' => 'Guru', 'link_web' => 'https://sites.google.com/view/vita-fatimah/vita', 'urutan' => 9, 'aktif' => 1],
    ['nama' => 'Muhammad Hilmi', 'kategori' => 'Guru', 'link_web' => 'https://sites.google.com/view/muhammadhilmi/site', 'urutan' => 10, 'aktif' => 1],
    ['nama' => 'Ismia Hazar Ridwan', 'kategori' => 'Guru', 'link_web' => 'https://script.google.com/macros/s/AKfycbzEXvWTi_9P-LdZK', 'urutan' => 11, 'aktif' => 1],
    ['nama' => 'Muhammad Rafi Arrohman', 'kategori' => 'Guru', 'link_web' => 'https://sites.google.com/view/rafiarrohman/link', 'urutan' => 12, 'aktif' => 1],
];

foreach ($data as $t) {
    // Check if exists to prevent duplicate runs
    if (!App\Models\Teacher::where('nama', $t['nama'])->exists()) {
        App\Models\Teacher::create($t);
    }
}
echo "Teachers seeded successfully.";
