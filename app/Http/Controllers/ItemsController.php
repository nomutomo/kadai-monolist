<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Item;

class ItemsController extends Controller
{    
    public function create()
    {
    //# 検索結果を保存するための機能
    
        $keyword = request()->keyword;
        $items = [];
        if ($keyword) {
            $client = new \RakutenRws_Client();
            $client->setApplicationId(env('RAKUTEN_APPLICATION_ID'));

            $rws_response = $client->execute('IchibaItemSearch', [
                'keyword' => $keyword,
                'imageFlag' => 1,
                'hits' => 20,
            ]);

            //# 扱い易いように Item としてインスタンスを作成する（保存はしない）
            //# 後ほど、自分のモノリストとして追加(Want, Have)されたときにだけ Item のインスタンスを保存します。
            foreach ($rws_response->getData()['Items'] as $rws_item) {
                $item = new Item();
                $item->code = $rws_item['Item']['itemCode'];
                $item->name = $rws_item['Item']['itemName'];
                $item->url = $rws_item['Item']['itemUrl'];
                //# 楽天APIの仕様上末尾についてくる、画像サイズの情報を削除する。
                $item->image_url = str_replace('?_ex=128x128', '', $rws_item['Item']['mediumImageUrls'][0]['imageUrl']);
                $items[] = $item;
            }
        }

        return view('items.create', [
            'keyword' => $keyword,
            'items' => $items,
        ]);
    }
    
    public function show($id)
    {
      $item = Item::find($id);
      $want_users = $item->want_users;

      return view('items.show', [
          'item' => $item,
          'want_users' => $want_users,
      ]);
    }
}
