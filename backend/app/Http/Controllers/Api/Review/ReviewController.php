<?php

namespace App\Http\Controllers\Api\Review;

use App\Constants\ApiConstants;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Properties\ReviewCommentResource;
use App\Http\Resources\Properties\ReviewResource;
use App\Models\Property;
use App\Models\Review;
use App\Models\ReviewComment;
use App\Services\Review\ReviewService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReviewController extends Controller
{
    public function list(Request $request, Property $property)
    {
        try {
            $reviews = ReviewService::getReviews($request, $property);
            $data = ApiHelper::collect_pagination($reviews);
            $data["data"] = ReviewResource::collection($data["data"]);
            return ApiHelper::validResponse("All reviews for this property retrieved!", $data);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function send(Request $request, Property $property)
    {
        try {
            $data = $request->all();
            $data["property_id"] = $property->id;
            $data["user_id"] = auth()->id();
            $review = ReviewService::send($data);
            $data = ReviewResource::make($review);
            return ApiHelper::validResponse("Review sent successfully, thanks for your sincere feedbacks", $data);
        } catch (ValidationException $e) {
            return ApiHelper::inputErrorResponse($e->getMessage(), ApiConstants::SERVER_ERR_CODE, null,  $e);
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function like(Review $review)
    {
        try {
            ReviewService::likeAction($review);
            return ApiHelper::validResponse("Review liked!");
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function comment(Request $request, Review $review)
    {
        try {
            $request["review_id"] = $review->id;
            $request->validate([
                "review_id" => "required|exists:reviews,id",
                "comment" => "required|string"
            ]);
            ReviewService::commentAction($request->all());
            return ApiHelper::validResponse("Review comment submitted!");
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }

    public function comments(Request $request, Review $review)
    {
        try {
            $comments = ReviewComment::where("review_id", $review->id)->latest()->get();
            return ApiHelper::validResponse("Review comments retrieved!" , ReviewCommentResource::collection($comments));
        } catch (Exception $e) {
            return ApiHelper::problemResponse("Something went wrong while processing your request", ApiConstants::SERVER_ERR_CODE, null,  $e);
        }
    }
}
