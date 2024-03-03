<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'amount', 'type', 'transaction_type', 'transfer_to', 'sender_balance', 'receiver_balance'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactionType(){
        if($this->transaction_type == 'transfer'){
            if($this->transfer_to == auth()->id()){
                $sender = $this->user;
                return "Transfer By {$sender->email}";
            }
            $receiver = $this->receiver;
            if($receiver){
                return "Transfer to {$receiver->email}";
            }
        }else{
            return ucfirst($this->transaction_type);
        }
    }

    public function type(){
        if($this->transfer_to == auth()->id()){
           return 'Credit';
        }else{
            return ucfirst($this->type);
        }
    }

    public function receiver()
    {
        return $this->hasOne(User::class, 'id', 'transfer_to');
    }

    public function balance(){
        if($this->transfer_to == auth()->id()){
            return number_format($this->receiver_balance, 2);
        }
        return number_format($this->sender_balance, 2);
    }
}
