<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Requests\EventFormRequest;

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
        $event->save();


        return redirect()
                ->route('events.show',[$event])
                ->with('success', 'Event is submitted! Title: '.
                $event->title.' Description: '.
                $event->description);
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

       $validated=$request->validated();
       $event->update($validated);



       return redirect()
           ->route('events.show',[$event])//id gets extraced from $event and used
           ->with('success','Event is Updated!');
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(Event $event)
   {
       $this->authorize('delete',$event);
       $event->delete();

       return redirect()
       ->route('home2')
       ->with('success','Event has been deleted!');
   }
}
