<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Item;

class WelcomeController extends Controller
{
    public function index()
    {
        //トップページ表示（保存したitemを表示）
        $items = Item::orderBy('updated_at', 'desc')->paginate(3);
        return view('welcome', [
            'items' => $items,
        ]);
    }
}
