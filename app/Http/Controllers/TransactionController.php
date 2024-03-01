<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->product_id);

        if ($product->quantity < $request->quantity) {
            return response()->json(['message' => 'Insufficient stock'], 400);
        }

        $transaction = new Transaction();
        $transaction->user_id = Auth::id();
        $transaction->product_id = $request->product_id;
        $transaction->quantity = $request->quantity;
        $transaction->price = $product->price * $request->quantity;
        $transaction->admin_fee = $transaction->price * 0.05;
        $transaction->tax = $transaction->price * 0.1;
        $transaction->total = $transaction->price + $transaction->admin_fee + $transaction->tax;
        $transaction->save();

        $product->quantity -= $request->quantity;
        $product->save();

        return response()->json(['message' => 'Transaction created successfully'], 201);
    }

    public function index(Request $request)
    {
        $transactions = Transaction::all();

        // "id": 3,
        //     "user_id": 5,
        //     "product_id": 5,
        //     "price": 100000,
        //     "quantity": 10,
        //     "admin_fee": 5000,
        //     "tax": 10000,
        //     "total": 115000,
        //     "created_at": "2024-03-01T08:48:05.000000Z",
        //     "updated_at": "2024-03-01T08:48:05.000000Z",
        //     "deleted_at": null

        return response()->json(['transactions' => $transactions], 200);
    }

    public function show($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        return response()->json(['transaction' => $transaction], 200);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $product = Product::find($transaction->product_id);

        if ($product->quantity < $request->quantity) {
            return response()->json(['message' => 'Insufficient stock'], 400);
        }

        $transaction->quantity = $request->quantity;
        $transaction->price = $product->price * $request->quantity;
        $transaction->admin_fee = $transaction->price * 0.05;
        $transaction->tax = $transaction->price * 0.1;
        $transaction->total = $transaction->price + $transaction->admin_fee + $transaction->tax;
        $transaction->save();

        $product->quantity -= $request->quantity;
        $product->save();

        return response()->json(['message' => 'Transaction updated successfully'], 200);
    }


    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transaction->delete();

        return response()->json(['message' => 'Transaction deleted successfully'], 200);
    }

}
