<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\WalletHistory;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{

    /* ===============================
       WALLET LIST
    =============================== */

    public function index()
    {

        $wallets = Wallet::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.wallets.index', compact('wallets'));

    }



    /* ===============================
       CREATE FORM
    =============================== */

    public function create()
    {

        $users = User::select('id','name')->get();

        return view('admin.wallets.create', compact('users'));

    }



    /* ===============================
       STORE WALLET
    =============================== */

    public function store(Request $request)
    {

        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        DB::beginTransaction();

        try{

            $wallet = Wallet::create([

                'user_id' => $request->user_id,

                'wallet_number' => $this->generateWalletNumber(),

                'balance' => 0,

                'status' => 'pending',

                'daily_limit' => 50000,
                'monthly_limit' => 500000,
                'single_txn_limit' => 10000,

                'daily_used' => 0,
                'monthly_used' => 0,

                'fraud_flag' => false,
                'fraud_score' => 0,

                'created_by_id' => auth()->id(),
                'created_ip' => $request->ip()

            ]);


            WalletHistory::create([

                'wallet_id'=>$wallet->id,
                'action'=>'wallet_created',
                'description'=>'Wallet created',
                'performed_by'=>auth()->id(),
                'module'=>'wallet',
                'ip'=>$request->ip()

            ]);


            DB::commit();

            return redirect()
                ->route('admin.wallets.index')
                ->with('success','Wallet created successfully');


        }catch(\Exception $e){

            DB::rollBack();

            return back()->with('error',$e->getMessage());

        }

    }



    /* ===============================
       SHOW WALLET
    =============================== */

    public function show($id)
    {

        $wallet = Wallet::with('user')->findOrFail($id);

        return view('admin.wallets.show', compact('wallet'));

    }



    /* ===============================
       EDIT FORM
    =============================== */

    public function edit($id)
    {

        $wallet = Wallet::findOrFail($id);

        return view('admin.wallets.edit', compact('wallet'));

    }



    /* ===============================
       UPDATE WALLET
    =============================== */

    public function update(Request $request,$id)
    {

        $wallet = Wallet::findOrFail($id);

        $request->validate([
            'balance'=>'required|numeric|min:0'
        ]);


        $wallet->update([

            'balance'=>$request->balance,

            'updated_by_id'=>auth()->id(),
            'updated_ip'=>$request->ip()

        ]);


        WalletHistory::create([

            'wallet_id'=>$wallet->id,
            'action'=>'wallet_updated',
            'description'=>'Wallet updated',
            'performed_by'=>auth()->id(),
            'module'=>'wallet',
            'ip'=>$request->ip()

        ]);


        return redirect()
            ->route('admin.wallets.index')
            ->with('success','Wallet updated');

    }



    /* ===============================
       APPROVE WALLET
    =============================== */

    public function approveWallet($id)
    {

        $wallet = Wallet::findOrFail($id);

        $wallet->update([

            'status'=>'approved',
            'approved_by'=>auth()->id(),
            'approved_at'=>now(),

            'updated_by_id'=>auth()->id(),
            'updated_ip'=>request()->ip()

        ]);


        WalletHistory::create([

            'wallet_id'=>$wallet->id,
            'action'=>'wallet_approved',
            'description'=>'Wallet approved',
            'performed_by'=>auth()->id(),
            'module'=>'wallet',
            'ip'=>request()->ip()

        ]);


        return back()->with('success','Wallet approved');

    }



    /* ===============================
       REJECT WALLET
    =============================== */

    public function rejectWallet($id)
    {

        $wallet = Wallet::findOrFail($id);

        $wallet->update([

            'status'=>'rejected',
            'updated_by_id'=>auth()->id(),
            'updated_ip'=>request()->ip()

        ]);


        WalletHistory::create([

            'wallet_id'=>$wallet->id,
            'action'=>'wallet_rejected',
            'description'=>'Wallet rejected',
            'performed_by'=>auth()->id(),
            'module'=>'wallet',
            'ip'=>request()->ip()

        ]);


        return back()->with('error','Wallet rejected');

    }



    /* ===============================
       FREEZE WALLET
    =============================== */

    public function freeze($id)
    {

        $wallet = Wallet::findOrFail($id);

        $wallet->update([

            'is_frozen'=>true,
            'frozen_at'=>now(),
            'frozen_by'=>auth()->id()

        ]);

        return back()->with('warning','Wallet frozen');

    }



    /* ===============================
       UNFREEZE WALLET
    =============================== */

    public function unfreeze($id)
    {

        $wallet = Wallet::findOrFail($id);

        $wallet->update([

            'is_frozen'=>false,
            'frozen_at'=>null,
            'frozen_by'=>null

        ]);

        return back()->with('success','Wallet unfrozen');

    }



    /* ===============================
       WALLET HISTORY
    =============================== */

    public function history($wallet_id)
    {

        $wallet = Wallet::findOrFail($wallet_id);

        $history = WalletHistory::where('wallet_id',$wallet_id)
            ->latest()
            ->get();

        return view('admin.wallets.history',compact('wallet','history'));

    }



    /* ===============================
       GENERATE WALLET NUMBER
    =============================== */

    private function generateWalletNumber()
    {

        do{

            $number = 'WLT'.date('Y').rand(100000,999999);

        }while(Wallet::where('wallet_number',$number)->exists());

        return $number;

    }
    public function analytics($id)
    {

    $wallet = Wallet::findOrFail($id);

    $data = WalletTransaction::where('wallet_id',$wallet->id)
    ->selectRaw('DATE(created_at) date, count(*) total')
    ->groupBy('date')
    ->get();

    return response()->json([
    'labels'=>$data->pluck('date'),
    'values'=>$data->pluck('total')
    ]);

    }
    public function liveTransactions($id)
    {

    $txns = WalletTransaction::where('wallet_id',$id)
    ->latest()
    ->take(10)
    ->get();

    return view('admin.wallets.live_txn_rows',compact('txns'));

    }

}
