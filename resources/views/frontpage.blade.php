
@extends('layout.app')

@section('content')
    <div class="myHeader" style="margin-bottom: 2vh;box-shadow:0 1px 6px #eeeeee">
        <div class="mybtn-group">
            <button id="myOrder">
                <i class="fa fa-user-circle fa-fw m-color font-b"></i>

                <br>
                我的订单
            </button>
            <button id="report">
                <i class="fa fa-phone fa-fw m-color font-b"></i>
                <br>
                反馈意见
            </button>
        </div>
    </div>
    <div class="content">
        @foreach($rooms as $key => $room)
            <div class="mybox roomItem" data-content="{{$room->id}}">
                    <div class="myrow" style="margin-bottom: 1vh;display:block;text-align:center" >
                        <img src="{{asset('storage/arch.jpg')}}" style="width: 100%" >
                    </div>
                    <div class="myrow"  style="justify-content: space-between">
                        <span class="item">{{$room->address}}</span>
                        <span class="room-used {{$room->isUsing()? 'u-color':'m-color'}}" style="padding:0 2vw;border: 1px solid;border-radius: 3px">
                            {{$room->isUsing() ? '使用中':'可使用'}}</span>
                    </div>
                    <div class="myrow"  style="justify-content: space-between">
                        <span class="m-color" style="font-weight: bold;">¥ {{$room->hourPrice}}/时 ¥ {{$room->nightPrice}}/夜</span>
                        @if($room->isUsing())
                            @if($room->nextTime() != -1)
                                <span class="room-state b-color">可预约<span class="m-color">{{date('H:i',$room->nextTime())}}</span>使用</span>
                            @else
                                <span class="room-state b-color">今日已约满</span>
                            @endif
                        @else
                            <span class="room-state b-color">即时使用</span>
                        @endif
                    </div>
            </div>
        @endforeach
    </div>
    <div class="footer m-color" style="text-align: center;margin-bottom:4vh">
        更多Itopia空间会陆续开放，敬请期待！
    </div>
    <div id="param">
        <div class="uid" data-content="{{\Illuminate\Support\Facades\Auth::id()}}"></div>

    </div>
@endsection
@section('scripts')
    <script>
        $(function () {
            var uid = $("#param .uid").attr('data-content');
            $("#myOrder").on('click',function () {
                window.location.href = window.location.href.replace('home','orderList/'+uid);
            });
            $(".roomItem").on('click', function () {

                window.location.href = window.location.href.replace(
                    'home',
                    'create/' + uid + '/' + $(this).attr('data-content')
            )
            });
        });

    </script>
@endsection