<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index(Request $request)
    {
        // TODO: fetch fields data from database when available
        return view('admin.fields.index');
    }
}


