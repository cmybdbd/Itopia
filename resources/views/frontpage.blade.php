
@extends('layout.app')

@section('content')
    <div class="header" style="margin-bottom: 2vh;box-shadow:0 1px 4px #dddddd">
        <div class="mybtn-group">
            <button>
                <i class="fa fa-user-circle fa-fw" style="color:#aeecc7"></i>
                <br>
                我的订单
            </button>
            <button>
                <i class="fa fa-phone fa-fw" style="color:#aeecc7"></i>
                <br>
                反馈意见
            </button>
        </div>
    </div>
    <div class="content">
        @foreach($rooms as $key => $room)
            <div class="mybox">
                <a href="{{'create/'.$room->id}}">
                <div class="myrow" style="margin-bottom: 1vh;display:block;text-align:center" >
                    <img src="{{asset('storage/arch.jpg')}}" style="width: 100%" >
                </div>
                <div class="myrow"  style="justify-content: space-between">
                    <span class="item">{{$room->address}}</span>
                    <span class="room-used" style="padding:0 2vw;border: 1px solid;border-radius: 3px">使用中</span>
                </div>
                <div class="myrow"  style="justify-content: space-between">
                    <span style="color:#aeecc7;font-weight: bold;">¥ {{$room->hourPrice}}/时 ¥ {{$room->nightPrice}}/夜</span>
                    <span class="room-state">可预约<font color="#aeecc7">19:00</font>使用</span>
                </div>
                </a>
            </div>
        @endforeach
    </div>
    <div class="footer" style="color: #aeecc7; text-align: center;margin-bottom:4vh">
        更多Itopia空间会陆续开放，敬请期待！
    </div>
@endsection