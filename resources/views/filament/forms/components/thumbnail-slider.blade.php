<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{
        swiper: null,
        fotos: @entangle('data.foto'),
        thumbnail: @entangle($getStatePath()),
        
        initSwiper() {
            if (this.swiper) this.swiper.destroy();
            this.swiper = new Swiper(this.$refs.swiperContainer, {
                slidesPerView: 1,
                spaceBetween: 10,
                navigation: {
                    nextEl: this.$refs.next,
                    prevEl: this.$refs.prev,
                },
            });
        },
        
        getImageUrl(file) {
            if (file && typeof file === 'string') {
                return file.startsWith('assets') ? '/' + file : '/assets/images/berita/' + file;
            }
            return '';
        }
    }" x-init="
        $watch('fotos', () => {
            $nextTick(() => { initSwiper(); });
        });
        setTimeout(() => { initSwiper(); }, 500);
    ">
        <template x-if="fotos && Object.keys(fotos).length > 0">
            <div class="relative w-full overflow-hidden rounded-xl border border-gray-200 dark:border-white/10 mt-2 shadow-sm">
                <div x-ref="swiperContainer" class="swiper w-full bg-gray-50 dark:bg-gray-900">
                    <div class="swiper-wrapper">
                        <template x-for="(foto, key) in fotos" :key="key">
                            <div class="swiper-slide relative flex flex-col items-center justify-center p-0">
                                <!-- Image Container -->
                                <div class="relative w-full h-64 bg-cover bg-center" 
                                     :style="'background-image: url('' + getImageUrl(foto) + '')'">
                                    
                                    <!-- Overlay for Button -->
                                    <div class="absolute inset-0 bg-black/20 flex flex-col items-center justify-end pb-6 opacity-0 hover:opacity-100 transition-opacity duration-300"
                                         :class="thumbnail === foto ? 'opacity-100 bg-black/40' : ''">
                                         
                                        <button type="button" 
                                            @click="thumbnail = foto" 
                                            :class="thumbnail === foto ? 'bg-primary-500 text-white shadow-lg' : 'bg-white/90 text-gray-800 hover:bg-white shadow'"
                                            class="px-6 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 transform hover:scale-105 flex items-center gap-2">
                                            <svg x-show="thumbnail === foto" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                            <span x-text="thumbnail === foto ? 'Thumbnail Aktif' : 'Jadikan Thumbnail'"></span>
                                        </button>
                                        
                                    </div>
                                    
                                    <!-- Active Badge (Top Right) -->
                                    <div x-show="thumbnail === foto" class="absolute top-3 right-3 bg-primary-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        Utama
                                    </div>
                                    
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                
                <!-- Navigation -->
                <button x-ref="prev" type="button" class="absolute left-2 top-1/2 -translate-y-1/2 z-10 p-1.5 bg-white/80 dark:bg-gray-800/80 rounded-full shadow hover:bg-white dark:hover:bg-gray-700 transition">
                    <svg class="w-5 h-5 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button x-ref="next" type="button" class="absolute right-2 top-1/2 -translate-y-1/2 z-10 p-1.5 bg-white/80 dark:bg-gray-800/80 rounded-full shadow hover:bg-white dark:hover:bg-gray-700 transition">
                    <svg class="w-5 h-5 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </template>
        
        <template x-if="!fotos || Object.keys(fotos).length === 0">
            <div class="text-sm text-gray-500 italic p-6 text-center border border-dashed border-gray-300 dark:border-gray-700 rounded-xl mt-2 bg-gray-50 dark:bg-gray-800/50">
                Gambar preview akan muncul setelah Anda memilih foto di atas.
            </div>
        </template>
    </div>
</x-dynamic-component>
