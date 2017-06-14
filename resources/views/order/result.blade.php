@extends('layout.app')

@section('style')
    <style>
        .pwd-group{
            position: absolute;
            left:26%;
            width:70%;
            display: flex;
            align-items: center;
            justify-content: center;
            border:1px solid #1dccb8;
            border-radius: 4px;
            padding-top: 4px;
            padding-bottom: 4px;
        }
        .pwd-group div{
            border: none;
            background: transparent;
            position: relative;
            text-align: center;
            margin: 0 0 0 0;
            padding: 0;
            width: 16.5%;
            height: 100%;
            float: left;
        }
        .pwd-group div::after{
            position: absolute;
            content: "";
            right: -1px;
            width: 1px;
            height: 100%;
            /*background-image: -webkit-gradient(linear,0 0, 0 100% ,from(transparent), to(transparent),color-stop(20%, var(--used-color)) , color-stop(80%, var(--used-color)));*/
            background-image: -webkit-gradient(linear,0 0, 100% 0 ,from(transparent), to(transparent),color-stop(20%,  #eee) , color-stop(80%,  #eee));
        }
        .pwd-group div:last-child::after{
            content:"";
            width: 0px;
        }
        .newbtn-group{
            width: 100%;
            height: 2em;
        }
        .newbtn-group button{
            border: none;
            background: transparent;
            cursor: pointer;
            position: relative;
            margin: 0 0 0 0;
            padding: 0;
            width: 50%;
            height: 100%;
            float: left;

            display: -webkit-flex;
            -webkit-flex-direction:column;
            -webkit-justify-content: center;
            -webkit-align-items: center;
            -webkit-box-flex: 1;
            display: flex;
            flex-direction:column;
            justify-content: center;
            align-items: center;
        }
        .newbtn-group button:first-child::after{
            position: absolute;
            content: "";
            top: 8%;
            right: -1px;
            width: 1px;
            height: 84%;
            /*background-image: -webkit-gradient(linear,0 0, 0 100% ,from(transparent), to(transparent),color-stop(20%, var(--main-color)) , color-stop(80%, var(--main-color)));*/
            background-image: -webkit-gradient(linear,0 0, 100% 0 ,from(transparent), to(transparent),color-stop(20%,  #1dccb8) , color-stop(80%,  #1dccb8));
        }
        .xTimer{
            width: 84%;
            position:absolute;
            text-align: center;
            top:240px;
            margin: 20px 8% 20px 8%;
            padding-top: 10px;
            padding-bottom: 10px;
            background:rgba(0,0,0,0.4);
            box-shadow:none;
        }
    </style>
@endsection
@section('content')
    <div class="center">
        <div class="font-b"
             style="background-color:#eeeeee;width:100%;height: 44px;margin:0;display:flex;align-items: center;justify-content: center">使用空间</div>
        <div class="mybox" style="box-shadow:none;">
        <div class="f-color font-xl">
            {{$order->hasRoom->title}}
        </div>
        <div class="b-color">
            地址：{{$order->hasRoom->address}}
            <span id="openLocation" class="m-color">
            开启导航
        </span>
        </div>
        
        <!--<div id="container" style="width:500px; height:300px"></div>-->
        <div class="myrow"  id="slide" style="margin-bottom: 1vh;margin-left:auto;margin-right:auto;display:block;text-align:center;width:auto;height: 200px;overflow:hidden;visibility:hidden;position:relative;top:0px;left:0px;" >
            <div data-u="slides" style="width: 325px;height: 200px; overflow:hidden;position:relative;top:0px;left:0px;">
                <div>
                    <img src="{{asset('storage/map/'.$order->hasRoom->parentId.'.jpg')}}" data-u="image" alt="" width="325px">
                </div>
                <div>
                    <img src="{{asset('storage/map/'.$order->hasRoom->parentId.'-2.jpg')}}" data-u="image" alt="" width="325px">
                </div>
                @if($order->hasRoom->parentId=='dhz9')
                    <img src="{{asset('storage/map/'.$order->hasRoom->parentId.'-3.jpg')}}" data-u="image" alt="" width="325px">
                @endif
            </div>
        </div>
    </div>
<div class="xTimer font-xl w-color" id="countDown">
                使用计时&nbsp;&nbsp;&nbsp;
                <span class="cd font-xl"></span>
            </div>
    <div style="margin:3vw">
        
        <hr class="mysplit">

        <div class="gatepwd f-color font-xl" style="margin-bottom:24px;">
            <div style="margin-top:24px;">大门密码</div>
            <div class="pwd-group font-b m-color" style="top:355px;">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        
        <hr class="mysplit">
        <div class="roompwd f-color font-xl"style="margin-bottom:24px;">
            <div style="margin-top:24px;" >房间密码</div>
            <div class="pwd-group font-b m-color" style="top:432px;">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>

        <hr class="mysplit">
        <div class="b-color">
            <div class="f-color font-xl">
                温馨提示
            </div>
            <div class="mybox" style="box-shadow:none;">
                <div>私人空间密码仅在主人使用时段有效哦～</div>
                <div>主人要爱惜空间，尽量保持安静哦！</div>
                <div>蜗壳空间是无烟空间哦，请主人不要在屋内吸烟</div>
            </div>
        </div>
    </div>
    <div style="width:100%;height:56px;text-align:center;">
        <div class="btn btn-default btn-main-secondary-2" id="report">遇到问题</div>
        <div class="btn btn-default btn-main-2" id="confirmFinish">返回首页</div>
    </div>
</div>


    <div class="modal fade bs-example-modal-sm confirm-content" role="dialog" style="">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div style="width: 70vw">
                        <div>
                            <div style="text-align:center">
                                <p>继续订下一单？</p>
                            </div>
                            <hr class="mysplit">
                            <div class="newbtn-group">
                                <button class="btn btn-default m-color"  data-dismiss="modal">否</button>
                                <button class="btn btn-default m-color" id="confirmFinish">是</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div id="param">
        <div id="oid" data-content="{{$order->id}}"></div>
        <div id="gatepass" data-content="{{$gatepass}}"></div>
        <div id="passwd" data-content="{{$order->passwd}}"></div>
        <div id="startTime" data-content="{{strtotime($order->startTime)}}"></div>
        <div id="endTime" data-content="{{strtotime($order->endTime)}}"></div>
    </div>
@endsection
@section('scripts')
    <script src="{{url('js/jssor.slider.min.js')}}"></script>
    <script>
        $(function() {
            var jssor_1_SlideshowTransitions = [
                {
                    $Duration:1000,
                    x:-0.3,
                    $During:{$Left:[0.3,0.7]},
                    $Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},
                    $Opacity:0
                },
                {
                    $Duration:1000,
                    x:0.3,
                    $SlideOut:true,
                    $Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},
                    $Opacity:0
                }
            ];

            var jssor_1_options = {
                $AutoPlay: 1
            };
            var jssor_slider = [];
                jssor_slider= new $JssorSlider$("slide", jssor_1_options);

            // var jssor_2_slider = new $JssorSlider$("jssor_2", jssor_1_options);

            /*responsive code begin*/
            /*remove responsive code if you don't want the slider scales while window resizing*/
            function ScaleSlider() {
                var uload = false;
                    var refwidth = jssor_slider.$Elmt.parentNode.clientWidth;
                    var refheight = jssor_slider.$Elmt.parentNode.clientHeight;
                    if (refwidth) {
                        if(refheight / refwidth > 1)
                        {
                            jssor_slider.$ScaleHeight(Math.min(refheight,200));
                        }
                        else
                        {
                            jssor_slider.$ScaleWidth(Math.min(refwidth,300));
                        }
                    }
                    else {
                        uload =true;
                    }
                if(uload)
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();
            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);

            var gatepwd = $(".gatepwd>.pwd-group");
            var roompwd = $(".roompwd>.pwd-group");
            var gatepass =$("#gatepass").attr("data-content");
            var passwd = $("#passwd").attr("data-content");
            for (i = 0; i < 6; i++) {
                $(gatepwd.children()[i]).text(gatepass[i]);
                $(roompwd.children()[i]).text(passwd[i]);
            }
            $("#finish").on('click',function(){
                if($("#startTime").attr('data-content')*1000 > (new Date().getTime()))
                {
                    return;
                }
                $(".confirm-content").modal();
            })

            $("#confirmFinish").on('click', function () {
                window.location.href = '/home';
/*
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
  */              
            });
            var wait = -(+$("#startTime").attr("data-content")*1000- (new Date().getTime()));
            console.log(wait);
            var finish = $("#finish");
            function time(o, w) {
                if(w <= 0)
                {
                    if(!finish.hasClass('disabled'))
                    {
                        finish.addClass('disabled');
                    }
                    o.text("00:00:00");2
                    setTimeout(function () {
                            time(o,w)
                        },
                        1000)
                    /*$.ajax({
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
                });*/
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
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    wx.config(<?php echo $js->config(array('onMenuShareQQ', 'onMenuShareWeibo','openLocation','getLocation'), true) ?>);
    
    wx.ready(function(){
        alert('{{$order->hasRoom->latitude}}');
        alert('{{$order->hasRoom->longitude}}');
    console.log('成功调用');
    document.querySelector('#openLocation').onclick = function () {
      wx.openLocation({
        latitude: '{{$order->hasRoom->latitude}}',
        longitude: '{{$order->hasRoom->longitude}}',
        name: '蜗壳空间',
        address: '{{$order->hasRoom->address}}',
        scale: 14,
        infoUrl: '/'
      });
    };

      /*wx.getLocation({
        success: function (res) {
          console.log(JSON.stringify(res));
        },
        cancel: function (res) {
          console.log('用户拒绝');
        }
      });*/
  });

  wx.error(function(res){
        // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
        console.log(res);
    });
</script>

@endsection