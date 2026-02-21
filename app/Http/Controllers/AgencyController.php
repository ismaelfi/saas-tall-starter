<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgencyController extends Controller
{
    /**
     * Show the agency landing page for the given locale.
     */
    public function index(Request $request, ?string $locale = null)
    {
        $locale = $locale ?? 'en';

        return view('agency.home', [
            'locale' => $locale,
        ]);
    }
}
