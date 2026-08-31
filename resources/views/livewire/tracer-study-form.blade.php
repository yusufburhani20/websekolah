<div>
    @if($successMessage)
    <div class="bg-emerald-50 border border-emerald-200 rounded-3xl p-8 text-center animate-fade-in-up">
        <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fa-solid fa-check text-4xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-slate-800 mb-2">Terima Kasih!</h3>
        <p class="text-slate-600 mb-6">Data Tracer Study Anda telah berhasil dikirim. Kami sangat mengapresiasi partisipasi Anda.</p>
        <button wire:click="$set('successMessage', false)" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-emerald-500/30">
            Isi Data Lagi
        </button>
    </div>
    @else
    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 p-8 sm:p-12 overflow-hidden relative">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-brand-50 rounded-full blur-3xl -mr-32 -mt-32 opacity-60 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-amber-50 rounded-full blur-3xl -ml-32 -mb-32 opacity-60 pointer-events-none"></div>

        <div class="relative z-10">
            <!-- Progress Bar -->
            <div class="mb-10">
                <div class="flex items-center justify-between relative">
                    <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-slate-100 -z-10 rounded-full"></div>
                    <div class="absolute left-0 top-1/2 transform -translate-y-1/2 h-1 bg-brand-500 -z-10 rounded-full transition-all duration-500" style="width: {{ ($step - 1) * 50 }}%"></div>
                    
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all {{ $step >= 1 ? 'bg-brand-500 text-white shadow-lg shadow-brand-500/40' : 'bg-slate-200 text-slate-500' }}">1</div>
                        <span class="text-xs font-bold mt-2 {{ $step >= 1 ? 'text-brand-600' : 'text-slate-400' }}">Data Diri</span>
                    </div>
                    
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all {{ $step >= 2 ? 'bg-brand-500 text-white shadow-lg shadow-brand-500/40' : 'bg-slate-200 text-slate-500' }}">2</div>
                        <span class="text-xs font-bold mt-2 {{ $step >= 2 ? 'text-brand-600' : 'text-slate-400' }}">Akademik</span>
                    </div>

                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all {{ $step >= 3 ? 'bg-brand-500 text-white shadow-lg shadow-brand-500/40' : 'bg-slate-200 text-slate-500' }}">3</div>
                        <span class="text-xs font-bold mt-2 {{ $step >= 3 ? 'text-brand-600' : 'text-slate-400' }}">Status</span>
                    </div>
                </div>
            </div>

            <form wire:submit.prevent="submit" class="space-y-8">
                
                <!-- STEP 1: Data Diri -->
                @if($step == 1)
                <div class="animate-fade-in-up">
                    <div class="border-b border-slate-100 pb-4 mb-6">
                        <h2 class="text-xl font-bold text-slate-800 flex items-center">
                            <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center text-brand-600 mr-4">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            Data Pribadi
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-full">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap *</label>
                            <input type="text" wire:model.defer="nama_lengkap" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all" placeholder="Masukkan nama lengkap Anda">
                            @error('nama_lengkap') <span class="text-xs text-red-500 mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Kelamin *</label>
                            <select wire:model.defer="jenis_kelamin" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all appearance-none">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            @error('jenis_kelamin') <span class="text-xs text-red-500 mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">No. WhatsApp / HP (Aktif) *</label>
                            <input type="text" wire:model.defer="no_hp" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all" placeholder="Contoh: 08123456789">
                            @error('no_hp') <span class="text-xs text-red-500 mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-full">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap (Saat Ini) *</label>
                            <textarea wire:model.defer="alamat_lengkap" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all" placeholder="Masukkan alamat domisili saat ini"></textarea>
                            @error('alamat_lengkap') <span class="text-xs text-red-500 mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                @endif

                <!-- STEP 2: Akademik -->
                @if($step == 2)
                <div class="animate-fade-in-up">
                    <div class="border-b border-slate-100 pb-4 mb-6">
                        <h2 class="text-xl font-bold text-slate-800 flex items-center">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 mr-4">
                                <i class="fa-solid fa-school"></i>
                            </div>
                            Riwayat Sekolah
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-full">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Jurusan / Program Keahlian *</label>
                            <select wire:model.defer="jurusan_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all appearance-none">
                                <option value="">-- Pilih Jurusan Saat Sekolah --</option>
                                @foreach($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                                @endforeach
                            </select>
                            @error('jurusan_id') <span class="text-xs text-red-500 mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tahun Masuk (Daftar) *</label>
                            <select wire:model.live="tahun_masuk" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all appearance-none">
                                <option value="">-- Pilih Tahun --</option>
                                @foreach($tahunMasukOptions as $thn)
                                <option value="{{ $thn }}">{{ $thn }}</option>
                                @endforeach
                            </select>
                            @error('tahun_masuk') <span class="text-xs text-red-500 mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tahun Keluar (Lulus) *</label>
                            <select wire:model.defer="tahun_keluar" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all appearance-none">
                                <option value="">-- Pilih Tahun --</option>
                                @foreach($tahunKeluarOptions as $thn)
                                <option value="{{ $thn }}">{{ $thn }}</option>
                                @endforeach
                            </select>
                            @error('tahun_keluar') <span class="text-xs text-red-500 mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                @endif

                <!-- STEP 3: Status & Detail -->
                @if($step == 3)
                <div class="animate-fade-in-up">
                    <div class="border-b border-slate-100 pb-4 mb-6">
                        <h2 class="text-xl font-bold text-slate-800 flex items-center">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500 mr-4">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>
                            Status Saat Ini
                        </h2>
                        <p class="text-slate-500 text-sm mt-2">Anda bisa memilih lebih dari satu status (contoh: Kuliah dan Bekerja).</p>
                    </div>

                    <div class="mb-8">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div wire:click="toggleStatus('Bekerja')" class="cursor-pointer rounded-xl border px-4 py-3 text-center transition-all hover:bg-slate-100 {{ in_array('Bekerja', $status) ? 'bg-brand-50 border-brand-500 text-brand-700 font-bold' : 'bg-slate-50 border-slate-200' }}">
                                <i class="fa-solid fa-briefcase block mb-2 text-xl {{ in_array('Bekerja', $status) ? 'text-brand-500' : 'text-slate-400' }}"></i>
                                Bekerja
                            </div>
                            <div wire:click="toggleStatus('Kuliah')" class="cursor-pointer rounded-xl border px-4 py-3 text-center transition-all hover:bg-slate-100 {{ in_array('Kuliah', $status) ? 'bg-brand-50 border-brand-500 text-brand-700 font-bold' : 'bg-slate-50 border-slate-200' }}">
                                <i class="fa-solid fa-graduation-cap block mb-2 text-xl {{ in_array('Kuliah', $status) ? 'text-brand-500' : 'text-slate-400' }}"></i>
                                Kuliah
                            </div>
                            <div wire:click="toggleStatus('Wirausaha')" class="cursor-pointer rounded-xl border px-4 py-3 text-center transition-all hover:bg-slate-100 {{ in_array('Wirausaha', $status) ? 'bg-brand-50 border-brand-500 text-brand-700 font-bold' : 'bg-slate-50 border-slate-200' }}">
                                <i class="fa-solid fa-store block mb-2 text-xl {{ in_array('Wirausaha', $status) ? 'text-brand-500' : 'text-slate-400' }}"></i>
                                Wirausaha
                            </div>
                            <div wire:click="toggleStatus('Mencari Kerja')" class="cursor-pointer rounded-xl border px-4 py-3 text-center transition-all hover:bg-slate-100 {{ in_array('Mencari Kerja', $status) ? 'bg-brand-50 border-brand-500 text-brand-700 font-bold' : 'bg-slate-50 border-slate-200' }}">
                                <i class="fa-solid fa-magnifying-glass block mb-2 text-xl {{ in_array('Mencari Kerja', $status) ? 'text-brand-500' : 'text-slate-400' }}"></i>
                                Mencari Kerja
                            </div>
                        </div>
                        @error('status') <span class="text-xs text-red-500 mt-2 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span> @enderror
                    </div>

                    @if(in_array('Bekerja', $status))
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-emerald-50/50 p-6 rounded-2xl border border-emerald-100 mb-6 animate-fade-in-up">
                        <div class="col-span-full">
                            <h3 class="font-bold text-emerald-800 border-b border-emerald-200 pb-2"><i class="fa-solid fa-briefcase mr-2"></i> Detail Pekerjaan</h3>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Posisi / Jabatan *</label>
                            <input type="text" wire:model.defer="pekerjaan" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-slate-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all" placeholder="Contoh: Staff IT">
                            @error('pekerjaan') <span class="text-xs text-red-500 mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Perusahaan / Instansi *</label>
                            <input type="text" wire:model.defer="nama_perusahaan" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-slate-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all" placeholder="Contoh: PT. Maju Bersama">
                            @error('nama_perusahaan') <span class="text-xs text-red-500 mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span> @enderror
                        </div>
                    </div>
                    @endif

                    @if(in_array('Kuliah', $status))
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-blue-50/50 p-6 rounded-2xl border border-blue-100 mb-6 animate-fade-in-up">
                        <div class="col-span-full">
                            <h3 class="font-bold text-blue-800 border-b border-blue-200 pb-2"><i class="fa-solid fa-graduation-cap mr-2"></i> Detail Pendidikan</h3>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Kampus / Universitas *</label>
                            <input type="text" wire:model.defer="kampus" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Contoh: Universitas Terbuka">
                            @error('kampus') <span class="text-xs text-red-500 mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Jurusan / Program Studi *</label>
                            <input type="text" wire:model.defer="jurusan_kuliah" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Contoh: S1 Teknik Informatika">
                            @error('jurusan_kuliah') <span class="text-xs text-red-500 mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span> @enderror
                        </div>
                    </div>
                    @endif

                    @if(in_array('Wirausaha', $status))
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-amber-50/50 p-6 rounded-2xl border border-amber-100 mb-6 animate-fade-in-up">
                        <div class="col-span-full">
                            <h3 class="font-bold text-amber-800 border-b border-amber-200 pb-2"><i class="fa-solid fa-store mr-2"></i> Detail Usaha</h3>
                        </div>
                        <div class="col-span-full">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Bidang Usaha / Nama Usaha *</label>
                            <input type="text" wire:model.defer="bidang_usaha" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-slate-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all" placeholder="Contoh: Toko Online Pakaian / Kedai Kopi">
                            @error('bidang_usaha') <span class="text-xs text-red-500 mt-1 block"><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</span> @enderror
                        </div>
                    </div>
                    @endif

                    @if(count(array_diff($status, ['Mencari Kerja'])) > 0)
                    <div class="mt-6 mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Instansi / Kampus / Tempat Usaha</label>
                        <textarea wire:model.defer="alamat_instansi" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all" placeholder="Masukkan alamat lengkap (Opsional)"></textarea>
                    </div>
                    @endif

                </div>
                @endif

                <!-- Navigation Buttons -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                    @if($step > 1)
                    <button type="button" wire:click="previousStep" class="text-slate-500 font-bold hover:text-slate-800 transition-colors px-4 py-2">
                        <i class="fa-solid fa-arrow-left mr-2"></i> Sebelumnya
                    </button>
                    @else
                    <div></div> <!-- Placeholder to keep Next button on the right -->
                    @endif

                    @if($step < 3)
                    <button type="button" wire:click="nextStep" class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-brand-500/30">
                        Selanjutnya <i class="fa-solid fa-arrow-right ml-2"></i>
                    </button>
                    @else
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-bold py-3 px-10 rounded-xl transition-all shadow-lg shadow-brand-500/30 flex items-center gap-2 group">
                        <span wire:loading.remove wire:target="submit">Kirim Data</span>
                        <span wire:loading wire:target="submit">Mengirim...</span>
                        <i wire:loading.remove wire:target="submit" class="fa-solid fa-paper-plane group-hover:translate-x-1 transition-transform"></i>
                        <i wire:loading wire:target="submit" class="fa-solid fa-circle-notch fa-spin"></i>
                    </button>
                    @endif
                </div>

            </form>
        </div>
    </div>
    @endif
</div>
