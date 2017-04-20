@extends('layout.app')
@section('content')
    <div>
        <div>
            订单后台页
        </div>
        <div>
            <ul>
                <li role="presentation" class="">
                    <a href="#" aria-controls="" role="tab"
                       data-toggle="pill">
                        白天
                    </a>
                </li>
                <li role="presentation" class="">
                    <a href="#" aria-controls="" role="tab"
                       data-toggle="pill">
                        包夜
                    </a>
                </li>
                <li role="presentation" class="active">
                    <a href="#" aria-controls="" role="tab"
                       data-toggle="pill">
                        全部
                    </a>
                </li>
            </ul>
        </div>
        <div>
            <div id="date" class="input-group date">
                <p class="input-group-addon" style="position: absolute;opacity:0">
                    <span style="opacity: 0;">12-31</span>
                </p>
                <input type="text" style="width:4em">
            </div>
            <ul class="nav nav-pills" roll="tablist">
                <li role="presentation" class="active">
                <a href="#" aria-controls="" role="tab"
                   data-toggle="pill">
                    全部
                </a>
                </li>
                @foreach($rooms as $key => $room)
                    <li role="presentation" class="">
                        <a href="#{{$room->title}}" aria-controls="{{$room->title}}" role="tab"
                           data-toggle="pill">
                            {{$room->title}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div>
            @foreach($orders as $key => $order)
                <div id="{{$order->id}}" roomId="{{$order->roomId}}" type="{{$order->isDay? 'day':'night'}}"

                >
                    <div>
                        <span>微信号：</span><span>{{$order->hasUser['id']}}</span>
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
@section('scripts')
    <script src="{{url('js/moment.min.js')}}"></script>
    <script src="{{url('js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>
        $(function(){
            $("#date").datetimepicker({


                    format: 'MM-DD'
                }
            );
        })
    </script>
@endsection