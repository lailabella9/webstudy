<?php

namespace App\Policies;

use App\Models\Materi;
use App\Models\User;

class MateriPolicy
{
    public function update(User $user, Materi $materi): bool
    {
        return $user->Id_user === $materi->Id_user;
    }

    public function delete(User $user, Materi $materi): bool
    {
        return $user->Id_user === $materi->Id_user;
    }
}
