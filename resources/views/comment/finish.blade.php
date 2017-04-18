@extends('layout.app')
@section('style')
    <style>
        .center div{
            width: 84%;
            margin-left: 8%;
            text-align: center;
        }
    </style>
@endsection
@section('content')
    <div class="center">
        <div class="font-b"
             style="margin-top: 1em;height: 2em;display:flex;align-items: center;justify-content: center">使用结束</div>
        <hr class="mysplit-color">
        <div class="font-b m-color">
            <div style="margin-top: 3em">
                <img src="{{asset('storage/check.png')}}" width="50px" >
            </div>
            提交成功
        </div>
        <br>
        <div class="b-color">
            感谢主人的意见建议, 小i一定会积极改进,期待与您的再会！（如获得免费体验机会, 小i将以短信形式通知您）
        </div>
        <br>
        <div>
            <button class="btn btn-block btn-default" id="return">返回首页</button>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
    $("#return").on('click',function () {
        window.location.href = window.location.href.replace('commentResult', 'home');
    })
    </script>
@endsection
