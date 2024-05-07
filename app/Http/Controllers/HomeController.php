<?php

namespace App\Http\Controllers;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $notifications= auth()->user()->unreadNotifications;
        $inventoryItems = InventoryItem::all();
        
        return view('home',compact('inventoryItems','notifications'));
    }

    public function markNotification($id)
    {
           
        DB::table("notifications")->where('id',$id)->update(['read_at' => now()]);
        return response()->json(['Notifications deleted']);
    
    }


    public function markAllNotification()
    {

      auth()->user()->unreadNotifications->markAsRead();
        
        
      return response()->json(['All notifications deleted']);
    
    }

    
}
