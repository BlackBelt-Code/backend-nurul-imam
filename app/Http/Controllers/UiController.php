<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UiController extends Controller
{
    public function index() {

        $title = 'Academic Schools';

        return view('ui.index', 
            [ 'title' => $title ])->render();
    }

    public function about()
    {
        $title = 'Academic About';
    }
}
