<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TutorContactRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Models\TutorContact;
use App\Models\Language;
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

        return view('admin.tutor_contacts.list', [
            'contacts' => $contacts,
            'languages' => $languages
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
        $contact->name = $request->get('name');
        $contact->email = $request->get('email');
        $contact->phone = $request->get('phone');
        $contact->language_id = $request->get('language_id');
        $contact->location = $request->get('location');
        $contact->extra = $request->get('extra');

        if ($request->hasFile('image')) {
            $path = Storage::disk('public')->put(config('customize.image_dir'), $request->file('image'));
            $contact->image = config('customize.storage_dir') . $path;
        } else {
            $contact->image = config('customize.default_avatar');
        }

        if ($contact->save()) {
            return redirect()->back()->with('success', $contact->name . ' ' . __('has been created'));
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
        $contact->name = $request->get('name');
        $contact->email = $request->get('email');
        $contact->phone = $request->get('phone');
        $contact->language_id = $request->get('language_id');
        $contact->location = $request->get('location');
        $contact->extra = $request->get('extra');

        if ($request->hasFile('image')) {
            $path = Storage::disk('public')->put(config('customize.image_dir'), $request->file('image'));
            $contact->image = config('customize.storage_dir') . $path;
        }

        if ($contact->save()) {
            return redirect()->back()->with('success', $contact->name . ' ' . __('has been updated'));
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
