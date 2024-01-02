<?php

namespace App\Http\Controllers;
use App\Models\Post;

use Illuminate\Http\Request;

class PostController extends Controller
{
     /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'description'=>['required','min:10'],
        ]);

        $post=new Post();
        $post->title=$request->input('title');
        $post->description=$request->input('description');

        $post->save();

        return redirect()
                ->route('posts.show',[$post])
                ->with('success', 'Post is submitted! Title: '.
                $post->title.' Description: '.
                $post->description);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {

        return view('posts.show',['post'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit',['post'=>$post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'=>'required',
            'description'=>['required','min:10'],
        ]);
        //$post=Post::findOrFail($id); is called by post itself

        $post->title=$request->input('title');
        $post->description=$request->input('description');

        $post->save();

        return redirect()
        //  ->route('posts.show',['post'=>$post->id]) done by laravel (route model binding)
            ->route('posts.show',[$post])//id gets extraced from $post and used
            ->with('success','Post is Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()
        ->route('home2')
        ->with('success','Post has been deleted!');
    }
}
