<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Validator;
use Redirect;
use Session;
use Auth;
use Purifier;
use App\Tag;
use App\Note;
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

        $notes = Note::orderBy('created_at', 'desc')->paginate(10);
        return view('notes.index')
        ->with('notes', $notes)
        ->with('tags', Tag::all());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $tags = Tag::all();
        return view('notes.upload')
        ->with('tags', Tag::all());
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
        if($request->hasFile('images')){
            $files = Input::file('images');
            $file_count = count($files);
            $uploadcount = 0;
            foreach($files as $file) {
                $rules = array('file' => 'required|mimes:png,jpeg,txt,pdf,docx');
                $validator = Validator::make(array('file'=> $file), $rules);//$file has all the meta data of the file
                if($validator->passes()){
                    $filename = $file->getClientOriginalName();
                    $size = $file->getsize();
                    $mimeType = $file->getmimeType();
                    Storage::disk('local')->put('public/uploads/'.$filename, 'Contents');
                    Note::create([
                        'file_name' =>$filename,
                        'title' =>$request->title,
                        'description' =>$request->description,
                        'file_size' =>$size,
                        'mimes_type' =>$mimeType,
                        'user_id' => Auth::id()
                        ]);
                    $uploadcount ++;
                }
            }
            if($uploadcount == $file_count){
              Session::flash('message', 'Upload successfully');
              $notes = Note::all();
              $tags = Tag::all();
              return view('notes.index')
              ->with('notes', $notes)
              ->with('tags', Tag::all());
                    // return redirect()->to('/note');
          } 
          else{
              dd($directory, $uploadedFiles);
              return view('notes.upload')->with('files', $files)->withErrors($validator);
          } 
      }
      else{
        return 'No files selected';
    }
}



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
        // $url = Storage::url('uploads/haha.PNG');
        // return "<img src='".$url."'/>";
    public function show($id)
    {
        // dd($id);
       $note = Note::find($id);
        $tags = Tag::all();
        // dd($note);
       return view('notes.show')
                    ->with('notes',$note )
                    ->with('tags',$tags);
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
