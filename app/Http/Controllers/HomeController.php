<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCareerRequest;
use App\Models\Career;
use App\Models\JobCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {

        // return view('components.pages.home2');
        return view('components.pages.home2');
    }

    public function application() {

        $jobCategories = JobCategory::all();

        $careers = Career::all();

        return view('components.pages.applications', compact(['jobCategories', 'careers']));
    }
<<<<<<< HEAD
    public function about() {
        return view('components.pages.about');
    }
    public function patners() {
        return view('components.pages.patners');
    }
    public function experiences() {
        return view('components.pages.experiences');
    }
    public function services() {
        return view('components.pages.services');
=======

    public function trackApplication() {

        return view('components.pages.track-application');
>>>>>>> origin/feature/home-layout-update
    }
}
