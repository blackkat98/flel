<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TutorContactRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\TutorContact;
use App\Models\Language;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class TutorContactController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $contacts = TutorContact::all();
        $languages = Language::all();
        $users = User::all();

        return view('admin.tutor_contacts.list', [
            'contacts' => $contacts,
            'languages' => $languages,
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\TutorContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TutorContactRequest $request)
    {
        $contact = new TutorContact();
        $contact->real_name = $request->get('real_name');
        $contact->user_id = $request->get('user_id');
        $contact->language_id = $request->get('language_id');
        $contact->phone = $request->get('phone');
        $contact->experiences = $request->get('experiences');
        $contact->location = $request->get('location');

        $facebook = $request->get('socnet_fb');
        $twitter = $request->get('socnet_tw');
        $google_plus = $request->get('socnet_gp');

        $social_networks = [];
        $social_networks['facebook'] = $facebook;
        $social_networks['twitter'] = $twitter;
        $social_networks['google_plus'] = $google_plus;

        $contact->social_networks = $social_networks;

        if ($contact->save()) {
            return redirect()->back()->with('success', $contact->real_name . ' ' . __('has been created'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\TutorContactRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TutorContactRequest $request, $id)
    {
        $contact = TutorContact::findOrFail($id);
        $contact->real_name = $request->get('real_name');
        $contact->user_id = $request->get('user_id');
        $contact->language_id = $request->get('language_id');
        $contact->phone = $request->get('phone');
        $contact->experiences = $request->get('experiences');
        $contact->location = $request->get('location');

        $facebook = $request->get('socnet_fb');
        $twitter = $request->get('socnet_tw');
        $google_plus = $request->get('socnet_gp');

        $social_networks = [];
        $social_networks['facebook'] = $facebook;
        $social_networks['twitter'] = $twitter;
        $social_networks['google_plus'] = $google_plus;

        $contact->social_networks = $social_networks;

        if ($contact->save()) {
            return redirect()->back()->with('success', $contact->real_name . ' ' . __('has been updated'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = TutorContact::findOrFail($id);

        if ($contact->delete()) {
            return redirect()->back()->with('success', $contact->name . ' ' . __('has been deleted'));
        } else {
            return redirect()->back()->with('error', __('Action Failed'));
        }
    }
}
