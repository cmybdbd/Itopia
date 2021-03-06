<!--night room list
5.31 UI 1.0 basic structure
6.1 UI 1.2 navbar added / shadow effect added,UI finished
-->
@extends('layout.app')

@section('content')
    <div class="myHeader" style="margin-bottom: 2vh;">
        <div class="mybtn-group" style="position:fixed;top:0px;z-index:10;height:46px;background-color:white;">
            <div class="nav-button-top" id="on-left" style="width:33%;height:44px;">
                <img id="left-arrow" style="position:absolute;top:15px;left:15px;width:15px;" src="{{asset('storage/order/leftarrow.png')}}"></img>
                <span style="margin-top: 1vh">前一夜</span>
                <span id="yesterday"></span>
            </div>
            <div id="heute" style="width:33%;height:44px;">
                <span style="color:white;margin-top:15px;" name="today"></span>
                <div id="durationTime" class="scrollPicker" data-content="" ></div>
                <div style="position:absolute;left:0;right:0;margin:auto;top:10px;width:95.5%;height:34px;border-radius:15px;background-color:#1dccb8;z-index:-1;"></div>
            </div>
            <div class="nav-button-top" id="on-right" style="width:33%;height:44px;">
                <img id="right-arrow" style="position:absolute;top:15px;right:15px;width:15px;" src="{{asset('storage/order/rightarrow.png')}}"></img>
                <span style="margin-top: 1vh">后一夜</span>
                <span id="tomorrow"></span>
            </div>
        </div>
        <div class="mybtn-group" style="position:fixed;z-index:10;top:46px;height:44px;background-color:white;">
            <div class="nav-button" id="allHome" style="width:25%;height:44px;">
                <span style="margin-top: 1vh">全部</span>
            </div>
            
            <div class="nav-button" id="zgy" style="width:25%;height:44px;">
                <span style="margin-top: 1vh">中关园</span>
            </div>
            <div class="nav-button" id="frl" style="width:25%;height:44px;">
                <span style="margin-top: 1vh">芙蓉里</span>
            </div>
            <div class="nav-button" id="dhzy" style="width:25%;height:44px;">
                <span style="margin-top: 1vh">大河庄苑</span>
            </div>
        </div>
    </div>
    <div class="content" style="padding-top:88px;">
        @foreach($rooms as $key => $room)
            <div class="roomItem" data-content="{{$room->id}}" id="{{$room->state}}">
                    <div style="wdith:100%;background-color:#eeeeee;">
                    <div class="myrow"  id="slide_{{$key}}" style="margin-bottom: 1vh;margin-left:auto;margin-right:auto;display:block;text-align:center;width:325px;height: 200px;overflow:hidden;visibility:hidden;position:relative;top:0px;left:0px;" >
                        <div data-u="slides" style="width:325px;height: 200px; overflow:hidden;position:relative;top:0px;left:0px;">
                            <?php $imgFiles = \Illuminate\Support\Facades\File::files('storage/room'.($room->state));?>
                            @foreach($imgFiles as $img)
                               <!-- <img src="{{asset('storage/arch.jpg')}}" style="width: 100%" >-->
                               <div>
                                   <img src="../{{$img}}" data-u="image" alt="" width="300px">
                               </div>
                            @endforeach
                        </div>
                    </div>
                    </div>
                    <div class="myrow"  style="justify-content: space-between;margin-left:12px;margin-right:12px;margin-bottom:10px;">
                        <span class="item">{{$room->title}}</span>
                        <span class="m-color" style="float:right;font-weight: 500;">¥ {{$room->nightPrice}}/夜</span>
                        <br>
                        <span id="btn{{$room->state}}" data-content="{{$room->isNightBooked(0) ? '0':'1'}}" class="room-state room-used {{$room->isNightBooked(0)? 'button-occupied':'button-available'}} font-s">
                            {{$room->isNightBooked(0) ? '已订出':'可使用'}}
                        </span>
                        <span class="room-state b-color" style="font-size:12px;float:right;"><span name="today"></span>23:00 - 次日11:00</span>
                    </div>
            </div>
            <hr class="mysplit" style="margin:0;">
        @endforeach
    </div>
    <div class="footer m-color" style="text-align: center;margin-bottom:50px;">
        <p style="margin-top:50px;">更多蜗壳私人空间将陆续开放，敬请期待！</p>
    </div>
    <div id="param">
        <div class="uid" data-content="{{\Illuminate\Support\Facades\Auth::id()}}"></div>
        <div class="uphoneN" data-content="{{\Illuminate\Support\Facades\Auth::user()->phonenumber}}"></div>
        <div class="uidN" data-content="{{\Illuminate\Support\Facades\Auth::user()->idnumber}}"></div>
    </div>
</div>

@endsection
@section('style')
    <style>
        .equipment-content img{
            width: 2em;
        }
        .equipment-content div.center{
            padding-left: 0.7em;
        }
        .equipment-content p {
            font-size: 0.8em;
            display: inline-block;

            line-height: 1.2em;
            padding: 0.4em 0em;
            margin:0  0.25em;
            width: 45%;
        }
        .equipment-content p > img{
            margin-right: 0.4em;
        }
        .equipment-content p > span{
            text-align: center;
        }
        span.item{
            width: 15em;
        }
        span.room-state{
            height: 1.6em;
        }
        .wheel-item{
            list-style-type:none;
        }
        .cancel{
            color:#aaa;
            font-size: 16px;
            height:44px;
            border: 1px solid #1dccb8;
            border-radius: 44px;
            width: 44.5% !important;
            margin-left:3.7%;
        }
        .cancel::after{
            background-image: none !important;
        }
        .confirm{
            color:white !important;
            font-size: 16px;
            height:44px;
            border: 1px solid #1dccb8;
            border-radius: 44px;
            width: 44.5% !important;
            margin-right:3.7%;
            background-color: #1dccb8;
        }
    </style>
    @endsection
@section('scripts')
    <script src="{{url('js/jssor.slider.min.js')}}"></script>
    <script src="{{url('js/roomList.js')}}"></script>
    <script src="{{url('js/nightRoomClick.js')}}"></script>
@endsection