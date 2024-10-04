<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Constants\NotificationConstants;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Services\Finance\PropertyPaymentService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function index(Property $property)
    {
        $available_slots = $property->total_slots - $property->total_sold;
        return view("dashboards.user.properties.payment.index", [
            "property" => $property,
            "available_slots" => $available_slots
        ]);
    }

    public function send(Request $request, Property $property)
    {
        try {
            PropertyPaymentService::save($request->all());
            return redirect()->route("dashboard.user.properties.payments.paid", $property->id)
                ->with(NotificationConstants::SUCCESS_MSG, "Payment proof sent successfully. Do not resend");
        } catch (ValidationException $th) {
            throw $th;
        } catch (\Throwable $th) {
            return redirect()->back()->with(NotificationConstants::ERROR_MSG, "An error occured while trying to process your request");
        }
    }

    public function paid(Property $property)
    {
        return view("dashboards.user.properties.payment.paid", [
            "property" => $property
        ]);
    }
}
