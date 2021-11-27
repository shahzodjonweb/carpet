<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;
use App\admin;
class check extends Model
{
    //
    public  function credit(){
        return $this->belongsTo(credit::class);
        }
    
    public static function getreciept($productname,$price){
        $data=admin::all()->first();
          // Set params
          $INN = $data->inn_number;
          $store_name = $data->name;
          $store_address = $data->address;
          $store_phone = '1234567890';
          $store_email = 'yourmart@email.com';
          $store_website = 'yourmart.com';
          $tax_percentage = 12;
          $transaction_id = $data->nds_number;
          $productname = $productname;
          $price = $price;
          
          
          // Init printer
          $printer = new ReceiptPrinter;
          $printer->init(
              config('receiptprinter.connector_type'),
              config('receiptprinter.connector_descriptor')
          );
          
          // Set store info
          $printer->setStore($INN, $store_name, $store_address, $store_phone, $store_email, $store_website,$productname,$price);
          
       
          // Set tax
          $printer->setTax($tax_percentage);
          
          // Calculate total
          $printer->calculateSubTotal();
          $printer->calculateGrandTotal();
          
          // Set transaction ID
          $printer->setTransactionID($transaction_id);
          
          // Set qr code
          $printer->setQRcode([
              'tid' => $transaction_id,
          ]);
          
          // Print receipt
          $printer->printReceipt();
    }
}
