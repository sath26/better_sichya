<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Validator;
use Redirect;
use Session;
use Purifier;
use Illuminate\Support\Facades\Input;
class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         //upload

         /*$post = Post::find($id);
        $best_answer = $post->replies()->where('best_answer', 1)->first();

        return view('posts.show')
                            ->with('d',$post)
                            ->with('tags', Tag::all())
                            ->with('best_answer',$best_answer);
                            */
        $directory = config('app.fileDestinationPath');
        $files = File::files($directory);
        return view('notes.index')->with(array('files' => $files ));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $tags = Tag::all();
        return view('notes.upload');
    // ->withTags($tags)
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    // getting all of the post data
        $files = Input::file('images');
    // Making counting of uploaded images
        $file_count = count($files);
    // start count how many uploaded
        $uploadcount = 0;
        foreach($files as $file) {
            $rules = array('file' => 'required|mimes:png,gif,jpeg,txt,pdf,doc'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
            $validator = Validator::make(array('file'=> $file), $rules);
            if($validator->passes()){
                $destinationPath = 'storage/uploads';
                $filename = $file->getClientOriginalName();
                $upload_success = $file->move($destinationPath, $filename);
                $uploadcount ++;
            }
        }
        if($uploadcount == $file_count){
          Session::flash('message', 'Upload successfully'); 
          $directory = config('app.fileDestinationPath');
          $files = File::files($directory);
          return view('notes.index')->with(array('files' => $files ));
              // return redirect()->to('/note');
        } 
        else {
          $files = File::files($directory);
          dd($directory, $files);
          return view('notes.upload')->with(array('files' => $files ))->withErrors($validator);
        }
}


   /* public function upload(){
        $directory = config('app.fileDestinationPath');
        $files = Storage::files($directory);
        return view('notes.upload')->with(array('files' => $files ));
    }*/
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $directory = config('app.fileDestinationPath');
        $files = File::files($directory);
          dd($directory, $files);
          return view('notes.upload')->with(array('files' => $files ));

        /*   $post = Post::find($id);
        $best_answer = $post->replies()->where('best_answer', 1)->first();

        return view('posts.show')
                            ->with('d',$post)
                            ->with('tags', Tag::all())
                            ->with('best_answer',$best_answer);*/
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $post = Post::find($id);


        $tags = Tag::all();
        $tags2 = array();
        foreach ($tags as $tag) {
            $tags2[$tag->id] = $tag->name;
        }
        // return the view and pass in the var we previously created
        return view('posts.edit')->withPost($post)->withTags($tags2);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $post = Note::find($id);
        
        if ($request->input('slug') == $post->slug) {
            $this->validate($request, array(
                'title' => 'required|max:255',

                'body'  => 'required'
                ));
        } else {
            $this->validate($request, array(
                'title' => 'required|max:255',
                'slug'  => 'required|alpha_dash|min:5|max:255|unique:posts,slug',

                'body'  => 'required'
                ));
        }

        // Save the data to the database
        $post = Post::find($id);

        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->body = Purifier::clean($request->body,'youtube');
        $post->save();   

        if (isset($request->tags)) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->sync(array());
        }


        // set flash data with success message
        Session::flash('success', 'This post was successfully saved.');

        // redirect with flash data to posts.show
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Note::find($id);

        $post->delete();

        Session::flash('success', 'The post was successfully deleted.');
        return redirect()->route('posts.index');
    }
}
