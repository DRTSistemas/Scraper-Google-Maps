<?php

namespace App\Observers;

use App\Transaction;
use App\Http\Controllers\Admin\AdminController;

class TransactionObserver
{
    
    /**
     * Handle the transaction "updated" event.
     *
     * @param  \App\Transaction  $transaction
     * @return void
     */
    public function updated(Transaction $transaction)
    {
        
    }
}
