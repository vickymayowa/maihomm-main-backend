<?php

namespace App\Http\Controllers\Dashboard\Admin\Finance;

use App\Constants\AppConstants;
use App\Constants\NotificationConstants;
use App\Constants\StatusConstants;
use App\Exceptions\Finance\PaymentException;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\Finance\PaymentStatusService;
use Exception;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::latest("id")
            ->paginate(AppConstants::ADMIN_PAGINATION_SIZE)
            ->appends($request->query());
        $statusOptions = StatusConstants::PAYMENT_OPTIONS;
        return view('dashboards.admin.payments.index', [
            'payments' => $payments,
            "statusOptions" => $statusOptions
        ]);
    }


    public function changeStatus(Request $request, $id)
    {
        try {
            PaymentStatusService::changeStatus($id, $request->status, $request->comment);
            return back()->with(NotificationConstants::SUCCESS_MSG, "Status updated successfully!");
        } catch (PaymentException $e) {
            return back()->with(NotificationConstants::ERROR_MSG, $e->getMessage());
        } catch (Exception $e) {
            return back()->with(NotificationConstants::ERROR_MSG, "An error occurred while procesing this request.");
        }
    }
}
