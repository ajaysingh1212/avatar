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
    public function index(Request $request)
    {
        $query = WalletTransaction::with('wallet.user')->latest();

        // Wallet filter
        if ($request->wallet) {
            $query->where('wallet_id', $request->wallet);
        }

        // Status filter
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Date filter
        if ($request->from_date && $request->to_date) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        $transactions = $query->get();

        return view('admin.transactions.index', compact('transactions'));
    }

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

        // ❌ CHECK 1: Wallet status
        if($wallet->status != 'approved'){
            return response()->json([
                'message'=>'Wallet is not approved'
            ],422);
        }

        // ❌ CHECK 2: Frozen wallet
        if($wallet->is_frozen){
            return response()->json([
                'message'=>'Wallet is frozen, cannot add funds'
            ],422);
        }

        // ❌ CHECK 3: Fraud flag
        if($wallet->fraud_flag){
            return response()->json([
                'message'=>'Wallet is flagged for suspicious activity'
            ],422);
        }

        // ❌ CHECK 4: Single transaction limit
        if($wallet->single_txn_limit && $request->amount > $wallet->single_txn_limit){
            return response()->json([
                'message'=>'Amount exceeds single transaction limit'
            ],422);
        }

        DB::beginTransaction();

        try{

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
                'description'=>'Admin added fund request',

                'performed_by'=>auth()->id(),
                'module'=>'transaction',
                'ip'=>$request->ip()

            ]);

            DB::commit();

            return response()->json([
                'message'=>'Fund request created successfully'
            ]);

        }catch(\Exception $e){

            DB::rollBack();

            return response()->json([
                'message'=>'Failed to add fund'
            ],500);
        }
    }
    public function holdTransaction($id)
{
    $txn = WalletTransaction::findOrFail($id);

    $txn->update([
        'status' => 'hold',
        'updated_by_id'=>auth()->id(),
        'updated_ip'=>request()->ip()
    ]);

    WalletHistory::create([
        'wallet_id'=>$txn->wallet_id,
        'action'=>'transaction_hold',
        'description'=>'Transaction put on hold',
        'performed_by'=>auth()->id(),
        'module'=>'transaction',
        'ip'=>request()->ip()
    ]);

    return response()->json([
        'message'=>'Transaction on hold'
    ]);
}



   public function approveTransaction($id)
    {
        DB::beginTransaction();

        try {

            $txn = WalletTransaction::findOrFail($id);
            $wallet = Wallet::findOrFail($txn->wallet_id);

            // ❌ Already processed check
            if($txn->status != 'pending'){
                return response()->json([
                    'message' => 'Transaction already processed'
                ], 422);
            }

            // ❌ Wallet status check
            if($wallet->status != 'approved'){
                return response()->json([
                    'message' => 'Wallet is not active (not approved)'
                ], 422);
            }

            // ❌ Frozen check
            if($wallet->is_frozen){
                return response()->json([
                    'message' => 'Wallet is frozen, cannot approve transaction'
                ], 422);
            }

            // ❌ Fraud check
            if($wallet->fraud_flag){
                return response()->json([
                    'message' => 'Wallet flagged for suspicious activity'
                ], 422);
            }

            // ❌ HOLD check (important)
            if($txn->status == 'hold'){
                return response()->json([
                    'message' => 'Transaction is on hold, cannot approve'
                ], 422);
            }

            // ✅ APPROVE
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
                'message'=>'Transaction approved successfully'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message'=>'Transaction failed',
                'error' => $e->getMessage() // optional for debug
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
public function show($id)
{
    $txn = WalletTransaction::with('wallet.user')->findOrFail($id);

    return view('admin.transactions.show', compact('txn'));
}
    public function history($wallet_id)
    {

        $transactions = WalletTransaction::where('wallet_id',$wallet_id)
                        ->latest()
                        ->get();

        return response()->json($transactions);

    }

}
