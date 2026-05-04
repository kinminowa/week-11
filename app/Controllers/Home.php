<?php

namespace App\Controllers;

/**
 * Home
 * ----
 * Public landing page. If the visitor is already authenticated they are
 * sent straight to the dashboard; otherwise the marketing page renders.
 */
class Home extends BaseController
{
    public function index(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('home');
    }
}
