@extends('layout.app')
@section('content')
        <div class="font-b" style="position:fixed;background-color:#eeeeee;width:100%;height: 44px;margin:0;display:flex;align-items: center;justify-content: center">订单后台</div>
       
        <div>
            <div id="date" class="input-group date" style="z-index:100;position:fixed;float:left; padding-right:2em;top:90px;">
                <p class="input-group-addon" style="z-index:100;position: absolute;opacity:0">
                    <span style="opacity: 0;">12-31</span>
                </p>
                <input type="text" style="width:4em" id="time" value="时间">
            </div>
             <div class="mybtn-group" style="position:fixed;z-index:0;top:44px;height:44px;background-color:white;">
            <div class="nav-button" data-content="all" style="width:25%;height:44px;">
                <span class="room" style="margin-top: 1vh">全部</span>
            </div>
            
            <div class="user nav-button" data-content="zgy" style="width:25%;height:44px;">
                <span class="room" style="margin-top: 2vh">中关园</span>
                <div id="triangle-down-b" style="position:absolute;right:14%;top:52%;"></div>
                <div class="user-nav">
                    <ul style="padding-left:0px; top:0px;">
                        <li data-content="ae50f8da-225e-11e7-b33a-00163e028324"><a class="room font-xl m-color"href="#">A01</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li data-content="ae50f8da-225e-11e7-b33b-00163e028924"><a class="room font-xl m-color"href="#">A02</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li data-content="ae50f8da-225e-11e7-b33c-00163e028324"><a class="room font-xl m-color"href="#">A03</a></li>
                    </ul>
                </div>
            </div>
            <div class="user nav-button" data-content="frl" style="width:25%;height:44px;">
                <span class="room" style="margin-top: 2vh">芙蓉里</span>
                <div id="triangle-down-b" style="position:absolute;right:13%;top:52%;"></div>
                <div class="user-nav">
                    <ul style="padding-left:0px; top:0px;">
                        <li data-content="ae50f8da-225e-11e7-a09c-01163e028801"><a class="room font-xl m-color"href="#">A01</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li data-content="ae50f8da-225e-11e7-a09c-02163e028801"><a class="room font-xl m-color"href="#">A02</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li data-content="ae50f8da-225e-11e7-a09c-03163e028801"><a class="room font-xl m-color"href="#">A03</a></li>
                    </ul>
                </div>
            </div>
            <div class="user nav-button" data-content="dhzy" style="width:25%;height:44px;">
                <span class="room" style="margin-top: 2vh">大河庄苑</span>
                <div id="triangle-down-b" style="position:absolute;right:12%;top:52%;"></div>
                <div class="user-nav">
                    <ul style="padding-left:0px; top:0px;">
                        <li data-content="ae50f8da-225e-11e7-b09c-01163e028206"><a class="room font-xl m-color"href="#">B01</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li data-content="ae50f8da-225e-11e7-b09c-02163e028206"><a class="room font-xl m-color"href="#">B02</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li data-content="ae50f8da-225e-11e7-b09c-03163e028206"><a class="room font-xl m-color"href="#">B03</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li data-content="ae50f8da-225e-11e7-b09c-04163e028206"><a class="room font-xl m-color"href="#">B04</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!--
           <ul class="nav nav-pills" roll="tablist">
                <li role="presentation" class="active" data-content="all">
                    <a href="" aria-controls="" role="tablist" class="room"
                       data-toggle="pill">
                        全部
                    </a>
                </li>
                @foreach($rooms as $key => $room)
                    <li role="presentation"  data-content="{{$room->id}}">
                        <a href="" aria-controls="" role="tablist" class="room"
                           data-toggle="pill">
                            {{$room->title}}
                        </a>
                    </li>
                @endforeach
            </ul>
        -->
        </div>
        <div style="position:fixed;float:left; padding-right:2em;top:120px;z-index:0;">
            <ul class="nav" style="width:70px; position: absolute;" roll="side">
                <li role="presentation" class="active time" id="dandn">
                    <a href="" aria-controls="" role="tab"
                       data-toggle="pill">
                        全部
                    </a>
                </li>
                <li role="presentation" class="time" id="day">
                    <a href="" aria-controls="" role="tab"
                       data-toggle="pill">
                        分时
                    </a>
                </li>
                <li role="presentation" class="time" id="night">
                    <a href="" aria-controls="" role="tab"
                       data-toggle="pill">
                        包夜
                    </a>
                </li>
            </ul>
        </div>
        <div style="margin-left:70px;border-left:1px solid #aaa;">
            <div style="width:1px;height:88px;"></div>
            @foreach($orders as $key => $order)
                <div id="{{$order->id}}" roomId="{{$order->roomId}}"
                     type="{{$order->isDay? 'day':'night'}}"
                 class="mybox order" style="box-shadow:none;">
                    <div>
                        <span class="font-b">{{$order->hasUser['phonenumber']}}</span>
                    </div>
                    <div>
                        <span>微信昵称：</span><span>{{base64_decode($order->hasUser['nickname'])}}</span>
                    </div>
                    <div>
                        <span>身份证：</span><span>{{$order->hasUser['idnumber']}}</span>
                    </div>
                    <div>
                        <span>房间：</span><span>{{$order->hasRoom->title}}</span>
                        <span>预约时间：</span><span id="startTime">{{$order->startTime}}</span>
                    </div>
                    <div>
                        <span>时长：</span><span>{{$order->duration}}小时</span>
                        <span>支付状态：</span>
                        <?php
                        switch ($order->state)
                        {
                        case 1:
                          $s = "已失效";
                          break;
                        case 2:
                          $s = "已评论";
                          break;
                        case 3:
                          $s = "已完成";
                          break;
                        case 4:
                          $s = "未支付";
                          break;
                        case 5:
                          $s = "未使用";
                          break;
                        case 6:
                          $s = "使用中";
                          break;
                        case 10:
                          $s = "已结束";
                          break;
                        case 11:
                          $s = "已打扫";
                          break;
                        default:
                          $s = "什么鬼";
                        }
                        ?>
                    {{$s}}
                    </div>
                    <div>
                        <span>密码：</span><span>{{$order->passwd}}</span>
                    </div>
                    <hr class="mysplit">
                </div>

            @endforeach
        </div>
