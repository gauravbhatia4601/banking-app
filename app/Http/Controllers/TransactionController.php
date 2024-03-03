<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function deposit(Request $request)
    {
        try {
            if ($request->isMethod('get')) {
                return view('dashboard.deposit');
            }
            // 1. Validate the amount
            $request->validate([
                'amount' => 'required|numeric|min:0.01', // Ensure positive amount
            ]);

            // 2. Get the current user
            $user = auth()->user();

            if (empty($user)) {
                return redirect()->back()->withErrors(['error', 'User not found!!']);
            }

            // 3. Use a transaction to ensure data consistency
            DB::transaction(function () use ($user, $request) {
                $user->accountBalance->increment('balance', $request->amount);

                //create transaction record for statements
                Transaction::create([
                    'user_id' => $user->id,
                    'type' => 'credit',
                    'transaction_type' => 'deposit',
                    'amount' => $request->amount,
                    'sender_balance' => $user->accountBalance->balance
                ]);
            });

            return redirect()->back()->with('success', "Successfull deposited INR {$request->amount}");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function withdraw(Request $request)
    {
        try {
            if ($request->isMethod('get')) {
                return view('dashboard.withdraw');
            }

            // 1. Validate the amount
            $request->validate([
                'amount' => 'required|numeric|min:0.01', // Ensure positive amount
            ]);

            // 2. Get the current user
            $user = auth()->user();

            if (empty($user)) {
                return redirect()->back()->withErrors(['error', 'User not found!!']);
            }

            // 3. Use a transaction with retries for potential network issues
            DB::transaction(function () use ($user, $request) {
                if ($user->accountBalance->balance < $request->amount) {
                    \Log::info('Insufficient funds');
                    throw new \Exception('Insufficient funds');
                }
                $user->accountBalance->decrement('balance', $request->amount);
                //create transaction record for statements
                Transaction::create([
                    'user_id' => $user->id,
                    'type' => 'debit',
                    'transaction_type' => 'withdraw',
                    'amount' => $request->amount,
                    'sender_balance' => $user->accountBalance->balance
                ]);
            }, 5); // Set maximum attempts for transaction retries

            return redirect()->back()->with('success', "Successfull withdrawal INR {$request->amount}");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function transfer(Request $request)
    {
        try {
            //if request is get return the form
            if ($request->isMethod('get')) {
                return view('dashboard.transfer');
            }

            // 1. Validate the amount and email

            $request->validate([
                'receiver_email' => 'required|email|exists:users,email', // Check if email exists in users table
                'amount' => 'required|numeric|min:0.01',
            ]);

            // 2. Get the current user and find the receiver
            $user = auth()->user();
            if ($user->email === $request->receiver_email) {
                return redirect()->back()->with('info', 'You cannot transfer money to your own account.');
            }

            $receiver = User::where('email', $request->receiver_email)->first();

            if (!$receiver) {
                return redirect()->back()->withErrors(['error', 'Receiver not found!!']);
            }

            // 3. Use a transaction with retries for potential network issues
            DB::transaction(function () use ($user, $receiver, $request) {
                if ($user->accountBalance->balance < $request->amount) {
                    throw new \Exception('Insufficient funds');
                }

                $user->accountBalance->decrement('balance', $request->amount);
                $receiver->accountBalance->increment('balance', $request->amount);

                //create transaction record for statements
                Transaction::create([
                    'user_id' => $user->id,
                    'type' => 'debit',
                    'transaction_type' => 'transfer',
                    'amount' => $request->amount,
                    'transfer_to' => $receiver->id,
                    'sender_balance' => $user->accountBalance->balance,
                    'receiver_balance' => $receiver->accountBalance->balance
                ]);

            }, 5); // Set maximum attempts for transaction retries

            return redirect()->back()->with('success', "Successfull Transfered INR {$request->amount}");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function fetchStatements(Request $request, $perPage = 10)
    {
        try {
            $user = auth()->user(); // Get the authenticated user
    
            $transactions = $user->transactions()
                ->orWhere('transfer_to', $user->id)
                ->orderBy('created_at', 'asc') // Order by creation date, newest first
                ->paginate($perPage); // Apply pagination with per page limit
    
            return view('dashboard.statement',['transactions' => $transactions]); // Return the paginated collection of transactions
        } catch (\Exception $e) {
            // Handle potential errors during user retrieval or transaction fetching
            \Log::error('Error fetching user transactions: ' . $e->getMessage());
            echo $e->getMessage();
            return null; // Or return an appropriate error response
        }
    }

}