<?php

namespace App\Http\Controllers;

use App\Http\Requests\SponsorFormRequest;
use App\Http\Requests\SponsorEditFormRequest;
use App\Models\Sponsor;
use App\Functions\CrudFunctions;
use App\Logging\SponsorLogger;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        // Check if the user is authenticated and is an admin
        if (auth()->check() && auth()->user()->isAdmin()) {
            // Admin view
            $sponsors = Sponsor::all();
            return view('sponsors.index')->with('sponsors', $sponsors);
        } else {
            // Non-admin or unauthenticated view: modify the `sponsored` property
            $sponsors = Sponsor::where('active', true)->get();
            foreach ($sponsors as $sponsor) {
                $sponsor->sponsored = 'classified';
            }

            return view('sponsors.index')->with('sponsors', $sponsors);
        }
    }

    public function changeState(Sponsor $sponsor){
        $this->authorize('changeState', $sponsor);

        if($sponsor->active){
            $sponsor->active=false;
            $state="deactivated";
            $flashMessage="Niet Actief";
        }else{
            $sponsor->active=true;
            $state="activated";
            $flashMessage="Actief";
        }

        $sponsor->save();

        SponsorLogger::changeState($sponsor,Auth::user(),$state,request()->getClientIp(true));
        CrudFunctions::firstRankChecker();

        return redirect()
        ->back()
        ->with('success', "Sponsor {$sponsor->title} is nu {$flashMessage}!");
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize('create');
        return view('sponsors.create');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(SponsorFormRequest $request)
    {
        $validated=$request->validated();

        $sponsor=new Sponsor();
        $sponsor->fill($validated);

        // Handle file upload
        $file = $request->file('logo');
        $fileName = CrudFunctions::camelcaseTransformer($file->getClientOriginalName());
        $path = $file->storeAs('images/sponsorLogos', $fileName, 'public');
        $sponsor->rank=CrudFunctions::rankFilter($sponsor);
        // Update validated data with the file path
        $sponsor['logo'] = '/storage/' . $path;
        $sponsor->active=true;
        $sponsor->save();
        CrudFunctions::firstRankChecker();

        SponsorLogger::create($sponsor,Auth::user(),request()->getClientIp());

        return redirect()
            ->route('sponsors.show', [$sponsor])
            ->with('success', 'Sponsor '.$sponsor->title.' is Aangepast!');
    }

    public function show(Sponsor $sponsor)
    {
        return view('sponsors.show',['sponsor'=>$sponsor]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sponsor $sponsor)
    {
        $this->authorize('update',$sponsor);
        return view('sponsors.edit',['sponsor'=>$sponsor]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SponsorEditFormRequest $request, Sponsor $sponsor)
    {
        // Authorize the update
        $this->authorize('update', $sponsor);
        $original=$sponsor->getOriginal();

        // Validate the request
        $validated = $request->validated();
        $oldPath = str_replace('/storage/', '', $sponsor->logo);

        // Handle file upload if a new file is provided
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = CrudFunctions::camelcaseTransformer($file->getClientOriginalName());
            $newPath = 'images/sponsorLogos/' . $fileName;

            // Delete the old file if the new file is different
            if ($oldPath !== $newPath) {
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            // Store the new file
            $path = $file->storeAs('images/sponsorLogos', $fileName, 'public');
            // Update the logo path in the validated data
            $validated['logo'] = '/storage/' . $path;
        } else {
            // Retain the old logo if no new file is uploaded
            $validated['logo'] = '/storage/'.$oldPath;
        }

        // Update the sponsor with the validated data
        $sponsor->update($validated);

        // Update the sponsor's rank
        $sponsor->rank = CrudFunctions::rankFilter($sponsor);

        // Save the sponsor
        $sponsor->save();
        CrudFunctions::firstRankChecker();

        // Get the updated attributes
        $changes = $sponsor->getChanges();

        // Prepare the differences for logging
        $differences = [];
        foreach ($changes as $attribute => $newValue) {
            $oldValue = $original[$attribute] ?? 'N/A';
            $differences[] = "{$attribute}: '{$oldValue}' => '{$newValue}'";
        }
        $differencesString = implode(", ", $differences);

        SponsorLogger::update($sponsor,$differencesString,Auth::user(),request()->getClientIp());

        // Redirect with success message
        return redirect()
            ->route('sponsors.show', [$sponsor])
            ->with('success', 'Sponsor '.$sponsor->title.' is Aangepast!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sponsor $sponsor)
    {
        $this->authorize('delete',$sponsor);

        $tempSponsor=$sponsor;

        $path = str_replace('/storage/', '', $sponsor->logo);
        // Check if the file exists and delete it
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $sponsor->delete();

        SponsorLogger::delete($sponsor,Auth::user(),request()->getClientIp());

        return redirect()
        ->route('sponsors.index')
        ->with('success','Sponsor '.$tempSponsor->title.' is Verwijderd!');
    }
}
