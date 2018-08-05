<!--
フォームの中に隠された入力データとして、 $item->code があります。
これは先ほどの Controller の実装のところで出た request()->itemCode 
として取得されます。商品の itemCode がわからないと、どの商品が Want 
されたのかわかりません。そのため、 hidden() として itemCode を渡して
います。
-->

@if (Auth::user()->is_wanting($item->code))
    {!! Form::open(['route' => 'item_user.dont_want', 'method' => 'delete']) !!}
        {!! Form::hidden('itemCode', $item->code) !!}
        {!! Form::submit('Want', ['class' => 'btn btn-success']) !!}
    {!! Form::close() !!}
@else
    {!! Form::open(['route' => 'item_user.want']) !!}
        {!! Form::hidden('itemCode', $item->code) !!}
        {!! Form::submit('Want it', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endif