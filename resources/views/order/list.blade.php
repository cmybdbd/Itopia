
@extends('layout.app')
@section('style')
    <style>
        .center> div{
            text-align: center;
        }
        .list-button{
            margin-right:24px;
            margin-top: 32px;
        }
    </style>
@endsection
@section('content')
    <div class="center">
        <div class="font-l"
        style="background-color:#eeeeee;width:100%;height: 44px;margin:0;display:flex;align-items: center;justify-content: center">我的订单
        </div>

        @if(count($orders))
        <div class="mybox" style="text-align: left;">
            @foreach($orders as $key => $order)
                @if($key != 0)
                    <hr class="mysplit">
                @endif
            @if($order->state != 4)
            <div class="order-item" id="{{$order->id}}" name="{{strtotime($order->startTime) - 1800 < time()}}" data-content="{{$order->state}}">
                <div class="f-color">
                    <span>{{date('m月d日',strtotime($order->startTime))}}</span>
                    -
                    <span>{{$order->isDay?'分时使用':'包夜使用'}}</span>
                    <!--{{strtotime($order->startTime)-1800}}
                    {{time()}}-->
                    @if($order->state == 2 || $order->state == 10)
                        <span class="list-button button-occupied font-s" style="width:55px;height:24px;float:right;">已结束</span>
                    @elseif($order->state == 3 || $order->state == 11)
                        <span class="list-button button-available font-s" style="width:55px;height:24px;float:right;">待评价</span>
                    <!--    <span class="list-button button-available font-s" style="width:55px;height:24px;float:right;">待支付</span>-->
                    @else
                        @if(strtotime($order->startTime) - 1800 < time())
                        <span class="list-button button-available font-s" style="width:55px;height:24px;float:right;">使用中</span>
                        @else
                        <span class="list-button button-available font-s" style="width:55px;height:24px;float:right;">可使用</span>
                        @endif
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
            <div id = "state{{$order->id}}" data-content="{{$order->state}}"></div>
            @endif
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
                state = $(this).attr('data-content');
                switch(state)
                {
                    case '3':
                        window.location.href = '/comment/'+$(this).attr("id");
                        break;
                    case '4':
                        //window.location.href = '/result/'+$(this).attr("id");
                        break;
                    case '5':
                        if( $(this).attr('name')=='1')
                            window.location.href = '/result/'+$(this).attr("id");
                        else;
                        break;
                    case '6':
                        window.location.href = '/result/'+$(this).attr("id");
                        break;
                    case '11':
                        window.location.href = '/comment/'+$(this).attr("id");
                        break;
                    default:
                        break;
                }
                
            });
        })
    </script>

@endsection
