@extends('layout.app')
@section('content')
    <div>
        <div>
            订单后台页
        </div>
        <div>
            <ul>
                <li>全部</li>
                <li>白天</li>
                <li>包夜</li>
            </ul>
        </div>
        <div>
            <div id="date">

            </div>
            <ul>
                <li>全部</li>
                @foreach($rooms as $key => $room)
                    <button>
                        {{$room->title}}
                    </button>
                @endforeach
            </ul>
        </div>
        <div>
            @foreach($orders as $key => $order)
                <div class="order_{{$key}}">
                    <div></div>
                    <div>
                        <span>微信号：</span><span>{{$order->hasUser->openid}}</span>
                    </div>
                    <div>
                        <span>身份证：</span><span>{{$order->hasUser->idnumber}}</span>
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
                        <span>密码状态：</span><span></span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
