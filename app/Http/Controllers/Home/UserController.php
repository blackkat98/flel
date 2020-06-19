<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Home\HomeController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helper\MediaDeletion;

class UserController extends HomeController
{
    /**
     * Show Profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function showProfile()
    {
        return view('home.profile');
    }

    /**
     * Update Profile.
     *
     * @param App\Http\Request\UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(UserRequest $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');

        if ($request->hasFile('image')) {
            $path = Storage::disk('public')->put(config('customize.image_dir'), $request->file('image'));

            if ($user->image != config('customize.default_avatar')) {
                MediaDeletion::delete($user->image);
            }

            $user->image = config('customize.storage_dir') . $path;
        }

        if ($user->save()) {
            return redirect()->back()->with('success', __('Profile') . ' ' . __('has been updated'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }

    /**
     * Update Profile.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $pass = $request->get('password');
        $c_pass = $request->get('c_password');

        if (strlen($pass) < 6) {
            return redirect()->back()->with('error', __('Password') . ' ' . __('must have a size of at least') . ' 6');
        }

        if ($pass !== $c_pass) {
            return redirect()->back()->with('error', __('Confirmation Mismatch'));
        }

        $user->password = Hash::make($pass);

        if ($user->save()) {
            return redirect()->back()->with('success', __('Password') . ' ' . __('has been updated'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }
}
