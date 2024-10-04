<?php

namespace App\Http\Controllers\Dashboard\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Constants\AppConstants;
use App\Constants\NotificationConstants;
use App\Constants\StatusConstants;
use App\Constants\TransactionActivityConstants;
use App\Constants\TransactionConstants;
use App\Models\UserTransactionModel;
use App\QueryBuilders\Finance\TransactionQueryBuilder;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $typeOptions = [
        TransactionConstants::CREDIT => "Credit",
        TransactionConstants::DEBIT => "Debit",
    ];


    public function index(Request $request)
    {
        $transactions = TransactionQueryBuilder::filterList($request)->orderBy("id", "desc")
            ->paginate(AppConstants::ADMIN_PAGINATION_SIZE)->appends($request->query());

        // dd($transactions);
        return view('dashboards.admin.transactions.index', [
            "filterOptions" => [
                "currency_type" => "Currency Type",
                "username" => "Username",
            ],
            "transactions" => $transactions,
            "typeOptions" => $this->typeOptions,
            "statuses" => StatusConstants::TRANSACTION_OPTIONS,
            "activities" => TransactionActivityConstants::ADMIN_FILTER_OPTIONS
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaction = UserTransactionModel::findOrFail($id);

        if ($transaction->status != StatusConstants::PENDING) {
            return back()->with(NotificationConstants::ERROR_MSG, "You can only delete a pending transaction!");
        }

        $transaction->delete();
        return back()->with(NotificationConstants::SUCCESS_MSG, "Transaction deleted successfully!");
    }
}
