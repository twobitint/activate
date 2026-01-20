<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\Player;

class GamePolicy
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
    public function view(?Player $user, Game $game): bool
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
    public function update(Player $user, Game $game): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Player $user, Game $game): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Player $user, Game $game): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Player $user, Game $game): bool
    {
        return false;
    }
}
