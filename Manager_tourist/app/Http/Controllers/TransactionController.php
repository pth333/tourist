<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Trait\DeleteModalTrait;
use App\Models\User;


class TransactionController extends Controller
{
    use DeleteModalTrait;
    private $transaction;
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }
    public function listTransactionTour()
    {
        $transactions = $this->transaction->latest()->paginate(5);
        // dd($transactions);
        return view('admin.transaction.index', compact('transactions'));
    }

    public function editTransactionTour($id)
    {
        $transaction = Transaction::find($id);
        $transactionOrder = $transaction->order;
        $transactionUser = $transaction->user;
        // dd($transactionOrder);
        return response()->json([
            'code' => 200,
            'transaction' => $transaction,
            'transactionOrder' => $transactionOrder,
            'transactionUser' => $transactionUser,
        ], 200);
    }

    public function updateTransactionTour(Request $request)
    {
        $transaction = Transaction::find($request->input('transactionId'));
        $userId = $transaction->user_id;
        $orderId = $transaction->order_id;
        // dd($orderId);
        $transaction->update([
            'total_tran' => $request->total_tran,
        ]);
        User::find($userId)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        Order::find($orderId)->update([
            'total_person' => $request->total_person,
            'total_deposit' => $request->total_deposit,
        ]);

        return redirect()->back()->with('ok', 'Bạn sửa giao dịch thành công');
    }
    public function destroyTransactionTour($id)
    {
        return $this->deleteModalTrait($id, $this->transaction);
    }
}
