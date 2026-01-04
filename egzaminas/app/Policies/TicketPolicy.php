<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; //modify this so that any authenticated user can create a ticket, return $user->role === 'user'/employee, etc;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticket $ticket)
    {
        return $user->isAdmin() || $ticket->user_id === $user->id ? Response::allow() : Response::deny('You cannot update this ticket.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticket $ticket)
    {
        return $user->isAdmin() || $ticket->user_id === $user->id ? Response::allow() : Response::deny('You cannot delete this ticket.');
    }


    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(User $user, Ticket $ticket): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete(User $user, Ticket $ticket): bool
    // {
    //     return false;
    // }
}
