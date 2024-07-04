<?php

namespace App\Http\Controllers;

use App\Http\Requests\SponsorFormRequest;
use App\Http\Requests\SponsorEditFormRequest;
use App\Models\Sponsor;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sponsors = Sponsor::all();

        // Check if the user is authenticated and is an admin
        if (auth()->check() && auth()->user()->isAdmin()) {
            // Admin view
            return view('sponsors.index')->with('sponsors', $sponsors);
        } else {
            // Non-admin or unauthenticated view: modify the `sponsored` property
            foreach ($sponsors as $sponsor) {
                $sponsor->sponsored = 'classified';
            }

            return view('sponsors.index')->with('sponsors', $sponsors);
        }
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize('create');
        return view('sponsors.create');
    }

    private function rankFilter($sponsor) {
        $number = $sponsor->sponsored;

        // Retrieve the current sponsor with rank 1
        $hoofdSponsor = Sponsor::where('rank', 1)->first();

        // If there's no sponsor with rank 1, this means we can proceed without demotion
        if ($hoofdSponsor === null) {
            $sponsor->rank = 1;
            $sponsor->save();
            return 1;
        }

        // If the sponsor has the highest 'sponsored' value
        if ($number > $hoofdSponsor->sponsored) {
            // Demote the current rank 1 sponsor to rank 2 if it's not the same sponsor
            if ($sponsor->id != $hoofdSponsor->id) {
                $hoofdSponsor->rank = 2;
                $hoofdSponsor->save();
            }

            // Promote the new sponsor to rank 1
            $sponsor->rank = 1;
            $sponsor->save();
            return 1;
        } else {
            // If the sponsor doesn't have the highest value, rank accordingly
            if ($number < 50) {
                return 4;
            } elseif ($number < 100) {
                return 3;
            } elseif ($number < $hoofdSponsor->sponsored) {
                return 2;
            } else {
                // Default case should not happen because it covers all possibilities
                return 1;
            }
        }
    }

    private function firstRankChecker() {
        // Retrieve the current sponsor with rank 1
        $hoofdSponsor = Sponsor::where('rank', 1)->first();

        // Retrieve the sponsor with the highest 'sponsored' value
        $highestSponsored = Sponsor::orderBy('sponsored', 'desc')->first();

        // Check if there is a sponsor with rank 1 and if the highest sponsored sponsor should be promoted
        if ($hoofdSponsor && $highestSponsored && $highestSponsored->sponsored > $hoofdSponsor->sponsored) {
            // Demote the current rank 1 sponsor to rank 2
            $hoofdSponsor->rank = 2;
            $hoofdSponsor->save();

            // Promote the sponsor with the highest sponsored value to rank 1
            $highestSponsored->rank = 1;
            $highestSponsored->save();
        } elseif ($highestSponsored && !$hoofdSponsor) {
            // If there is no sponsor currently with rank 1, promote the highest sponsored sponsor
            $highestSponsored->rank = 1;
            $highestSponsored->save();
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
        $sponsor->rank=self::rankFilter($sponsor);
        // Update validated data with the file path
        $sponsor['logo'] = '/storage/' . $path;

        $sponsor->save();
        self::firstRankChecker();


        return redirect()
            ->route('sponsors.show', [$sponsor])
            ->with('success', 'Sponsor is Aangemaakt! Title: ' . $sponsor->title);
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
        $oldPath = str_replace('/storage/', '', $sponsor->logo);

        // Handle file upload if a new file is provided
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = self::camelcaseTransformer($file->getClientOriginalName());
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
        $sponsor->rank = self::rankFilter($sponsor);

        // Save the sponsor
        $sponsor->save();
        self::firstRankChecker();

        // Redirect with success message
        return redirect()
            ->route('sponsors.show', [$sponsor])
            ->with('success', 'Sponsor is Aangepast!');
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
        ->with('success','Sponsor is Verwijderd!');
    }
}
