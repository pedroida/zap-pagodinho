<?php

namespace App\Http\Controllers;

class ChatsController extends Controller
{
    public function index()
    {
        return view('chats.index');
    }
}