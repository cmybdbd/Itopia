@extends('layout.app')

@section('style')
    <style>
        .pwd-group{
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 6px #dddddd;
            padding-top: 0.5em;
            padding-bottom: 0.5em;
            margin: 0.6em;
        }
        .pwd-group div{
            border: none;
            background: transparent;
            position: relative;
            text-align: center;
            margin: 0 0 0 0;
            padding: 0;
            width: 16%;
            height: 100%;
            float: left;
        }
        .pwd-group div::after{
            position: absolute;
            content: "";
            right: -1px;
            width: 1px;
            height: 100%;
            background-image: -webkit-gradient(linear,0 0, 0 100% ,from(transparent), to(transparent),color-stop(20%, var(--used-color)) , color-stop(80%, var(--used-color)));
        }
        .pwd-group div:last-child::after{
            content:"";
            width: 0px;
        }
    

    </style>
@endsection
@section('content')
    <div class="mybox">
        <div class="f-color font-b">
            主人的私人空间地址
        </div>
        <div class="b-color">
            地址：{{$order->hasRoom->address}}
        </div>
        <div class="myrow" style="margin-bottom: 1vh;display:block;text-align:center" >
            <img src="{{asset('storage/arch.jpg')}}" style="width: 100%" >
        </div>

    </div>
    <div style="margin:3vw">
        <div class="m-color font-m">
        <div class="gatepwd">
            <div >大门密码</div>
            <div class="pwd-group font-b">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="roompwd">
            <div>
                房间密码
            </div>
            <div class="pwd-group font-b">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        </div>
        <div class="b-color">
            <div class="f-color">
                温馨提示
            </div>
            <div>私人空间密码仅在主人使用时段有效哦～</div>
            <div>主人要爱惜空间，尽量保持安静哦！</div>
            <div class="mybox" id="countDown">
                使用计时
                <span class="cd m-color" style="float:right;"></span>
            </div>
        </div>
    </div>
    <div style="width:100%;box-shadow:0 -1px 6px #eeeeee ">
        <div class="mybtn-group">
            <button class="btn btn-default" id="report">遇到问题</button>
            <button class="btn btn-default m-color" id="finish">结束使用</button>

        </div>
    </div>
    <div id="param">
        <div id="oid" data-content="{{$order->id}}"></div>
        <div id="passwd" data-content="{{$order->passwd}}"></div>
        <div id="startTime" data-content="{{strtotime($order->startTime)}}"></div>
        <div id="endTime" data-content="{{strtotime($order->endTime)}}"></div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {


            var gatepwd = $(".gatepwd>.pwd-group");
            var roompwd = $(".roompwd>.pwd-group");
            var passwd = $("#passwd").attr("data-content");
            for (i = 0; i < 6; i++) {
                $(gatepwd.children()[i]).text(i);
                $(roompwd.children()[i]).text(passwd[i]);
            }
            $("#finish").on('click', function () {
                $.ajax({
                    url:'/order/complete',
                    type: 'POST',
                    data: {
                        _token: $("meta[name='csrf-token']").attr('content'),
                        oid:  $("#oid").attr('data-content')
                    },
                    success:function(){
                        window.location.href = window.location.href.replace(
                            /result/,
                            'comment'
                        )
                    }
                });
                /*

                */
            });
            var wait = -(+$("#startTime").attr("data-content")*1000- (new Date().getTime()));
            console.log(wait);
            function time(o, w) {
                if(w <= 0)
                {
                    o.text("00:00:00");
                    setTimeout(function () {
                            time(o,w)
                        },
                        1000)
                }
                else
                {
                    o.text(((w/(60*60*1000))|0 )+ ':' + (((w%(60*60*1000))/(60*1000))|0) + ':' + ((w %(60*1000))/1000|0));
                        //dateFormat(w, 'HH:MM:ss'));
                    w += 1000;
                    setTimeout(function () {
                            time(o,w)
                        },
                        1000)
                }
            }
            if($("#endTime").attr('data-content')*1000 <= (new Date().getTime()))
            {
                $("#countDown > span").text('已结束');
            }
            else
            {
                time($("#countDown > span"),wait);
            }
        });

    </script>

@endsection