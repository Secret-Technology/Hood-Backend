<?php

namespace App\Http\Controllers\Api\V1\User\WalletTransaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\Wallet\ChargeRequest;
use App\Models\WalletTransaction;
use App\Http\Resources\Api\V1\User\WalletTransaction\WalletTransactionResource;

class WalletTransactionController extends Controller
{
    public function index()
    {
        $wallet_transactions = auth('user')->user()->walletTransactions()->latest()->take(7)->get();
        return WalletTransactionResource::collection($wallet_transactions)->additional(['status' => 'success', 'message' => null, 'wallet' =>round((float) auth('user')->user()->wallet,2)]);
    }

    public function allTransactions()
    {
        $wallet_transactions = auth('user')->user()->walletTransactions()->latest()->paginate(10);
        return WalletTransactionResource::collection($wallet_transactions)->additional(['status' => 'success', 'message' => null, 'wallet' => round((float) auth('user')->user()->wallet,2)]);
    }

    public function charge(ChargeRequest $request)
    {
        \DB::beginTransaction();
        try {
            WalletTransaction::create([
                'user_id'           => auth('user')->id(),
                'type'              => "wallet_charge",
                'transaction_type'  => "charge",
                'amount'            => $request->amount,
                'transaction_id'    => $request->transaction_id,
                'wallet_before'     => auth('user')->user()->wallet,
                'wallet_after'      => auth('user')->user()->wallet + $request->amount,
            ]);
            // auth('user')->user()->increment('wallet', $request->amount);
            $user = auth('user')->user();
            $user->wallet = $user->wallet + $request->amount;
            $user->save();
            \DB::commit();
            return response()->json(['status' => 'success', 'data' => null, 'message' => trans('api.messages.wallet_charged_by_amount', ['amount' => $request->amount]), 'wallet' => round((float) auth('user')->user()->wallet,2)]);
        } catch (Exception $e) {
            \DB::rollback();
            return response()->json(['status' => 'fail', 'data' => null, 'message' => trans('api.messages.error')], 500);
        }
    }
}
