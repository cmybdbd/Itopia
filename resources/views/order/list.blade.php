
@extends('layout.app')
@section('style')
    <style>
        .center> div{
            width: 80%;
            margin-left: 10%;
            text-align: center;
        }
        .room-touse, .room-used{
            float:right;
            padding:0 0.5em;
            border: 1px solid;
            border-radius: 3px;
        }
        .room-touse{
            color: var(--main-color);
        }
        .room-used{
            color: var(--used-color);
        }
    </style>
@endsection
@section('content')
    <div class="center">
        <div class="font-b"
        style="height: 8em;display:flex;flex-direction: column; align-items: center;justify-content: center">
            <i class="fa fa-user-circle fa-fw m-color font-b"></i>
            <div style="margin-top: 0.6em">我的订单</div>
        </div>
        <div class="mybox" style="text-align: left">
            @foreach($orders as $key => $order)
                @if($key != 0)
                    <hr class="mysplit">
                @endif
                <div class="f-color">
                    <span>{{date('m月d日',strtotime($order->date))}}</span>
                    -
                    <span>{{$order->isDay?'分时使用':'包夜使用'}}</span>
                    @if($order->state > 4)
                        <span class="room-used" >已使用</span>
                    @else
                        <span class="room-touse" >可使用</span>
                    @endif
                </div>
                <div class="b-color">
                <div>
                    {{$order->hasRoom->address}}
                </div>
                <div>
                    <span>使用时间：</span>
                    <span>{{$order->startTime}}</span>
                </div>
                <div>
                    <span>消费金额：</span>
                    <span>{{$order->payNum}}元</span>
                </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection