<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Functions\UserFunctions;
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

    public function promote(Request $request){
        $newAdmin=User::find($request->input('id'));
        $newAdmin->role='admin';

        $newAdmin->save();

        $ip =  request()->getClientIp(true);
        UserFunctions::log("User {$newAdmin->email} has been promoted to admin: \nUser who did action: \nip: {$ip} \nusername: ".Auth::user()->name." \nid: ".Auth::user()->id."\nObjectInfo:", $newAdmin);

        return Redirect::route('profile.show',$newAdmin->id)->with('status', 'profile-updated');
    }

    public function demote(Request $request){
        $demotedAdmin=User::find($request->input('id'));
        $demotedAdmin->role='user';

        $demotedAdmin->save();

        $ip =  request()->getClientIp(true);
        UserFunctions::log("User {$demotedAdmin->email} has been demoted to user: \nUser who did action: \nip: {$ip} \nusername ".Auth::user()->name." \nid: ".Auth::user()->id."\nObjectInfo:", $demotedAdmin);

        return Redirect::route('profile.show',$demotedAdmin->id)->with('status', 'profile-updated');
    }

    public function showProfile(int $id)
    {

        $user=User::findOrFail($id);
        return view('profile.show',['user'=>$user]);
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

        //doesn't work because VSC doesn't see the url method, no idea how to fix it.
        // Storage::disk('avatars')->url($request->user()->avatar);


        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
        $ip =  request()->getClientIp(true);
        UserFunctions::log("User {$request->user()->email} has been updated: \nUser who did action: \nip: {$ip} \nusername: ".Auth::user()->name." \nid: ".Auth::user()->id."\nObjectInfo:", $request->user());

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
        $actionUser=Auth::user();

        Auth::logout();

        $user->delete();

        $ip =  request()->getClientIp(true);
        UserFunctions::log("User {$user->email} has been deleted: \nUser who did action: \nip: {$ip} \nusername: {$actionUser->name} \nid: {$actionUser->id}", $user);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
