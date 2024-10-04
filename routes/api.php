<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Api\Cart\CartController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\Loan\LoanController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Profile\KycController;
use App\Http\Controllers\Api\User\PaymentController;
use App\Http\Controllers\Api\Auth\PasswordController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Income\IncomeController;
use App\Http\Controllers\Api\Review\ReviewController;
use App\Http\Controllers\Api\Wallet\WalletController;
use App\Http\Controllers\Api\Booking\BookingController;
use App\Http\Controllers\Api\Profile\ProfileController;
use App\Http\Controllers\Api\User\PropertiesController;
use App\Http\Controllers\Api\Profile\SettingsController;
use App\Http\Controllers\Api\Location\LocationController;
use App\Http\Controllers\Api\Withdraw\WithdrawController;
use App\Http\Controllers\Api\User\SavedPropertyController;
use App\Http\Controllers\Api\Admin\Payout\PayoutController;
use App\Http\Controllers\Api\Admin\Support\SupportController;
use App\Http\Controllers\Api\RewardController\RewardController;
use App\Http\Controllers\Api\Transaction\TransactionController;
use App\Http\Controllers\Api\User\Portfolio\PortfolioController;
use App\Http\Controllers\Api\Admin\Amenities\AmenitiesController;
use App\Http\Controllers\Api\Notification\NotificationController;
use App\Http\Controllers\Api\Admin\Investment\InvestmentController;
use App\Http\Controllers\Api\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Api\Support\SupportController as SupportSupportController;
use App\Http\Controllers\Dashboard\ProfileController as DashboardProfileController;
use App\Http\Controllers\Api\Admin\Wallet\WalletController as AdminWalletController;
use App\Http\Controllers\Api\Admin\Booking\BookingController as BookingBookingController;
use App\Http\Controllers\Api\Admin\Payment\PaymentController as PaymentPaymentController;
use App\Http\Controllers\Api\Admin\Property\PropertyController as PropertyPropertyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\CoOwnerController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('role:guest')->group(function () {
        Route::get('/guest/apartments', [GuestController::class, 'viewApartments']);
        Route::post('/guest/book', [GuestController::class, 'bookApartment']);
    });

    Route::middleware('role:co-owner')->group(function () {
        Route::get('/co-owner/properties', [CoOwnerController::class, 'manageProperties']);
        Route::post('/co-owner/add-property', [CoOwnerController::class, 'addProperty']);
        Route::post('/co-owner/book', [CoOwnerController::class, 'bookApartment']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
        Route::post('/admin/manage-users', [AdminController::class, 'manageUsers']);
    });
    
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/', function(){
    return response()->json('Maihomm Api');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/webhooks/kyc-verifications', [DashboardProfileController::class, "handleWebhook"]);
Route::get("countries", [LocationController::class, "getCountries"]);

Route::post("/register", [RegisterController::class, "register"]);
Route::post("/login", [LoginController::class, "login"]);
Route::post('/forgot-password', [PasswordController::class, 'sendResetEmail']);
Route::post("/password-reset", [PasswordController::class,  "passwordReset"]);

Route::post("/resend-email-otp/{user_id}", [RegisterController::class,  "resendEmailOtp"]);
Route::post("/verify-email-otp/{user_id}", [RegisterController::class,  "verifyEmailOtp"]);


Route::post('/auth/2fa-code/send', [LoginController::class, 'resendTwoFactorCode']);
Route::post('/auth/2fa-code/verify', [LoginController::class, 'verifyTwoFactorCode']);

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleController::class, 'handleApiGoogleCallback']);

