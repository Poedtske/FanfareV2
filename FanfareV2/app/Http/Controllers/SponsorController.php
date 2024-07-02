<?php

namespace App\Http\Controllers;

use App\Http\Requests\SponsorFormRequest;
use App\Http\Requests\SponsorEditFormRequest;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sponsors=Sponsor::all();
        return view('sponsors.index')->with('sponsors',$sponsors);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize('create');
        return view('sponsors.create');
    }

    private function rankFilter($number){
        $hoofdSponsor = Sponsor::orderBy('sponsored', 'desc')->first();
        if($number<50)
            return 4;
        elseif($number<100)
            return 3;
        elseif($number<$hoofdSponsor->sponsored)
            return 2;
        else{
            $hoofdSponsor->rank = 2;
            $hoofdSponsor->save();
            return 1;
        }
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
    public function store(SponsorFormRequest $request)
    {
        $validated = $request->validated();

        $sponsor=$request->user()->sponsors()->create($validated);

        // Handle file upload
        $file = $request->file('logo');
        $fileName = self::camelcaseTransformer($file->getClientOriginalName());
        $path = $file->storeAs('images/sponsorLogos', $fileName, 'public');
        $sponsor->rank=self::rankFilter($sponsor->sponsored);
        // Update validated data with the file path
        $sponsor['logo'] = '/storage/' . $path;

        $sponsor->save();



        return redirect()
            ->route('sponsors.show', [$sponsor])
            ->with('success', 'Sponsor is submitted! Title: ' . $sponsor->title);
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

        // Validate the request
        $validated = $request->validated();
        $oldpath = str_replace('/storage/', '', $sponsor->logo);

        // Handle file upload if a new file is provided
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = self::camelcaseTransformer($file->getClientOriginalName());
            $newPath = 'images/sponsorLogos/' . $fileName;

            // Delete the old file if the new file is different
            if ($oldpath !== $newPath) {
                if (Storage::exists($oldpath)) {
                    Storage::delete($oldpath);
                }
            }

            // Store the new file
            $path = $file->storeAs('images/sponsorLogos', $fileName, 'public');
            // Update the logo path in the validated data
            $validated['logo'] = '/storage/' . $path;
        } else {
            // Retain the old logo if no new file is uploaded
            $validated['logo'] = '/storage/'.$oldpath;
        }

        // Update the sponsor with the validated data
        $sponsor->update($validated);

        // Update the sponsor's rank
        $sponsor->rank = self::rankFilter($sponsor->sponsored);

        // Save the sponsor
        $sponsor->save();

        // Redirect with success message
        return redirect()
            ->route('sponsors.show', [$sponsor])
            ->with('success', 'Sponsor is updated!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sponsor $sponsor)
    {
        $this->authorize('delete',$sponsor);
        $path = str_replace('/storage/', '', $sponsor->logo);
        // Check if the file exists and delete it
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $sponsor->delete();

        return redirect()
        ->route('sponsors.index')
        ->with('success','Sponsor has been deleted!');
    }
}
