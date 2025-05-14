<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;   // ← Must import this

class Controller extends BaseController                     // ← Must extend this
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
