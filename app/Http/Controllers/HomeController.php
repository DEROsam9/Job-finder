<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCareerRequest;
use App\Models\Career;
use App\Models\JobCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {

        return view('components.pages.home');
    }

    public function application() {

        $jobCategories = JobCategory::all();

        $careers = Career::all();

        return view('components.pages.applications', compact(['jobCategories', 'careers']));
    }
}
