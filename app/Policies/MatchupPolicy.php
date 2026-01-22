<?php

namespace App\Policies;

use App\Models\Matchup;
use App\Models\Player;

class MatchupPolicy
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
    public function view(?Player $user, Matchup $matchup): bool
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
    public function update(Player $user, Matchup $matchup): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Player $user, Matchup $matchup): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Player $user, Matchup $matchup): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Player $user, Matchup $matchup): bool
    {
        return false;
    }
}
