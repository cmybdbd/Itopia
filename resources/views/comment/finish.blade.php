<!--comment create page
5.31 UI 1.0 done
-->
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
             style="background-color:#eeeeee;width:100%;height: 44px;margin:0;display:flex;align-items: center;justify-content: center">提交成功</div>
        <!--<hr class="mysplit-color"-->
        <div class="font-b m-color">
            <div style="margin-top: 3em">
                <img src="{{asset('storage/check.png')}}" width="100px"
            </div>
        </div>
        <br>
        <div class="font-l b-color">
            <br>
            感谢主人为蜗壳空间留下的建议<br>
            待我们改进后，会联系主人免费体验哦！
            <br><br>
        </div>
        <br>
            <button class="btn btn-block btn-default btn-main" id="return">返回首页</button>
    </div>
@endsection
@section('scripts')
    <script>
    $("#return").on('click',function () {
        window.location.href = window.location.href.replace('commentResult', 'home');
    })
    </script>
@endsection
