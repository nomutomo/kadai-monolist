<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User; //追加

use App\Item; //追加

class UsersController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $count_want = $user->want_items()->count();
        $count_have = $user->have_items()->count();
        //SQLを書いているのは、postgre(heroku)では$user->items()->distinct()が使えなかったため
        $items = \DB::table('items')->join('item_user', 'items.id', '=', 'item_user.item_id')->select('items.*')->where('item_user.user_id', $user->id)->distinct()->paginate(6);

        return view('users.show', [
            'user' => $user,
            'items' => $items,
            'count_want' => $count_want,
            'count_have' => $count_have,
        ]);
    }
}
