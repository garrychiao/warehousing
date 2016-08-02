<?php

namespace App\Console;

use App\ProformaInvoice;
use App\ProformaInvoiceInventory;
use App\Inventory;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /*$schedule->call(function () {
          //update to preserved quantity
          $proforma_id = ProformaInvoice::select('id')->where([
              ['converted', '<>' ,true],
              ['due_date', '=', date("Y-m-d")],
            ])->get();
          foreach($proforma_id as $pro_id){
            $pro_inv = ProformaInvoiceInventory::select('inventory_id','quantity')->where('proforma_invoice_id', '=', $pro_id->id)->get();
            foreach ($pro_inv as $inv) {
              $inventory = Inventory::find($inv->inventory_id);
              $final_inventory = $inventory->preserved_inv-$inv->quantity;
              $inventory->update([
                  'preserved_inv' => $final_inventory
              ]);
            }
          }
        })->hourly();
        */
    }
}
