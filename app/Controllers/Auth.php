<?php

namespace App\Controllers;

use App\Models\UserModel;

/**
 * Auth
 * ----
 * Handles registration, login, and logout.
 *
 * Security highlights:
 *   - All POST endpoints are protected by the global CSRF filter
 *     (see app/Config/Filters.php). The matching `<?= csrf_field() ?>`
 *     token is rendered inside every form view.
 *   - Passwords are hashed by UserModel::hashPassword() and verified
 *     here with password_verify().
 *   - User input is never echoed back without esc() in the views.
 */
class Auth extends BaseController
{
    // ------------------------------------------------------------------
    // GET handlers — render the forms.
    // ------------------------------------------------------------------

    public function login(): string
    {
        return view('auth/login');
    }

    public function register(): string
    {
        return view('auth/register');
    }

    // ------------------------------------------------------------------
    // POST handlers — process the forms.
    // ------------------------------------------------------------------

    /**
     * Validate credentials and start a session.
     */
    public function attemptLogin(): \CodeIgniter\HTTP\RedirectResponse
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email    = (string) $this->request->getPost('email');
        $password = (string) $this->request->getPost('password');

        $user = (new UserModel())->findByEmail($email);

        if ($user === null || ! password_verify($password, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid email or password.');
        }

        // Successful login — store only what the views actually need.
        session()->set([
            'userId'     => $user['id'],
            'username'   => $user['username'],
            'email'      => $user['email'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/dashboard');
    }

    /**
     * Create a new account, then forward straight to login.
     */
    public function attemptRegister(): \CodeIgniter\HTTP\RedirectResponse
    {
        $users = new UserModel();

        $payload = [
            'username' => (string) $this->request->getPost('username'),
            'email'    => (string) $this->request->getPost('email'),
            'password' => (string) $this->request->getPost('password'),
        ];

        if (! $users->insert($payload)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $users->errors());
        }

        return redirect()->to('/login')
            ->with('success', 'Account created. You can sign in now.');
    }

    /**
     * Destroy the session and return to the landing page.
     */
    public function logout(): \CodeIgniter\HTTP\RedirectResponse
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'You have been signed out.');
    }
}
