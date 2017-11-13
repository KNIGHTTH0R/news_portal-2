<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class IndexController extends Controller
{
    public function index()
    {

        return view('admin.index', ['title' => 'Admin panel']);
    }
}
