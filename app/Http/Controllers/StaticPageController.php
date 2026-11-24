<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class StaticPageController extends Controller
{
    public function clearAll()
    {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');

        return "All cache cleared!";
    }

    public function fallback()
    {
        return view('errors.404');
    }

    public function meetoel()
    {
        return view('frontend.global.meetoel');
    }

    public function psychometricstest()
    {
        return view('frontend.global.psychometricstest');
    }

    public function countryprogram()
    {
        return view('frontend.global.countryprogram');
    }

    public function admissionguidance()
    {
        return view('frontend.global.admissionguidance');
    }

    public function testprepration()
    {
        return view('frontend.global.testprepration');
    }

    public function pretestprepration()
    {
        return view('frontend.global.pretestprepration');
    }

    public function resumeevaluation()
    {
        return view('frontend.global.resumeevaluation');
    }

    public function universityapplicationassistance()
    {
        return view('frontend.global.universityapplicationassistance');
    }

    public function financialcounselling()
    {
        return view('frontend.global.financialcounselling');
    }

    public function visainterview()
    {
        return view('frontend.global.visainterview');
    }

    public function foreignexchange()
    {
        return view('frontend.global.foreignexchange');
    }

    public function predeparturebriefing()
    {
        return view('frontend.global.predeparturebriefing');
    }

    public function bonvoyage()
    {
        $data['bonvoyage'] = "bonvoyage";
        return view('frontend.global.bonvoyage', $data);
    }

    public function travelmedical()
    {
        return view('frontend.global.travelmedical');
    }

    public function accommodation()
    {
        return view('frontend.global.acommodation');
    }

    public function koreanClasses()
    {
        return view('landingpage.korean-classes');
    }

    public function ieltsCourses()
    {
        return view('landingpage.landing');
    }
}
