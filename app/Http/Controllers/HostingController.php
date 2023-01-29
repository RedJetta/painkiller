<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class HostingController extends Controller
{
    public function optimize()
    {
        Artisan::call('optimize');
        return "Artisan optimized";
    }
}
