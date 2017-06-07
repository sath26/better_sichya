<?php

namespace App\Http\Controllers;
use Auth;
use App\Thread;
use Purifier;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ThreadController extends Controller
{
    function __construct()
    {
        return $this->middleware('auth')->except('index');
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $threads = Thread::orderBy('created_at', 'desc')->paginate(10);
        // $threads = Thread::paginate(15);
        return view('thread.index')
                            ->with('tags', Tag::all())
                            ->with('threads', $threads);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        return view('thread.create')->withTags($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate

       /* $this->validate($request, [
            'subject' => 'required|min:5',
            
            'thread'  => 'required|min:10',
            // 'g-recaptcha-response' => 'required|captcha'
        ]);*/
         $this->validate($request, array(
            'title'         => 'required|max:255',
            
            'body'          => 'required',
            ));

        // store in the database
        $thread = new Thread;

        $thread->title = $request->title;
        $thread->slug = str_slug($request->title);
        $thread->user_id = Auth::id();
        $thread->body = Purifier::clean($request->body);
       $thread->save();
        
        $thread->tags()->sync($request->tags, false);
           
        //store
        //auth()->user()->threads()->create($request->all());

        //redirect
        return back()->withMessage('Thread Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        //return view('thread.single', compact('thread'));
          $thread = Thread::find($id);
        //$best_answer = $thread->replies()->where('best_answer', 1)->first();
        dd($thread);

        return view('thread.single')
                            ->with('thread',$thread)
                            ->with('tags', Tag::all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        return view('thread.edit', compact('thread'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
//        if(auth()->user()->id !== $thread->user_id){
//            abort(401,"unauthorized");
//        }
//
        $this->authorize('update',$thread);
        //validate
        $this->validate($request, [
            'subject' => 'required|min:10',
            'type'    => 'required',
            'thread'  => 'required|min:20'
        ]);


        $thread->update($request->all());

        return redirect()->route('thread.show', $thread->id)->withMessage('Thread Updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
//        if(auth()->user()->id !== $thread->user_id){
//            abort(401,"unauthorized");
//        }
        $this->authorize('update',$thread);

        $thread->delete();

        return redirect()->route('thread.index')->withMessage("Thread Deleted!");
    }

    public function markAsSolution()
    {
        $solutionId=Input::get('solutionId');
        $threadId=Input::get('threadId');

       $thread=Thread::find($threadId);
       $thread->solution=$solutionId;
       if($thread->save()){
           if(request()->ajax()){
               return response()->json(['status'=>'success','message'=>'marked as solution']);
           }
           return back()->withMessage('Marked as solution');
       }


    }
}
