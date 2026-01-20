<?php

namespace App\Policies;

use App\Models\Player;

class PlayerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?Player $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?Player $user, Player $player): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Player $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Player $user, Player $player): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Player $user, Player $player): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Player $user, Player $player): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Player $user, Player $player): bool
    {
        return false;
    }
}