Route::middleware("auth:sanctum")->group(function () {
    Route::get('/me', [LoginController::class, 'me']);

    Route::prefix("notifications")->group(function () {
        Route::get("/", [NotificationController::class, "myNotifications"]);
        Route::post("/mark-as-read/{id}", [NotificationController::class, "markAsRead"]);
    });

    Route::prefix("withdraw")->group(function () {
        Route::post("/", [WithdrawController::class, "withdraw"]);
    });

    Route::prefix('user')->group(function () {
        Route::prefix("properties")->group(function () {
            Route::get('/', [PropertiesController::class, 'list']);

            // Route::prefix("{property}")->group(function () {
            Route::get('show/{property}', [PropertiesController::class, 'show']);
            Route::post('sell', [PropertiesController::class, 'sell']);
            Route::get('add-to-favorites/{property}', [PropertiesController::class, 'addToFavorites']);
            Route::get('related-properties/{property}', [PropertiesController::class, 'relatedProperties']);
            // });

            Route::get('saved/properties', [SavedPropertyController::class, 'list']);
            Route::post('save', [SavedPropertyController::class, 'save']);
            Route::delete('saved-properties/{saved_property}/remove', [SavedPropertyController::class, 'remove']);

            Route::prefix("payment")->group(function () {
                Route::post('send', [PaymentController::class, 'send']);
            });
        });

        Route::prefix("profile")->group(function () {
            Route::get("/", [ProfileController::class, "index"]);
            Route::post("/update", [ProfileController::class, "update"]);
            Route::post('kyc-verification', [KycController::class, 'uploadKyc']);
            Route::prefix("settings")->group(function () {
                Route::get("currencies", [SettingsController::class, "currencies"]);
                Route::get("languages", [SettingsController::class, "languages"]);
                Route::post("change-password", [SettingsController::class, "changePassword"]);
                Route::post("field-update", [SettingsController::class, "updateField"]);
            });
        });
        Route::prefix("portfolio")->group(function () {
            Route::get('/', [PortfolioController::class, 'index']);
            Route::prefix("loans")->group(function () {
                Route::get("history", [LoanController::class, "history"]);
                Route::post("apply", [LoanController::class, "apply"]);
                // Route::post("view/{id}", [LoanController::class, "view"]);
            });
            Route::prefix("income")->group(function () {
                Route::get("history", [IncomeController::class, "history"]);
            });
            Route::get('investments', [PortfolioController::class, 'investments']);
        });
        Route::prefix("carts")->group(function () {
            Route::prefix("items")->group(function () {
                Route::get("/", [CartController::class, "inCart"]);
                Route::get("remove/{property_id}", [CartController::class, "removeFromCart"]);
                Route::get("add/{property_id}", [CartController::class, "addToCart"]);
                Route::get("update/{property_id}/{quantity}", [CartController::class, "updateCart"]);
            });
            Route::get("order-summary", [CartController::class, "summary"]);
            Route::post("checkout", [CartController::class, "checkOut"]);
        });
        Route::prefix("orders")->group(function () {
            Route::get("/", [CartController::class, "inCart"]);
            Route::get("remove/{property_id}", [CartController::class, "removeFromCart"]);
        });


        Route::prefix("bookings")->group(function () {
            Route::get("/history", [BookingController::class, "history"]);
            Route::post("/check-code", [BookingController::class, "checkCode"]);
            Route::post("/book", [BookingController::class, "book"]);
        });
        Route::prefix("wallets")->group(function () {
            Route::get("/my-wallet", [WalletController::class, "myWallet"]);
            Route::post("/upload-fund-proof", [WalletController::class, "uploadProof"]);
        });

        Route::prefix("rewards")->group(function () {
            Route::get("/", [RewardController::class, "list"]);
        });

        Route::prefix("transactions")->group(function () {
            Route::get("/", [TransactionController::class, "list"]);
        });

        Route::prefix("overviews")->group(function () {
            Route::get("/", [DashboardController::class, "overview"]);
        });
        Route::prefix("reviews")->group(function () {
            Route::prefix("{property}")->group(function () {
                Route::get("/list", [ReviewController::class, "list"]);
                Route::post("/send", [ReviewController::class, "send"]);
            });
            Route::post("/like/{review}", [ReviewController::class, "like"]);
            Route::post("/comment/{review}", [ReviewController::class, "comment"]);
            Route::get("/comments/{review}", [ReviewController::class, "comments"]);
        });

        Route::prefix("supports")->group(function () {
            Route::post("/submit", [SupportSupportController::class, "submit"]);
        });
    });
    Route::middleware("api_admin")->prefix("admin")->group(function () {
        Route::get("overview", [AdminDashboardController::class, "overview"]);
        Route::get("users", [UserController::class, "index"]);
        Route::get("users/show/{id}", [UserController::class, "show"]);
        Route::post("users/store", [UserController::class, "store"]);
        Route::post("users/update/{id}", [UserController::class, "update"]);
        Route::delete("users/delete/{id}", [UserController::class, "destroy"]);
        Route::post("users/remove-picture/{id}", [UserController::class, "removePicture"]);
        Route::post("users/upload-picture/{id}", [UserController::class, "uploadPicture"]);

        Route::prefix("wallets")->group(function () {
            Route::get("/fund-proofs", [AdminWalletController::class, "proofs"]);
            Route::post("/change-status/{proof}", [AdminWalletController::class, "changeStatus"]);
        });

        Route::prefix("properties")->group(function () {
            Route::get("/list", [PropertyPropertyController::class, "list"]);
            Route::post("/create", [PropertyPropertyController::class, "create"]);
            Route::get("/show/{id}", [PropertyPropertyController::class, "show"]);
            Route::post("/export-sample", [PropertyPropertyController::class, "exportSample"]);
            Route::post("/import", [PropertyPropertyController::class, "import"]);
            Route::post("/update/{property}", [PropertyPropertyController::class, "update"]);
            Route::post("/add-files/{property}", [PropertyPropertyController::class, "addFiles"]);
            Route::post("/remove-files/{property}", [PropertyPropertyController::class, "removeFiles"]);
            Route::delete("/delete/{id}", [PropertyPropertyController::class, "destroy"]);
        });
        Route::prefix("payments")->group(function () {
            Route::get("/list", [PaymentPaymentController::class, "index"]);
            Route::get("/show/{id}", [PaymentPaymentController::class, "show"]);
            Route::post("/change-status/{id}", [PaymentPaymentController::class, "changeStatus"]);
            Route::get("/export", [PaymentPaymentController::class, "export"]);
            Route::post("/settings", [PaymentPaymentController::class, "settings"]);
        });

        Route::prefix("amenities")->group(function () {
            Route::get("/", [AmenitiesController::class, "index"]);
            Route::post("/add", [AmenitiesController::class, "store"]);
            Route::post("/update/{id}", [AmenitiesController::class, "update"]);
            Route::delete("/delete/{id}", [AmenitiesController::class, "destroy"]);
        });

        Route::prefix("supports")->group(function () {
            Route::get("/list", [SupportController::class, "list"]);
            Route::post("/update/{id}", [SupportController::class, "update"]);
            Route::post("/broadcast", [SupportController::class, "broadcast"]);
        });

        Route::prefix("payouts")->group(function () {
            Route::get("/list", [PayoutController::class, "list"]);
            Route::get("/export", [PayoutController::class, "export"]);
        });
        Route::prefix("investments")->group(function () {
            Route::get("/list", [InvestmentController::class, "list"]);
        });
        Route::prefix("bookings")->group(function () {
            Route::get("/list", [BookingBookingController::class, "list"]);
            Route::get("/export", [BookingBookingController::class, "export"]);
            Route::post("/approve", [BookingBookingController::class, "approve"]);
            Route::post("/update/{id}", [BookingBookingController::class, "update"]);
        });
    });
});
