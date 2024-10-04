<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Dashboard\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Dashboard\Admin\UsersController as UsersController;
use App\Http\Controllers\Dashboard\Admin\Finance\TransactionsController as TransactionsController;
use App\Http\Controllers\Dashboard\Admin\Property\PropertiesController as AdminPropertiesController;
use App\Http\Controllers\Dashboard\Admin\Property\PropertySpecController;
use App\Http\Controllers\Dashboard\Admin\Finance\PaymentController as AdminPaymentController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\User\PaymentController;
use App\Http\Controllers\Dashboard\User\PortfolioController;
use App\Http\Controllers\Dashboard\User\PropertiesController;
use App\Http\Controllers\Dashboard\User\SavedPropertyController;
use App\Http\Controllers\General\NotificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
|
| These are routes that can be accessed by unauthenticated users (guests).
|
*/

Route::prefix('guest')->as('guest.')->group(function () {
    Route::get('properties', [GuestPropertyController::class, 'index'])->name('properties.index');
    Route::get('properties/{property}', [GuestPropertyController::class, 'show'])->name('properties.show');
    
    // KYC route for guests
    Route::get('kyc', [GuestKycController::class, 'index'])->name('kyc.index');
    Route::post('kyc', [GuestKycController::class, 'submit'])->name('kyc.submit');
    
    // Example for a guest profile route
    Route::get('profile', [GuestProfileController::class, 'index'])->name('profile');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function(){
    exit('Api');
});

Route::get('verify-email/{id}', [HomeController::class, 'verifyEmail'])->name('verify-email');

Route::as("web.")->group(function () {
    Route::get('/', [HomeController::class, "index"])->name("index");
    Route::get('file/{path}', [HomeController::class, "read_file"])->name("read_file");

    Route::get('properties/featured', [PropertyController::class, "featured"])->name("properties.featured");
    Route::resources([
        'properties' => PropertyController::class,
    ]);
});
Route::get('/get-state/{country_id}', [HomeController::class, "getState"]);
Route::get('/get-city/{state_id}', [HomeController::class, "getCity"]);

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/admin', [LoginController::class, "showLoginForm"])->name("admin.login");
Route::get('/webhook/verifications', [ProfileController::class, "handleWebhook"]);

Auth::routes();

Route::middleware(["auth"])->as("dashboard.")->group(function () {
    Route::get("e", [DashboardController::class, "index"])->name("home");
    Route::prefix("notifications")->as("notifications.")->group(function () {
        Route::get("list", [NotificationController::class, 'list'])->name("list");
        Route::get("info/{id}", [NotificationController::class, 'info'])->name("info");
        Route::get("mark-as/{id}/{action}", [NotificationController::class, 'markAs'])->name("mark_as");
    });
    Route::middleware(["user"])->prefix("user")->as("user.")->group(function () {
        Route::get("profile", [ProfileController::class, "index"])->name("profile-page");
        Route::patch("update-profile", [ProfileController::class, "updateProfile"])->name("update-profile");

        Route::get("kyc-page", [ProfileController::class, "kycPage"])->name("show-kyc-page");
        Route::post("kyc-page/upload", [ProfileController::class, "kycUpload"])->name("upload-kyc");

        //Portfolios
        Route::prefix("portfolio")->as("portfolio.")->group(function () {
            Route::get("/", [PortfolioController::class, "index"])->name("index");
        });

        Route::get("saved-properties", [SavedPropertyController::class, "index"])->name("saved-properties");
        Route::post("saved-properties/{property}/store", [SavedPropertyController::class, "store"])->name("saved-properties.store");

        //Properties
        Route::prefix("properties")->as("properties.")->group(function () {
            Route::get("/", [PropertiesController::class, "index"])->name("index");
            Route::get("{property}/show", [PropertiesController::class, "show"])->name("show");

            Route::prefix("{property}/payments")->as("payments.")->group(function () {
                Route::get("/", [PaymentController::class, "index"])->name("index");
                Route::post("send", [PaymentController::class, "send"])->name("send-payment-proof");
                Route::get("paid", [PaymentController::class, "paid"])->name("paid");
            });
        });
    });

    Route::middleware(["admin"])->prefix("admin")->as("admin.")->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('home');

        Route::resources([
            'users' => UsersController::class,
            'properties' => AdminPropertiesController::class,
        ]);

        Route::prefix("properties/{property}")->group(function () {
            Route::resource('property-specs', PropertySpecController::class);
        });
        Route::patch("upload-files/{property}", [AdminPropertiesController::class, "uploadFiles"])->name("properties.upload-files");
        Route::patch("change-single-file/{file}", [AdminPropertiesController::class, "changeSingleFile"])->name("properties.change-single-file");
        Route::delete("delete-single-file/{file}", [AdminPropertiesController::class, "deleteSingleFile"])->name("properties.delete-single-file");
        Route::get('users/imitate/{id}', [UsersController::class, "imitate"])->name("users.imitate");

        Route::get("profile", [ProfileController::class, "index"])->name("profile-page");
        Route::patch("update-profile", [ProfileController::class, "updateProfile"])->name("update-profile");
        Route::prefix("finance")->as("finance.")->group(function () {
            Route::resource('transactions', TransactionsController::class)->only("index", "destroy");
            Route::post('transaction/status/{id}/change-status', [TransactionsController::class, "status"])->name("transactions.change_status");
            Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
            Route::post('/payments/{id}/change-status', [AdminPaymentController::class, 'changeStatus'])->name('payments.change_status');
        });

        Route::post("upload-property", [AdminPropertiesController::class, "upload"])->name("upload-property");
    });
});