@endsection
@section('style')
    <style>
    .hideRoom{
        display: none;
    }
        .hideTime{
            opacity: 0;
            position: absolute;
        }
        .hideDate{
            visibility: hidden;
            position:absolute;
            top: -10em;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{url('js/moment.min.js')}}"></script>
    <script src="{{url('js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        $(function(){
            $("#date").datetimepicker({
                    format: 'MM-DD'
                }
            );
            $("#date").on("dp.change",function(){
                console.log($("#time").val());
                time = $("#time").val();
                list = $(".order");
                list.removeClass('hideDate');
                for (i=0;i<list.length;i++)
                {
                    console.log(new RegExp(time,'g'));
                    if(!$(list[i]).find("#startTime").text().match(new RegExp(time,'g')))
                    {
                        console.log(i);
                        $(list[i]).addClass('hideDate');
                    }
                }

            })

            $(".room").click(function(){
                console.log('click room');

                $(".room").removeClass('active');
                $(this).addClass('active');

                $(".order").addClass('hideRoom');
                console.log($(this).parent().attr('data-content') );
                if($(this).parent().attr('data-content') != 'all')
                    $(".order[roomId='"+$(this).parent().attr("data-content")+"']").removeClass('hideRoom');
                else
                {
                    $(".order").removeClass('hideRoom');
                }
            })
            $("#day").click(function () {
                $(".order").addClass('hideTime');
                $(".order[type='day']").removeClass('hideTime');
            })
            $("#night").click(function () {
                $(".order").addClass('hideTime');
                $(".order[type='night']").removeClass('hideTime');
            })
            $("#dandn").click(function () {
                $(".order").removeClass('hideTime');
            })
        })
    </script>
@endsection
