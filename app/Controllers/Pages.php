<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home | Bunch of Gifts',
        ];
        return view('pages/home', $data);
    }
    public function about()
    {
        $data = [
            'title' => 'About Us | Bunch of Gifts',
        ];
        return view('pages/about', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Contact Us | Bunch of Gifts',
            'alamat' => [
                [
                    'tipe' => 'rumah',
                    'alamat' => 'Jl. Lebak Bulus III no. 28A',
                    'kota' => 'Jakarta Selatan'
                ],
                [
                    'tipe' => 'Kantor',
                    'alamat' => 'Jl. Setiabudi no. 182',
                    'kota' => 'Bandung'
                ]
            ]
        ];

        return view('pages/contact', $data);
    }
    public function login()
    {
        $data = [
            'title' => 'login',
            'config' => config('Auth'),
        ];
        return view('auth/login', $data);
    }
    public function register()
    {
        $data['title'] = 'register';
        return view('auth/register', $data);
    }
    public function user()
    {
        return view('user/index');
    }
}
