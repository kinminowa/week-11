<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * NoteModel
 * ---------
 * Persists short text notes that belong to a single user.
 */
class NoteModel extends Model
{
    protected $table         = 'notes';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = ['user_id', 'body'];

    protected $validationRules = [
        'user_id' => 'required|is_natural_no_zero',
        'body'    => 'required|max_length[500]',
    ];

    /**
     * Newest-first list of notes for a single user.
     */
    public function forUser(int $userId): array
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
