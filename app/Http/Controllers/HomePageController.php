<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function showContentPage()
    {
        $cards = [
            'PBKK1' => [
                'parent_title' => 'PBKK1',
                'children' => [
                    [
                        'route' => 'even-odd',
                        'title' => 'Even-Odd',
                        'description' => 'Determine whether a number is even or odd.'
                    ],
                    [
                        'route' => 'fibonacci',
                        'title' => 'Fibonacci',
                        'description' => 'Generate Fibonacci sequence.'
                    ],
                    [
                        'route' => 'prime-number',
                        'title' => 'Prime Number',
                        'description' => 'Check if a number is prime.'
                    ],
                    [
                        'route' => 'param',
                        'title' => 'Param',
                        'description' => 'Check if a number is prime.'
                    ]
                ]
            ],
        ];

        return view('home', compact('cards'));
    }
}
