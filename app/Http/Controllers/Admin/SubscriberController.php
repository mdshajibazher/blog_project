<?php

namespace App\Http\Controllers\Admin;

use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class SubscriberController extends Controller
{
    public function index(){
        $subscribers = Subscriber::latest()->get();
        return view('admin.subscribers.index',compact('subscribers'));
    }

    public function destroy($id){
        $subscribers = Subscriber::find($id);
        $subscribers->delete();
        Toastr::success('Subscriber Deleted SuccessFull', 'success');
        return redirect()->back();
    }
}
