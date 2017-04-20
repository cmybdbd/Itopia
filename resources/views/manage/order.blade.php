@extends('layout.app')
@section('content')
    <div>
        <div style="text-align:center">
            订单后台页
            <hr class="mysplit-color">
        </div>

        <div>
            <div id="date" class="input-group date" style="float:left; padding-right:2em;">
                <p class="input-group-addon" style="position: absolute;opacity:0">
                    <span style="opacity: 0;">12-31</span>
                </p>
                <input type="text" style="width:4em" value="{{date('mm-dd',time())}}">
            </div>
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
        </div>
        <div>
            <ul class="nav" style="width:4em; position: absolute;" roll="side">
                <li role="presentation" class="time" id="day">
                    <a href="" aria-controls="" role="tab"
                       data-toggle="pill">
                        白天
                    </a>
                </li>
                <li role="presentation" class="time" id="night">
                    <a href="" aria-controls="" role="tab"
                       data-toggle="pill">
                        包夜
                    </a>
                </li>
                <li role="presentation" class="active time" id="dandn">
                    <a href="" aria-controls="" role="tab"
                       data-toggle="pill">
                        全部
                    </a>
                </li>
            </ul>
        </div>
        <div style="margin-left : 6em;">
            @foreach($orders as $key => $order)
                <div id="{{$order->id}}" roomId="{{$order->roomId}}"
                     type="{{$order->isDay? 'day':'night'}}"
                 class="order">
                    <div>
                        <span>微信昵称：</span><span>{{base64_decode($order->hasUser['nickname'])}}</span>
                    </div>
                    <div>
                        <span>身份证：</span><span>{{$order->hasUser['idnumber']}}</span>
                    </div>
                    <div>
                        <span>房间：</span><span>{{$order->hasRoom->title}}</span>
                        <span>预约时间：</span><span>{{$order->startTime}}</span>
                    </div>
                    <div>
                        <span>时长：</span><span>{{$order->duration}}小时</span>
                        <span>支付状态：</span>{{$order->state > 2 ? '已支付':'未支付'}}
                    </div>
                    <div>
                        <span>密码：</span><span>{{$order->passwd}}</span>
                    </div>
                </div>
                <hr class="mysplit-color">
            @endforeach
        </div>
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
            $(".room").click(function(){
                console.log('click room');

                $(".room").removeClass('active');
                $(this).addClass('active');

                $(".order").addClass('hideRoom');
                console.log($(this).parent().attr('data-content') );
                if($(this).parent().attr('data-content') != 'all')
                    $(".order[roomId='"+$(this).parent().attr("data-content")+"'").removeClass('hideRoom');
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