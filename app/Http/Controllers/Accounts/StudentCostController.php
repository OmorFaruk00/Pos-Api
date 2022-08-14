<?php

namespace App\Http\Controllers\Accounts;

use Illuminate\Http\Request;
use App\Models\Accounts\Fund;
use App\Models\Accounts\SubFund;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Accounts\StudentCost;
use App\Models\Accounts\Transaction;
use App\Models\Accounts\PaymentPurpose;


class StudentCostController extends Controller
{
    public function takingCost(Request $request)
    {
        $request->validate([
            'purpose' => 'required|exists:payment_purposes,id',
            'roll' => 'required',
            'department' => 'required',
            'batch_id' => 'required',
            'payBy' => 'required',
            'amount' => 'required',
        ]);

        // try {
        DB::beginTransaction();
        // finding purpose of payment
        $purpose = PaymentPurpose::findOrFail($request->purpose);
        if ($purpose->amount < $request->scholarship) {
            return response(['message' => 'Please See Again'], 422);
        }

        $fund = Fund::findOrFail($purpose->fund_id);
        $subfund = SubFund::findOrFail($purpose->sub_fund_id);

        $lilha = Fund::where('name', 'LILHA')->first();
        if ($request->payBy == 'LILHA') {
            if (!$lilha || !$lilha->total_cash) {
                return response(['message' => 'LILHA has not enough money'], 422);
            }
            if ($lilha && $lilha->total_cash < $request->lilha_pay) {
                return response(['message' => 'LILHA has not enough money'], 422);
            }
        }
        $studentCost = StudentCost::create([
            'student_id' => $request->roll,
            'department_id' => $request->department,
            'batch_id' => $request->batch_id,
            'fee_type' => $purpose->id,
            'month_count' => $request->monthCount ?? $request->monthCount,
            'amount' => $request->amount,
            'scholarship' => $request->scholarship ?? $request->scholarship,
            'date' => $request->date ?? $request->date,
        ]);

        // transaction start
        $transaction = new Transaction();
        // $transaction->name = $purpose->name;
        $transaction->trans_type = $request->payBy;
        $transaction->amount = $request->amount;
        $transaction->fund_id = $purpose->fund_id;
        $transaction->sub_fund_id = $purpose->sub_fund_id;
        $transaction->user_id = $request->roll;
        // transactions methods
        if ($request->payBy == "BANK") {
            $transaction->account_no = $request->receiptNo;
        }
        // scholarship
        $transaction->scholarship = $request->scholarship ?? $request->scholarship;
        $transaction->scholarship_type = $request->scholarship_type ?? $request->scholarship_type;
        // transaction fund and subfund
        if ($request->payBy == 'LILHA') {
            $transaction->lilha_pay = $request->lilha_pay;
            $fund->increment('total_cash', $request->amount);
            $subfund->increment('total', $request->amount);
            $lilha->decrement('total_cash', $request->amount);
            $transaction->type = 'debit';
        } else {
            if ($request->scholarship) {
                $newAmount = $request->amount - $request->scholarship;
                $fund->increment('total_cash', $newAmount);
                $subfund->increment('total', $newAmount);
            } else {
                $fund->increment('total_cash', $request->amount);
                $subfund->increment('total', $request->amount);
            }

            $transaction->type = 'credit';
        }
        // who take the transaction

        $transaction->received_by = auth()->user()->id;
        $transaction->transactionable_id = $studentCost->id;
        $transaction->transactionable_type = 'App\Models\Accounts\StudentCost';
        $transaction->save();
        // student cost

        DB::commit();
        return response(['message' => 'Student Cost Make Successful']);
        //        } catch (\Exception $e) {
        //            DB::rollBack();
        //            return response()->json(['error' => $e->getMessage()], 500);
        //        }

    }
}
