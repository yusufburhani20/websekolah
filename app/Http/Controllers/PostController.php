<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\SiteSetting;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::where('status', 'published');
        
        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->has('q')) {
            $query->where('judul', 'like', '%' . $request->q . '%');
        }
        
        $posts = $query->orderBy('tanggal_posting', 'desc')->paginate(9);
        $kategori_list = Post::where('status', 'published')->select('kategori')->distinct()->pluck('kategori');
        $popular_posts = Post::where('status', 'published')->orderBy('views', 'desc')->take(5)->get();
        
        return view('posts.index', compact('posts', 'kategori_list', 'popular_posts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->where('status', 'published')->firstOrFail();
        
        // Update views
        $post->increment('views');
        
        $popular_posts = Post::where('status', 'published')->where('id', '!=', $post->id)->orderBy('views', 'desc')->take(5)->get();
        $related_posts = Post::where('status', 'published')->where('kategori', $post->kategori)->where('id', '!=', $post->id)->orderBy('tanggal_posting', 'desc')->take(3)->get();
        
        return view('posts.show', compact('post', 'popular_posts', 'related_posts'));
    }
}
