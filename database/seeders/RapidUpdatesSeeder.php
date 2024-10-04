<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use App\Models\Property;
use App\Models\PropertyFile;
use App\Models\Review;
use App\Models\ReviewLike;
use App\Models\User;
use App\Services\Booking\HabitableDayService;
use App\Services\Portfolio\PortfolioService;
use Illuminate\Database\Seeder;

class RapidUpdatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $old_email = "sudo@maihomm.com";
        // $new_email = "admin@maihomm.com";
        // User::where("email", $new_email)->update(["first_name" => "Admin"]);

        //generate habitable code for existing users
        // $portfolios = Portfolio::get();
        // foreach($portfolios as $portfolio){
        //     $portfolio->update(["habitable_code" => HabitableDayService::generateHabitableCode()]);
        // }


        // $status = ["Available", "Sold", "Coming Soon"];

        // $properties = Property::get();
        // foreach ($properties as $key => $property) {
        //     $property->update([
        //         "status" => array_rand(array_flip($status)),
        //     ]);
        // }

        // $properties = Property::get();
        // foreach ($properties as $key => $property) {
        //     $property->update([
        //         "total_slots" => "20",
        //     ]);

        //     $array = [
        //         "South Victoria" => 43200,
        //         "Pembroke Road" => 43650,
        //         "Frederick Road" => 8550,
        //         "Deansgate" => 8730,
        //         "Birmingham Flat" => 6750,
        //         "Blackpool Duplex" => 7110,
        //         "#16N, New York, NY 10019" => 14800,
        //         "Arroios, Lisbon, Portugal" => 20560,
        //         "San Antonio Abad" => 14800,
        //         "Paris, Ile-De-France" => 36800,
        //         "Northwest" => 5850,
        //         "Studio Apartment" => 5400,
        //     ];

        //     foreach ($array as $property_name => $fee) {
        //         if ($property->name == $property_name) {
        //             $property->update([
        //                 "maihomm_fee" => $fee,
        //             ]);
        //         }
        //     }

        // }



        // $users = User::get();
        // foreach ($users as $key => $user) {
        //     $user->update([
        //         "email_verified_at" => now(),
        //     ]);
        // }

        // Property::whereNotNull("id")->update([
        //     "total_sold" => 6,
        //     "total_slots" => 20,
        // ]);

        // foreach (Property::get() as $property) {
        //     $files = PropertyFile::where("property_id", $property->id)->orderBy("id")->get();
        //     foreach ($files as $key => $file) {
        //         $file->update([
        //             "order" => $key + 1
        //         ]);
        //     }
        // }

        $deleted_users = User::onlyTrashed()->get();
        foreach ($deleted_users as $user) {
            if(str_contains($user->email , "?deleted=")){
                continue;
            }
            $suffix = "?deleted=" . time();
            $user->update([
                "email" => $user->email . $suffix,
                "phone_no" => $user->phone_no . $suffix,
            ]);
        }

        User::withTrashed()->where("email" , "like" , "%ugoloconfidence@gmail.com%")->update([
            "email" => "ugoloconfidence@gmail.com",
        ]);

        $reviews = Review::whereNull("property_id")->get();
        foreach ($reviews as $review) {
            ReviewLike::where("review_id", $review->id)->delete();
            $review->delete();
        }
    }
}
