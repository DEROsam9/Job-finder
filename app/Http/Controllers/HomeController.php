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
    public function about() {
        return view('components.pages.about');
    }
    public function patners() {
        return view('components.pages.patners');
    }
    public function testimonials() {
        return view('components.pages.testimonials');
    }
    public function service() {
        return view('components.pages.service');
    }
}
