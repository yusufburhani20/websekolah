<?php

namespace App\Filament\Exports;

use App\Models\TracerStudy;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TracerStudyExporter extends Exporter
{
    protected static ?string $model = TracerStudy::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('nama_lengkap')->label('Nama Lengkap'),
            ExportColumn::make('jenis_kelamin')->label('Jenis Kelamin'),
            ExportColumn::make('no_hp')->label('No. HP'),
            ExportColumn::make('alamat_lengkap')->label('Alamat Lengkap'),
            ExportColumn::make('jurusan.nama_jurusan')->label('Jurusan'),
            ExportColumn::make('tahun_masuk')->label('Tahun Masuk'),
            ExportColumn::make('tahun_keluar')->label('Tahun Lulus'),
            ExportColumn::make('status')->label('Status')->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state),
            ExportColumn::make('pekerjaan')->label('Jabatan / Pekerjaan'),
            ExportColumn::make('nama_perusahaan')->label('Nama Perusahaan'),
            ExportColumn::make('kampus')->label('Nama Kampus'),
            ExportColumn::make('jurusan_kuliah')->label('Jurusan Kuliah'),
            ExportColumn::make('bidang_usaha')->label('Bidang Usaha'),
            ExportColumn::make('alamat_instansi')->label('Alamat Instansi/Kampus/Usaha'),
            ExportColumn::make('created_at')->label('Tanggal Pengisian'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your tracer study export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
