<?php

namespace App\Http\Controllers;

use App\Channel;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    public function store(Channel $channel)
    {
        auth()->user()->toggleSubscription($channel);
        return back();
    }
}
