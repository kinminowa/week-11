<?php

namespace App\Controllers;

use App\Models\NoteModel;

/**
 * Dashboard
 * ---------
 * Protected area. The `auth` filter (see Routes.php) makes sure only
 * signed-in users ever reach this controller, so we can safely read
 * the session here.
 *
 * The notes form on this page is the project's CSRF demonstration.
 * Every POST endpoint below is automatically validated by the global
 * CSRF filter; the matching `<?= csrf_field() ?>` token is rendered
 * in the view.
 */
class Dashboard extends BaseController
{
    public function index(): string
    {
        $notes = (new NoteModel())->forUser((int) session()->get('userId'));

        return view('dashboard/index', [
            'username' => session()->get('username'),
            'email'    => session()->get('email'),
            'loginAt'  => date('M j, Y \a\t g:i a'),
            'notes'    => $notes,
        ]);
    }

    /**
     * Persist a new note for the signed-in user.
     */
    public function storeNote(): \CodeIgniter\HTTP\RedirectResponse
    {
        if (! $this->validate(['body' => 'required|max_length[500]'])) {
            return redirect()->to('/dashboard')
                ->with('errors', $this->validator->getErrors());
        }

        (new NoteModel())->insert([
            'user_id' => (int) session()->get('userId'),
            'body'    => (string) $this->request->getPost('body'),
        ]);

        return redirect()->to('/dashboard')->with('success', 'Note saved.');
    }

    /**
     * Delete a note that belongs to the signed-in user.
     */
    public function deleteNote(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $model = new NoteModel();
        $note  = $model->find($id);

        // Only the owner may delete; silently ignore otherwise.
        if ($note !== null && (int) $note['user_id'] === (int) session()->get('userId')) {
            $model->delete($id);
        }

        return redirect()->to('/dashboard')->with('success', 'Note deleted.');
    }
}
