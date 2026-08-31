<div>
    @if($successMessage)
        <div class="bg-emerald-500 text-white p-6 rounded-2xl mb-4 text-center animate-fade-in-up shadow-lg">
            <div class="w-16 h-16 bg-white text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-check text-3xl font-bold"></i>
            </div>
            <h4 class="font-bold text-lg mb-1">Lamaran Terkirim!</h4>
            <p class="text-sm opacity-90">Terima kasih, lamaran dan CV Anda telah berhasil dikirimkan. Semoga beruntung!</p>
        </div>
    @else
        <!-- Trigger Modal Button -->
        <button type="button" x-data x-on:click="$dispatch('open-modal', 'applyModal')" class="w-full bg-white text-brand-600 hover:bg-brand-50 font-bold py-3.5 px-6 rounded-xl transition-all shadow-md group flex items-center justify-center">
            <i class="fa-solid fa-paper-plane mr-2 group-hover:animate-bounce"></i> Lamar Pekerjaan Ini
        </button>

        <!-- Alpine.js Modal -->
        <div x-data="{ open: false }" 
             x-show="open" 
             @open-modal.window="if ($event.detail === 'applyModal') open = true" 
             @close-modal.window="if ($event.detail === 'applyModal') open = false"
             style="display: none;" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
             
            <!-- Background Backdrop -->
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" 
                 @click="open = false" aria-hidden="true"></div>

            <!-- Modal Panel -->
            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div x-show="open" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all w-full max-w-xl my-8">
                    
                    <div class="bg-brand-600 px-6 py-4 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-white" id="modal-title">Formulir Lamaran</h3>
                        <button type="button" @click="open = false" class="text-brand-100 hover:text-white transition-colors">
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>

                    <form wire:submit.prevent="submit" class="p-6 text-slate-800 text-left space-y-5 h-full max-h-[70vh] overflow-y-auto">
                        
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Nama Lengkap *</label>
                            <input type="text" wire:model="nama_pelamar" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent transition-all" placeholder="Misal: Budi Santoso" required>
                            @error('nama_pelamar') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Tahun Lulus -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Tahun Lulus *</label>
                                <input type="number" wire:model="tahun_lulus" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" placeholder="Misal: {{ date('Y') }}" required>
                                @error('tahun_lulus') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <!-- No HP -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">No. HP (WhatsApp) *</label>
                                <input type="text" wire:model="no_hp" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" placeholder="081234567890" required>
                                @error('no_hp') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Alamat Email *</label>
                            <input type="email" wire:model="email" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" placeholder="email@contoh.com" required>
                            @error('email') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Pesan Pengantar -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Pesan Pengantar (Cover Letter)</label>
                            <textarea wire:model="pesan_pengantar" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all resize-none" placeholder="Perkenalkan diri Anda secara singkat dan sebutkan mengapa Anda cocok untuk posisi ini..."></textarea>
                            @error('pesan_pengantar') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Upload CV -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-1">Upload CV (PDF Maks. 2MB) *</label>
                            <input type="file" wire:model="file_cv" accept=".pdf" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 cursor-pointer">
                            <div wire:loading wire:target="file_cv" class="text-brand-600 text-xs font-bold mt-2">
                                <i class="fa-solid fa-spinner fa-spin mr-1"></i> Sedang mengunggah...
                            </div>
                            @error('file_cv') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                            <button type="button" @click="open = false" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-colors">Batal</button>
                            <button type="submit" class="px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition-all shadow-md flex items-center" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="submit"><i class="fa-solid fa-paper-plane mr-2"></i> Kirim Lamaran</span>
                                <span wire:loading wire:target="submit"><i class="fa-solid fa-spinner fa-spin mr-2"></i> Memproses...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
