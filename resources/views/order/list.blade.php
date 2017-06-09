
@extends('layout.app')
@section('style')
    <style>
        .center> div{
            text-align: center;
        }

    </style>
@endsection
@section('content')
    <div class="center">
        <div class="font-l"
        style="background-color:#eeeeee;width:100%;height: 44px;margin:0;display:flex;align-items: center;justify-content: center">我的订单
        </div>

        @if(count($orders))
        <div class="mybox" style="text-align: left;box-shadow:none;">
            @foreach($orders as $key => $order)
                @if($key != 0)
                    <hr class="mysplit">
                @endif
            <div class="order-item" data-content="{{$order->id}}">
                <div class="f-color">
                    <span>{{date('m月d日',strtotime($order->startTime))}}</span>
                    -
                    <span>{{$order->isDay?'分时使用':'包夜使用'}}</span>
                    @if($order->state < 4 || $order->state > 8)
                        <span class="button-occupied font-s" style="width:55px;height:24px;float:right;">已结束</span>
                    @elseif($order->state <6)
                        <span class="button-available font-s" style="width:55px;height:24px;float:right;">可使用</span>
                    @else
                        <span class="button-available font-s" style="width:55px;height:24px;float:right;">使用中</span>
                    @endif
                </div>
                <div class="b-color">
                <div>
                    {{$order->hasRoom->title}}空间
                    <!--{{$order->hasRoom->address}}-->
                </div>
                <div>
                    <span>使用时间：</span>
                    <span>20{{date('y年m月d日G:i',strtotime($order->startTime))}} — {{$order->isDay?'':'明日'}}{{date('G:i',strtotime($order->endTime))}}</span>
                </div>
                <div>
                    <span>消费金额：</span>
                    <span>{{$order->price}}元</span>
                </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
            <div style="width: 90%; margin-left: 5%; text-align:center">
                您还没有订单哟，快来体验吧！
            </div>
        @endif
    </div>
@endsection
@section('scripts')
    <script>
        $(function () {
            $(".order-item").on('click',function(){
                window.location.href = '/result/'+$(this).attr("data-content");
            });
        })
    </script>

@endsection
