<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    // Semua user (admin, staff, viewer) bisa melihat list
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'staff', 'viewer']);
    }

    // Semua user bisa melihat detail
    public function view(User $user, Book $book): bool
    {
        return in_array($user->role, ['admin', 'staff', 'viewer']);
    }

    // Hanya Admin dan Staff yang bisa membuat buku baru
    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'staff']);
    }

    // Hanya Admin dan Staff yang bisa mengedit buku
    public function update(User $user, Book $book): bool
    {
        return in_array($user->role, ['admin', 'staff']);
    }

    // HANYA Admin yang bisa menghapus buku (Staff & Viewer dilarang)
    public function delete(User $user, Book $book): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, Book $book): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Book $book): bool
    {
        return $user->role === 'admin';
    }
}