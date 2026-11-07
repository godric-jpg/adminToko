<?php

namespace App\Http\Controllers;

use App\Models\ComplaintType;
use Illuminate\Http\Request;

class ComplaintTypeController extends Controller
{
    public function index()
    {
        $types = ComplaintType::all();

        return response()->json([
            'status' => 'success',
            'data'   => $types
        ], 200);
    }
}