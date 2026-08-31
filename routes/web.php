<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Models\SiteSetting;
use App\Models\NavigationMenu;
use App\Models\HeroSlide;
use App\Models\HomeFeature;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\TracerStudyController;
use App\Http\Controllers\BkkController;
use App\Http\Controllers\JobApplicationController;

Route::get('/jurusan/{slug}', [JurusanController::class, 'show']);


Route::get('/kontak', [ContactController::class, 'index']);
Route::post('/kontak', [ContactController::class, 'store']);


Route::get('/dokumen', [DocumentController::class, 'index']);


Route::get('/guru', [TeacherController::class, 'index']);
Route::get('/galeri', [\App\Http\Controllers\GalleryController::class, 'index']);

// BKK Routes
Route::get('/bkk', [BkkController::class, 'index']);
Route::get('/bkk/{id}', [BkkController::class, 'show'])->name('bkk.show');
Route::get('/bkk/{id}/apply', [JobApplicationController::class, 'create'])->name('bkk.apply');
Route::post('/bkk/{id}/apply', [JobApplicationController::class, 'store'])->name('bkk.store_application');

Route::get('/tracer-study', [\App\Http\Controllers\TracerStudyController::class, 'index']);
Route::get('/tracer-study/isi', [\App\Http\Controllers\TracerStudyController::class, 'create']);


Route::get('/halaman/{slug}', [PageController::class, 'show']);


Route::get('/berita', [PostController::class, 'index']);
Route::get('/berita/{slug}', [PostController::class, 'show']);




use App\Models\Post;
use App\Models\HomeProgram;
use App\Models\StudentChart;
use App\Models\Jurusan;
use App\Models\Mitra;

Route::get('/', function () {
    $heroSlides = HeroSlide::where('aktif', 'ya')->orderBy('urutan')->get();
    $homeFeatures = HomeFeature::orderBy('urutan')->get();
    $homePrograms = HomeProgram::orderBy('urutan')->get();
    $studentCharts = StudentChart::orderBy('urutan')->get();
    $latestPosts = Post::where('status', 'published')->orderBy('tanggal_posting', 'desc')->take(3)->get();
    $jurusans = Jurusan::where('aktif', 1)->orderBy('urutan')->get();
    $mitras = Mitra::where('aktif', 1)->orderBy('urutan')->get();
    
    return view('welcome', compact('heroSlides', 'homeFeatures', 'homePrograms', 'studentCharts', 'latestPosts', 'jurusans', 'mitras'));
});

Route::get('/sitemap.xml', function () {
    $posts = \App\Models\Post::where('status', 'published')->get();
    $pages = \App\Models\Page::where('status', 'published')->get();
    $jurusans = \App\Models\Jurusan::where('aktif', 1)->get();
    
    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    
    $xml .= '<url><loc>' . url('/') . '</loc><changefreq>daily</changefreq><priority>1.0</priority></url>';
    $xml .= '<url><loc>' . url('/berita') . '</loc><changefreq>daily</changefreq><priority>0.9</priority></url>';
    $xml .= '<url><loc>' . url('/guru') . '</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>';
    $xml .= '<url><loc>' . url('/dokumen') . '</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>';
    $xml .= '<url><loc>' . url('/kontak') . '</loc><changefreq>monthly</changefreq><priority>0.5</priority></url>';
    
    foreach ($posts as $post) {
        $xml .= '<url><loc>' . url('/berita/' . $post->slug) . '</loc><lastmod>' . $post->updated_at->tz('UTC')->toAtomString() . '</lastmod><changefreq>weekly</changefreq><priority>0.7</priority></url>';
    }
    
    foreach ($pages as $page) {
        $xml .= '<url><loc>' . url('/halaman/' . $page->slug) . '</loc><lastmod>' . $page->updated_at->tz('UTC')->toAtomString() . '</lastmod><changefreq>monthly</changefreq><priority>0.6</priority></url>';
    }
    
    foreach ($jurusans as $jur) {
        $xml .= '<url><loc>' . url('/jurusan/' . $jur->slug) . '</loc><lastmod>' . $jur->updated_at->tz('UTC')->toAtomString() . '</lastmod><changefreq>monthly</changefreq><priority>0.8</priority></url>';
    }
    
    $xml .= '</urlset>';
    
    return response($xml, 200)->header('Content-Type', 'text/xml');
});

Route::get('/test-php-ini', function () { return ini_get('upload_max_filesize') . ' | ' . ini_get('post_max_size'); });

Route::get('/test-upload', function () {
    return '<form method="POST" enctype="multipart/form-data" action="/test-upload">
        '.csrf_field().'
        <input type="file" name="file">
        <button type="submit">Upload Test</button>
    </form>';
});
Route::post('/test-upload', function (Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Log::info('Test Upload:', ['php_limit' => ini_get('upload_max_filesize'), 'content_length' => $_SERVER['CONTENT_LENGTH'] ?? 0, 'files' => $_FILES]);
    return response()->json([
        'php_limit' => ini_get('upload_max_filesize'),
        'content_length' => $_SERVER['CONTENT_LENGTH'] ?? 0,
        'files_array' => $_FILES
    ]);
});

use Illuminate\Http\Request;

Route::post('/tinymce/upload', function (Request $request) {
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('assets/images/tinymce'), $filename);
        return response()->json(['location' => asset('assets/images/tinymce/' . $filename)]);
    }
    return response()->json(['error' => 'No file uploaded'], 400);
})->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])->name('tinymce.upload');
