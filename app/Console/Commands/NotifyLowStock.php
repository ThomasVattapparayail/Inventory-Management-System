<?php

namespace App\Console\Commands;

use App\Mail\AlertMail;
use Illuminate\Console\Command;
use App\Models\InventoryItem;
use App\Models\User;
use App\Notifications\LowStock;
use App\Notifications\LowStockNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class NotifyLowStock extends Command
{
    protected $signature = 'notify:low-stock';

    protected $description = 'Notify users about low stock items';

    public function handle()
    {
        $threshold = 10;

        $lowStockItems = InventoryItem::where('quantity', '<', $threshold)->get();

        foreach ($lowStockItems as $item) {
            $admin=User::where('id',$item->user_id)->first(); 
            Notification::send($admin, new LowStockNotification($item));
            //$this->sendNotification($item);
            
        }
        

        $this->info('Low stock notification sent successfully.');

    }

    private function sendNotification($item)
    {
        
        $user = User::where('id',$item->user_id)->first();
        $userEmail=$user->email;
        $itemName = $item->name;
        $quantity = $item->quantity;

        Mail::to($userEmail)->send(new AlertMail($itemName,$quantity));   

    }
}
