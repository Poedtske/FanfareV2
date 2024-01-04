<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if($request->has('avatar')){
            $avataruploaded= $request->file('avatar');
            $avatarname=$request->user()->id.'.'.$avataruploaded->getClientOriginalExtension();
            $avatarpath=public_path(('\\images\\avatars\\'));
            if($avatarpath.$avatarname!=null){
                File::delete($avatarpath.$avatarname);
            }

            $request->user()->avatar='/images/avatars/'.$avatarname;
            $avataruploaded->move($avatarpath,$avatarname);
        }

        //$path = $request->file('avatar')->store('avatars');
        // Storage::disk('avatars')->url($request->user()->avatar);
        //$request->user()->avatar=$path;

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
