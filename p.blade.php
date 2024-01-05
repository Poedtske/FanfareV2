@php
    $validated=$request->validated();


$post=$request->user()->posts()->create($validated);

$postCoverUploaded= $request->file('cover');
$postCoverName=$post->id.'.'.$request->cover->extension();
$postCoverPath=public_path(('\\images\\covers\\'));


$post->cover='/images/covers/'.$postCoverName;
$post->save();
$postCoverUploaded->move($postCoverPath,$postCoverName);
@endphp