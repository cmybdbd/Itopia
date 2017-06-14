<!--day room list
5.31 UI 1.0 
-->
@extends('layout.app')

@section('content')
   <div id="response"></div>
@endsection

@section('scripts')
    <script>
        $.ajax({
            url:'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxa6e10a805f012943&secret=8eab99771e7587f0ee615476964cf5c6',
            type: 'GET',
            async : false,
            success: function(reg){
                $('#response').text('success');
            },
            error: function (e){
                $('#response').text('failed');
            }
        });
    </script>
@endsection