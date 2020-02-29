<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedingsController extends Controller
{
    public function index() {
        return view('feedings.index');
    }
}
