<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    public function respond(User $user, Review $review)
    {
        return $user->id === $review->musician_id;
    }

    public function moderate(User $user, Review $review)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Review $review)
    {
        return $user->id === $review->user_id || 
               $user->id === $review->musician_id || 
               $user->isAdmin();
    }
} 