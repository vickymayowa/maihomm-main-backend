<?php

namespace App\Services\Review;

use App\Models\HabitableDay;
use App\Models\Referral;
use App\Models\Review;
use App\Models\ReviewComment;
use App\Models\ReviewLike;
use App\QueryBuilders\Finance\ReviewQueryBuilder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ReviewService
{
    public static function validate(array $data, $id = null)
    {
        $validator = Validator::make($data, [
            "user_id" => "required|exists:users,id",
            // "parent_id" => "nullable|exists:reviews,id",
            "property_id" => "required|exists:properties,id",
            "rating" => "nullable|integer",
            "likes_count" => "nullable|integer",
            "comment" => "required|string"
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $validator->validated();
    }
    public static function send($data)
    {
        $data = self::validate($data);
        return Review::create($data);
    }
    public static function getReviews($request, $property)
    {
        return ReviewQueryBuilder::filterList($request)->where("property_id", $property->id)->paginate();
    }

    public static function likeAction($review)
    {
        ReviewLike::firstOrCreate([
            "user_id" => auth()->id(),
            "review_id" => $review->id,
        ]);

        $review->increment("likes_count");
    }

    public static function commentAction(array $data)
    {
        ReviewComment::create([
            "user_id" => auth()->id(),
            "review_id" => $data["review_id"],
            "comment" => $data["comment"],
        ]);
    }
}
