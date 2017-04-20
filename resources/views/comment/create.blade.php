@extends('layout.app')
@section('style')
    <link rel="stylesheet" href="{{url('css/starrr.css')}}">
    <style>
        .starrr  a{
            font-size:4em;
            color: var(--main-color);
        }
    </style>
@endsection
@section('content')
    <div>
        <div class="mybox">
            <div class="flex-center m-color font-b">
                感谢主人使用ITOPIA空间
            </div>
            <hr class="mysplit">
            <div class="flex-center b-color">
            希望主人能留下对ITopia的意见建议(*￣︶￣*)
            </div>
            <div class="flex-center b-color">
            填写就有机会获得小@送出的多小时免费体验哦
            </div>
            <div class="flex-center">
                <div class="starrr"></div>
            </div>
            <textarea class="form-control custom-textarea" name="" id="" cols="30" rows="6"></textarea>
        </div>
        <div class="lr">
            <button id="commit" class="btn btn-block btn-cancel m-color font-b">提 交</button>
            <button id="return" class="btn btn-block btn-default font-b">返 回</button>
        </div>
    </div>
    <div id="param">
        <div id="userId" data-content="{{\Illuminate\Support\Facades\Auth::user()->id}}"></div>
        <div id="orderId" data-content="{{$oid}}"></div>
    </div>
@endsection
@section('scripts')
    <script src="{{url('/js/starrr.js')}}"></script>
    <script>
        $(function () {
            var starNum = 0;
            $('.starrr').starrr({
                change: function(e, value){
                    starNum = value;
                    console.log(starNum);
                }
            });
            $("#commit").on('click', function () {
                $.ajax({
                    url: 'create',
                    data: {
                        _token:$("meta[name='csrf-token']").attr('content'),
                        'userId': $("#userId").attr("data-content"),
                        'orderId': $("#orderId").attr('data-content'),
                        'starNum': starNum,
                        'text': $("textarea").val()
                    },
                    type: 'POST',
                    success:function (res) {
                        console.log(res);
                        if(res.code == 200)
                        {
                            window.location.href = window.location.href.replace(
                                /comment.*/,
                                'commentResult'
                            );
                        }
                    }
                });

            });
            $("#return").on("click",function () {
                window.location.href = window.location.href.replace(
                    /comment.*/,
                    'home'
                );
            });
        });


    </script>
@endsection