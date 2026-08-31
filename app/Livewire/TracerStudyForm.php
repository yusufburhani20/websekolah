<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Jurusan;
use App\Models\TracerStudy;

class TracerStudyForm extends Component
{
    public $step = 1;
    
    // Step 1
    public $nama_lengkap;
    public $jenis_kelamin;
    public $no_hp;
    public $alamat_lengkap;
    
    // Step 2
    public $jurusan_id;
    public $tahun_masuk;
    public $tahun_keluar;
    
    // Step 3
    public $status = []; // Now an array
    public $pekerjaan;
    public $nama_perusahaan;
    public $kampus;
    public $jurusan_kuliah;
    public $bidang_usaha;
    public $alamat_instansi;

    public $successMessage = false;

    // Computed properties for dropdowns
    public function getTahunMasukOptionsProperty()
    {
        $currentYear = date('Y');
        return range($currentYear, $currentYear - 30);
    }

    public function getTahunKeluarOptionsProperty()
    {
        if (!$this->tahun_masuk) {
            return [];
        }
        $currentYear = date('Y') + 1;
        // Graduation is usually 3-4 years after admission
        return range($currentYear, $this->tahun_masuk);
    }

    public function toggleStatus($value)
    {
        if (in_array($value, $this->status)) {
            $this->status = array_diff($this->status, [$value]);
        } else {
            $this->status[] = $value;
            // Clear 'Mencari Kerja' if they select something else
            if ($value !== 'Mencari Kerja') {
                $this->status = array_diff($this->status, ['Mencari Kerja']);
            } else {
                // If they select 'Mencari Kerja', clear others
                $this->status = ['Mencari Kerja'];
            }
        }
    }

    public function nextStep()
    {
        $this->validateStep();
        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    protected function validateStep()
    {
        if ($this->step === 1) {
            $this->validate([
                'nama_lengkap' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'no_hp' => 'required|string|max:20',
                'alamat_lengkap' => 'nullable|string',
            ], $this->messages, $this->validationAttributes);
        } elseif ($this->step === 2) {
            $this->validate([
                'jurusan_id' => 'required|exists:jurusans,id',
                'tahun_masuk' => 'required|integer',
                'tahun_keluar' => 'required|integer|gte:tahun_masuk',
            ], $this->messages, $this->validationAttributes);
        }
    }

    protected $messages = [
        'required' => ':attribute wajib diisi.',
        'required_if' => ':attribute wajib diisi.',
        'gte' => ':attribute harus lebih besar atau sama dengan Tahun Masuk.',
        'min' => 'Pilih minimal satu :attribute.',
    ];

    protected $validationAttributes = [
        'nama_lengkap' => 'Nama Lengkap',
        'jenis_kelamin' => 'Jenis Kelamin',
        'jurusan_id' => 'Jurusan / Program Keahlian',
        'no_hp' => 'No. HP',
        'alamat_lengkap' => 'Alamat Lengkap',
        'tahun_masuk' => 'Tahun Masuk',
        'tahun_keluar' => 'Tahun Keluar (Lulus)',
        'status' => 'Status',
        'pekerjaan' => 'Pekerjaan',
        'nama_perusahaan' => 'Nama Perusahaan',
        'kampus' => 'Nama Kampus',
        'jurusan_kuliah' => 'Jurusan Kuliah',
        'bidang_usaha' => 'Bidang Usaha',
    ];

    public function submit()
    {
        // Final validation
        $rules = [
            'status' => 'required|array|min:1',
            'alamat_instansi' => 'nullable|string',
        ];

        if (in_array('Bekerja', $this->status)) {
            $rules['pekerjaan'] = 'required|string|max:255';
            $rules['nama_perusahaan'] = 'required|string|max:255';
        }

        if (in_array('Kuliah', $this->status)) {
            $rules['kampus'] = 'required|string|max:255';
            $rules['jurusan_kuliah'] = 'required|string|max:255';
        }

        if (in_array('Wirausaha', $this->status)) {
            $rules['bidang_usaha'] = 'required|string|max:255';
        }

        $this->validate($rules, $this->messages, $this->validationAttributes);

        TracerStudy::create([
            'nama_lengkap' => $this->nama_lengkap,
            'jenis_kelamin' => $this->jenis_kelamin,
            'jurusan_id' => $this->jurusan_id,
            'no_hp' => $this->no_hp,
            'alamat_lengkap' => $this->alamat_lengkap,
            'tahun_masuk' => $this->tahun_masuk,
            'tahun_keluar' => $this->tahun_keluar,
            'status' => $this->status,
            'pekerjaan' => in_array('Bekerja', $this->status) ? $this->pekerjaan : null,
            'nama_perusahaan' => in_array('Bekerja', $this->status) ? $this->nama_perusahaan : null,
            'kampus' => in_array('Kuliah', $this->status) ? $this->kampus : null,
            'jurusan_kuliah' => in_array('Kuliah', $this->status) ? $this->jurusan_kuliah : null,
            'bidang_usaha' => in_array('Wirausaha', $this->status) ? $this->bidang_usaha : null,
            'alamat_instansi' => in_array('Mencari Kerja', $this->status) && count($this->status) === 1 ? null : $this->alamat_instansi,
        ]);

        $this->successMessage = true;
        $this->resetExcept('successMessage');
    }

    public function render()
    {
        return view('livewire.tracer-study-form', [
            'jurusans' => Jurusan::where('aktif', 1)->orderBy('nama_jurusan')->get(),
            'tahunMasukOptions' => $this->tahunMasukOptions,
            'tahunKeluarOptions' => $this->tahunKeluarOptions,
        ]);
    }
}
