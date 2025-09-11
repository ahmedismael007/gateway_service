<?php

namespace App\Http\Repositories\v1;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function index()
    {
        return User::latest()->paginate(25);
    }

    public function create(array $data): User {
        return User::create($data);
    }

    public function find(int $id): ?User
    {
        $user = User::find($id);

        if (!$user) {
            throw new ModelNotFoundException("User with ID {$id} not found.");
        }

        return $user;
    }

    public function update(int $id, array $data): User
    {
        $user = $this->find($id);

        $user->update($data);

        return $user->fresh();
    }

    public function delete(array $ids): Bool {
        return DB::transaction(function () use ($ids) {
            return User::whereIn('id', $ids)->delete() > 0;
        });
    }
}

