<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\WalletHistory;
use DB;

class WalletTransactionController extends Controller
{

    public function pending()
    {

        $transactions = WalletTransaction::where('status','pending')
                        ->latest()
                        ->get();

        return response()->json($transactions);

    }

    public function addAmount(Request $request)
    {

        $request->validate([
            'wallet_id'=>'required|exists:wallets,id',
            'amount'=>'required|numeric|min:1'
        ]);

        $wallet = Wallet::findOrFail($request->wallet_id);

        $txn = WalletTransaction::create([

            'wallet_id'=>$wallet->id,

            'transaction_id'=>'TXN'.time().rand(1000,9999),

            'type'=>'credit',

            'amount'=>$request->amount,

            'before_balance'=>$wallet->balance,

            'after_balance'=>$wallet->balance + $request->amount,

            'status'=>'pending',

            'created_by_id'=>auth()->id(),

            'created_ip'=>$request->ip()

        ]);

        WalletHistory::create([

            'wallet_id'=>$wallet->id,

            'action'=>'amount_requested',

            'description'=>'User requested wallet topup',

            'performed_by'=>auth()->id(),

            'module'=>'transaction',

            'ip'=>$request->ip()

        ]);

        return response()->json([
            'message'=>'Amount request submitted',
            'data'=>$txn
        ]);

    }

    public function approveTransaction($id)
    {

        DB::beginTransaction();

        try {

            $txn = WalletTransaction::findOrFail($id);

            $wallet = Wallet::findOrFail($txn->wallet_id);

            $wallet->balance = $wallet->balance + $txn->amount;

            $wallet->save();

            $txn->update([

                'status'=>'approved',

                'approved_by'=>auth()->id(),

                'approved_at'=>now(),

                'updated_by_id'=>auth()->id(),

                'updated_ip'=>request()->ip()

            ]);

            WalletHistory::create([

                'wallet_id'=>$wallet->id,

                'action'=>'transaction_approved',

                'description'=>'Transaction approved',

                'performed_by'=>auth()->id(),

                'module'=>'transaction',

                'ip'=>request()->ip()

            ]);

            DB::commit();

            return response()->json([
                'message'=>'Transaction approved'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message'=>'Transaction failed'
            ],500);

        }

    }

    public function rejectTransaction($id)
    {

        $txn = WalletTransaction::findOrFail($id);

        $txn->update([

            'status'=>'rejected',

            'updated_by_id'=>auth()->id(),

            'updated_ip'=>request()->ip()

        ]);

        WalletHistory::create([

            'wallet_id'=>$txn->wallet_id,

            'action'=>'transaction_rejected',

            'description'=>'Transaction rejected by admin',

            'performed_by'=>auth()->id(),

            'module'=>'transaction',

            'ip'=>request()->ip()

        ]);

        return response()->json([
            'message'=>'Transaction rejected'
        ]);

    }

    public function history($wallet_id)
    {

        $transactions = WalletTransaction::where('wallet_id',$wallet_id)
                        ->latest()
                        ->get();

        return response()->json($transactions);

    }

}
