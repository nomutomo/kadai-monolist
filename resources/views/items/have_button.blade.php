<!--
フォームの中に隠された入力データとして、 $item->code があります。
これは先ほどの Controller の実装のところで出た request()->itemCode 
として取得されます。商品の itemCode がわからないと、どの商品が Have 
されたのかわかりません。そのため、 hidden() として itemCode を渡して
います。
-->

@if (Auth::user()->is_having($item->code))
    {!! Form::open(['route' => 'item_user.dont_have', 'method' => 'delete']) !!}
        {!! Form::hidden('itemCode', $item->code) !!}
        {!! Form::submit('Have', ['class' => 'btn btn-success']) !!}
    {!! Form::close() !!}
@else
    {!! Form::open(['route' => 'item_user.have']) !!}
        {!! Form::hidden('itemCode', $item->code) !!}
        {!! Form::submit('Have it', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endif