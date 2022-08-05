<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Accounts\Fund;
use App\Models\Accounts\PaymentPurpose;
use App\Models\Accounts\StudentCost;
use App\Models\Accounts\SubFund;
use App\Models\Accounts\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class StudentCostController extends Controller
{
    public function takingCost(Request $request)
    {
        $request->validate([
            'purpose' => 'required|exists:payment_purposes,id',
            'roll' => 'required',
            'class' => 'required',
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

        // $subfund=SubFund::findOrFail($purpose->sub_fund_id);

        // transaction start
        $transaction = new Transaction();
        $transaction->name = $purpose->name;
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
        $transaction->scholarship_type = $request->scholarshipType ?? $request->scholarshipType;
        // transaction fund and subfund
        if ($request->payBy == 'LILHA') {
            if (!$lilha || !$lilha->tatal_cash || $lilha->total_cash < $request->lilha_pay) {
                return response(['message' => 'LILHA has not enough money'], 422);
            }
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
            }else{
                $fund->increment('total_cash', $request->amount);
                $subfund->increment('total', $request->amount);
            }

            $transaction->type = 'credit';
        }
        // who take the transaction
        $transaction->received_by = auth()->user()->id;
        $transaction->save();
        // student cost
        StudentCost::create([
            'student_id' => $request->roll,
            'class_id' => $request->class,
            'fee_type' => $purpose->id,
            'month_count' => $request->monthCount ?? $request->monthCount,
            'amount' => $request->amount,
            'scholarship' => $request->scholarship ?? $request->scholarship,
            'transaction_id' => $transaction->id,
            'date' => $request->date ?? $request->date,
        ]);
        DB::commit();
        return response(['message' => 'Student Cost Make Successful']);
//        } catch (\Exception $e) {
//            DB::rollBack();
//            return response()->json(['error' => $e->getMessage()], 500);
//        }

    }
}
