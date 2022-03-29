<?php

namespace App\Imports;

use App\Models\Transaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
//use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TransactionsImport implements ToModel

{
    public $data;

    public $fee = 0.3;
    public $Withdraw_fee_business = 0.5;
    public $transaction_type = null;

    public function __construct()
    {

        function CalculateWithdraw($amount,$Withdraw_fee){

            return ($Withdraw_fee/100) * $amount;
        }
        function CheckTransactionType($value){
            if ($value=='withdraw'){
                $transaction_type = 'withdraw';
                $fee = 0.3;
            }
            if ($value=='deposit'){
                $transaction_type = 'deposit';
                $fee = 0.03;
            }

        }

        $this->data = collect();
    }
    /**
    * @param array $row
    *
    * @return Transaction
     */


    public function model(array $row)
    {
        return new Transaction([
            'date' => Carbon::parse($row[0]),
            'user_id' => $row[1],
            'user_type' => $row[2],
            'transaction_type' => $row[3],
//            'amount' => $row[4],
            'amount' => round(CalculateWithdraw($row[4],$this->fee),PHP_ROUND_HALF_UP),
            'currency' => $row[5],
        ]);
    }

}
