<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * Change Web Display Language.
     *
     * @param string $locale
     * @return \Illuminate\Http\Response
     */
    public function changeLocale($locale)
    {
        \Session::put('web_locale', $locale);

        return redirect()->back();
    }
}
