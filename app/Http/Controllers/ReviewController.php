<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request, User $musician)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
            'photos.*' => 'nullable|image|max:2048'
        ]);

        $photos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('reviews', 'public');
                $photos[] = $path;
            }
        }

        $review = $musician->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'photos' => $photos,
            'is_moderated' => false
        ]);

        return redirect()->back()->with('success', 'Отзыв успешно добавлен и ожидает модерации.');
    }

    public function respond(Request $request, Review $review)
    {
        $this->authorize('respond', $review);

        $request->validate([
            'response' => 'required|string|min:10'
        ]);

        $review->update([
            'response' => $request->response
        ]);

        return redirect()->back()->with('success', 'Ответ на отзыв успешно добавлен.');
    }

    public function react(Request $request, Review $review)
    {
        $request->validate([
            'type' => 'required|in:like,dislike'
        ]);

        $user = auth()->user();
        $existingReaction = $review->getUserReaction($user);

        if ($existingReaction) {
            if ($existingReaction->type === $request->type) {
                $existingReaction->delete();
                $this->updateReactionCounts($review);
            } else {
                $existingReaction->update(['type' => $request->type]);
                $this->updateReactionCounts($review);
            }
        } else {
            $review->reactions()->create([
                'user_id' => $user->id,
                'type' => $request->type
            ]);
            $this->updateReactionCounts($review);
        }

        return response()->json([
            'likes_count' => $review->likes_count,
            'dislikes_count' => $review->dislikes_count
        ]);
    }

    private function updateReactionCounts(Review $review)
    {
        $review->update([
            'likes_count' => $review->likes()->count(),
            'dislikes_count' => $review->dislikes()->count()
        ]);
    }

    public function moderate(Review $review)
    {
        $this->authorize('moderate', $review);

        $review->update([
            'is_moderated' => true,
            'moderated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Отзыв успешно прошел модерацию.');
    }

    public function delete(Review $review)
    {
        $this->authorize('delete', $review);

        if ($review->photos) {
            foreach ($review->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $review->delete();

        return redirect()->back()->with('success', 'Отзыв успешно удален.');
    }
}
