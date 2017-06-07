<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Tag;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
   
     public function index()
    {
        $threads = Thread::orderBy('created_at', 'desc')->paginate(10);
         // dd($threads);
        return view('thread.index')
                       ->with('tags', Tag::all())
                        ->with('threads', $threads);
    }

    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        // dd($tag->posts()->paginate(5))->with('tags', Tag::all());
        return view('forum')
                    ->with('posts', $tag->Posts()->paginate(5))
                    ->with('tags', Tag::all());
    }
}
