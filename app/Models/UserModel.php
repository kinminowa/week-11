<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * UserModel
 * ----------
 * Handles all database operations for the `users` table.
 *
 * The `password` column is hashed with PHP's password_hash() before insert
 * via the beforeInsert / beforeUpdate callbacks defined here.
 */
class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = ['username', 'email', 'password'];

    // ------------------------------------------------------------------
    // Validation rules used automatically on insert / update.
    // ------------------------------------------------------------------
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id,{id}]',
        'email'    => 'required|valid_email|max_length[120]|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[6]|max_length[255]',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'That email address is already registered.',
        ],
        'username' => [
            'is_unique' => 'That username is already taken.',
        ],
    ];

    // ------------------------------------------------------------------
    // Callbacks: hash the password whenever it is written to the table.
    // ------------------------------------------------------------------
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data): array
    {
        if (! isset($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        return $data;
    }

    /**
     * Look up a user by email address. Returns null if not found.
     */
    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }
}
