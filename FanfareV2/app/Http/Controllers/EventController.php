<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Requests\EventFormRequest;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize('create');
        return view('events.create');
    }

    private function camelcaseTransformer($name){
        // Remove special characters, replace spaces with underscores, and convert to lowercase
        $name=explode('.',$name);
        $extension=$name[1];
        $name = strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $name[0]));

        // Split the string by underscores or spaces
        $words = preg_split('/[_\s]/', $name, -1, PREG_SPLIT_NO_EMPTY);

        // Capitalize the first letter of each word except the first one
        $camelCaseName = '';
        foreach ($words as $key => $word) {
            if ($key === 0) {
                // Keep the first word lowercase
                $camelCaseName .= $word;
            } else {
                // Capitalize subsequent words
                $camelCaseName .= ucfirst($word);
            }
        }

        return $camelCaseName.'.'.$extension;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventFormRequest $request)
    {
        $validated=$request->validated();

        $event=new Event();
        $event->fill($validated);
        // Handle file upload
        if($event->poster){
            $file = $request->file('poster');
            $fileName = self::camelcaseTransformer($file->getClientOriginalName());
            $path = $file->storeAs('images/eventPosters', $fileName, 'public');
            // Update validated data with the file path
            $event['poster'] = '/storage/' . $path;
        }

        $event->save();

        return redirect()
                ->route('events.show',[$event])
                ->with('success', 'Evenement is Aangemaakt! Titel: '.
                $event->title);
    }

   /**
    * Display the specified resource.
    */
   public function show(Event $event)
   {
       return view('events.show',['event'=>$event]);
   }

   /**
    * Show the form for editing the specified resource.
    */
   public function edit(Event $event)
   {
       $this->authorize('update',$event);
       return view('events.edit',['event'=>$event]);
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(EventFormRequest $request, Event $event)
   {

       $this->authorize('update',$event);


       // Validate the request
       $validated = $request->validated();
       $oldPath = str_replace('/storage/', '', $event->poster);

       // Handle file upload if a new file is provided
       if ($request->hasFile('poster')&&$request->file('poster')->getClientOriginalName()) {
           $file = $request->file('poster');
           $fileName = self::camelcaseTransformer($file->getClientOriginalName());
           $newPath = 'images/eventPosters/' . $fileName;

           // Delete the old file if the new file is different
           if ($oldPath !== $newPath) {
               if (Storage::disk('public')->exists($oldPath)) {
                   Storage::disk('public')->delete($oldPath);
               }
           }

           // Store the new file
           $path = $file->storeAs('images/eventPosters', $fileName, 'public');
           // Update the poster path in the validated data
           $validated['poster'] = '/storage/' . $path;
       } else {
           // Retain the old poster if no new file is uploaded
           try {
            if($validated['poster']==null){
                $validated['poster'] = '/storage/'.$oldPath;
               }
           } catch (\Throwable $th) {
            //throw $th;
           }

       }

       $event->update($validated);



       return redirect()
           ->route('events.show',[$event])//id gets extraced from $event and used
           ->with('success','Evenement is Aangepast!');
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(Event $event)
   {
       $this->authorize('delete',$event);
       if($event->poster){
            $path = str_replace('/storage/', '', $event->poster);
            // Check if the file exists and delete it
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
       }

       $event->delete();

       return redirect()
       ->route('kalender')
       ->with('success','Evenement is Verwijderd!');
   }
}
