<?php

namespace App\Console\Commands;

use App\Constants\AppConstants;
use App\Models\Portfolio;
use App\Models\User;
use App\Notifications\Auth\SignupNotification;
use App\Services\Booking\HabitableDayService;
use App\Services\General\Integration\CredequityService;
use App\Services\General\Integration\MetaMapService;
use App\Services\Property\ImportPropertyService;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // $address = "1600 Amphitheatre Parkway, Mountain View, CA";
        // $client = new Client(['base_uri' => 'https://nominatim.openstreetmap.org/']);
        // $response = $client->request('GET', 'search', [
        //     'query' => [
        //         'q' => $address,
        //         'format' => 'json',
        //         'addressdetails' => 1,
        //         'limit' => 1
        //     ]
        // ]);
        // $data = json_decode($response->getBody());
        // $location = [
        //     'lat' => $data[0]->lat,
        //     'lng' => $data[0]->lon
        // ];
        // dd($location);
        //     $form_file = new UploadedFile(public_path("samples/properties/properties-excel.xlsx"), "properties-excel.xlsx");
        //     (new ImportPropertyService)->importProperties($form_file);

        // $metamap = new MetaMapService;
        // $metamap->auth()->verify(User::first());

        $credequity = new CredequityService(User::find(2));
        $credequity
            ->setIdType(AppConstants::NIN)
            ->setNin(12345678900)
            ->verify()->update();

        // $model = new HabitableDayService(2);
        // $model->rewardHabitableDays(5000);
    }
}
