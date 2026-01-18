<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function welcome()
    {
        $data = [
            'title' => 'Welcome Page',
            'name' => 'John Doe',

        ];

        return view('welcomev2', $data);
    }

    public function about()
    {
        return view('about', [
            'company' => 'My John Doe Company',
            'founded' => 2020
        ]);
    }
}
