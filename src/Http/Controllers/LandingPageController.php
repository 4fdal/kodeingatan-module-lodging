<?php

namespace Kodeingatan\Lodging\Http\Controllers;

class LandingPageController extends Controller
{
    public function index()
    {
        return view('lodging::pages.welcome');
    }
}
