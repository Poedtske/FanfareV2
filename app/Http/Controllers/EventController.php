<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Requests\EventFormRequest;
use App\Functions\CrudFunctions;
use App\Logging\EventLogger;
use App\Services\CalendarService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


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
            $fileName = CrudFunctions::camelcaseTransformer($file->getClientOriginalName());
            $path = $file->storeAs('images/eventPosters', $fileName, 'public');
            // Update validated data with the file path
            $event['poster'] = '/storage/' . $path;
        }

        //$event->calendar_id=CalendarService::create($event);

        $event->save();

        EventLogger::create($event,Auth::user(),request()->getClientIp());
        return redirect()
                ->route('events.show',[$event])
                ->with('success', 'Evenement '.$event->title.' is Aangemaakt!');
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
       $original = $event->getOriginal();

       // Validate the request
       $validated = $request->validated();
       $oldPath = str_replace('/storage/', '', $event->poster);

       // Handle file upload if a new file is provided
       if ($request->hasFile('poster')&&$request->file('poster')->getClientOriginalName()) {
           $file = $request->file('poster');
           $fileName = CrudFunctions::camelcaseTransformer($file->getClientOriginalName());
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

       // Get the updated attributes
        $changes = $event->getChanges();

        // Prepare the differences for logging
        $differences = [];
        foreach ($changes as $attribute => $newValue) {
            $oldValue = $original[$attribute] ?? 'N/A';
            $differences[] = "{$attribute}: '{$oldValue}' => '{$newValue}'";
        }
        $differencesString = implode(", ", $differences);

        // if($event->calendar_id){
        //     CalendarService::update($event);
        //    }

       EventLogger::update($event,$differencesString,Auth::user(),request()->getClientIp());

       return redirect()
           ->route('events.show', [$event])
           ->with('success','Evenement '.$event->title.' is Aangepast!');
   }



   /**
    * Remove the specified resource from storage.
    */
   public function destroy(Event $event)
   {
       $this->authorize('delete',$event);

       $tempEvent=$event;

       if($event->poster){
            $path = str_replace('/storage/', '', $event->poster);
            // Check if the file exists and delete it
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
       }

       $event->delete();
    //    if(empty($tempEvent->calender_id)){
    //     CalendarService::delete($tempEvent);
    //    }

       EventLogger::delete($tempEvent,Auth::user(),request()->getClientIp());

       return redirect()
       ->route('kalender')
       ->with('success','Evenement '.$tempEvent->title.' is Verwijderd!');
   }
}
