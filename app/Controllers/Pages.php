<?php

namespace App\Controllers;
use CodeIgniter\Exceptions\PageNotFoundException;

class Pages extends BaseController
{
    public function index()
    {
        return view('auth/welcome_message');
    }

    public function view(string $page = 'home')
    {
        if (! is_file(APPPATH . 'Views/auth/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }


        $data['title'] = ucfirst($page); // Capitalize the first letter

        return view('templates/header', $data)
            . view('auth/pages/' . $page)
            . view('templates/footer');
    }
}
