<!--day room list
5.31 UI 1.0 basic structure
6.1 UI 1.2 navbar added / shadow effect added, UI finished
-->
@extends('layout.app')

@section('content')
    <div class="myHeader" style="margin-bottom: 2vh;">
        <div class="mybtn-group" style="position:fixed;top:0px;z-index:10;height:48px;background-color:white;">
            <div class="nav-button-top nav-active" id="useToday" style="height:46px;">
                <span style="margin-top: 1vh">
                    今日使用
                </span>
                <span name="today"></span>
            </div>
            <div class="nav-button-top" id="useTomorrow" style="height:46px;">
                <span style="margin-top: 1vh">
                    明日使用
                </span>
                <span id="tomorrow"></span>
            </div>
        </div>
        <div class="mybtn-group" style="position:fixed;z-index:10;top:48px;height:44px;background-color:white;box-shadow:0 1px 6px #eeeeee">
            <div class="nav-button" id="allHome" style="width:33%;height:44px;">
                <span style="margin-top: 1vh">
                    全   部
                </span>
            </div>
            <div class="nav-button" id="nearestHome" style="width:33%;height:44px;">
                <span style="margin-top: 1vh">
                    离我最近
                </span>
            </div>
            <div class="user nav-button" id="chooseArea" style="width:34%;height:44px;border-right-color:white;border-right-style:solid;border-right-width:5px;">
                <span style="margin-top: 2vh">选择小区</span>
                <div id="triangle-down-b" style="position:absolute;right:14%;top:52%;"></div>
                <div class="user-nav">
                    <ul style="padding-left:0px; top:0px;">
                        <li><a id="dxy" class="font-xl"href="#">稻香园 <b class="m-color">0</b> 间</a></li><!--3-->
                        <hr class="mysplit" style="margin:0px;">
                        <li><a id="dhzy" class="font-xl"href="#">大河庄苑 <b class="m-color">0</b> 间</a></li><!--8-->
                        <hr class="mysplit" style="margin:0px;">
                        <li><a id="kyxq" class="font-xl"href="#">科育小区 <b class="m-color">0</b> 间</a></li><!--3-->
                        <hr class="mysplit" style="margin:0px;">
                        <li><a id="frl" class="font-xl"href="#">芙蓉里 <b class="m-color">3</b> 间</a></li>
                        <hr class="mysplit" style="margin:0px;">
                        <li><a id="zgy" class="font-xl"href="#">中关园 <b class="m-color">3</b> 间</a></li>
                    </ul>
                </div>
            </div>
        </div>
    <hr class="mysplit" style="margin:0;">
    <div id="content" class="content" style="padding-top:81px;">
        @foreach($rooms as $key => $room)
            <div class="roomItem" data-content="{{$room->id}}" id="{{$room->state}}" style="cursor:pointer;">
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
                        <span class="m-color" style="float:right;font-weight: 500;">¥ {{$room->hourPrice}}/小时</span>
                        <br>
                        <?php
                            $room_state = 0;
                            if (date('H')<11||date('H')>22)
                            {
                                $room_state = 1;
                                $room_str = '包夜中';
                            }
                            else if($room->isUsing())
                            {
                                $room_state = 2;
                                $room_str = '使用中';
                            }
                            else
                            {
                                $room_state = 0;
                                $room_str = '可使用';
                            }
                        ?>
                        <span class="room-state room-used {{$room_state>0 ? 'button-occupied':'button-available'}} font-s">
                            {{$room_str}}
                        </span>
                        <!--<p>Night {{$room->isNightBooked(0)}}</p>
                        <p>nextDay {{$room->nextDayUsingTime()}}</p>
                        <p>Today {{date('n-H:i',$room->nextTime())}}</p>-->
                       
                        @if(date('H',$room->nextTime()) != 8 && date('H',$room->nextTime()) < 21)
                            @if($room->isUsing())
                                1<span id="btn{{$room->state}}" data-content="1" class="room-state b-color font-s" style="float:right;">可预约<span class="m-color">{{date("H:i",$room->nextTime())}}</span>使用</span>
                            @else
                                @if( date("H") < 21 && date("H") > 10)
                                2<span id="btn{{$room->state}}" data-content="1" class="room-state b-color font-s" style="float:right;">即时使用</span>
                                @else
                                3<span id="btn{{$room->state}}" data-content="1" class="room-state b-color font-s" style="float:right;">可预约<span class="m-color">{{date("H")>=21 ? '明天':''}}{{date("H:i",$room->nextTime())}}</span>使用</span>
                                @endif
                            @endif
                        @elseif(date('H',$room->nextTime()) == 8)
                            @if( date("H") < 21 && date("H") > 10)
                                4<span id="btn{{$room->state}}" data-content="1" class="room-state b-color font-s" style="float:right;">即时使用</span>
                            @else
                                5<span id="btn{{$room->state}}" data-content="1" class="room-state b-color font-s" style="float:right;">可预约<span class="m-color">{{date("H")>=21 ? '明天':''}}{{$room->type==0 ? '10:30':'11:00'}}</span>使用</span>
                            @endif
                        @else
                            @if ($room->nextDayUsingTime() == 0)
                                6<span id="btn{{$room->state}}" data-content="1" class="room-state b-color font-s" style="float:right;">可预约<span class="m-color">{{date("H")>=21 ? '明天':''}}{{$room->type==0 ? '10:30':'11:00'}}</span>使用</span>
                            @elseif ($room->nextDayUsingTime() == -1)
                                7<span id="btn{{$room->state}}" data-content="0" class="room-state b-color button-occupied font-s" style="float:right;">已约满</span>
                            @else
                                8<span id="btn{{$room->state}}" data-content="1" class="room-state b-color font-s" style="float:right;">可预约<span class="m-color">明天{{$room->nextDayUsingTime()}}</span>使用</span>
                            @endif                                
                        @endif
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

    <div class="modal fade bs-example-modal-sm equipment-content" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div style="margin-left:5%;margin-right:5%;">
                        <div>
                        <div class="font-m m-color">基础设施</div>
                            <div class="center">
                            <p><img src="{{asset('storage/u340.png')}}" alt=""><span>懒人沙发</span></p>
                            <p><img src="{{asset('storage/u342.png')}}" alt=""><span>榻榻米</span></p>
                            <p><img src="{{asset('storage/u354.png')}}" alt=""><span>智能蓝牙投影</span></p>
                            <p><img src="{{asset('storage/u356.png')}}" alt=""><span>双人床</span></p>
                            <p><img src="{{asset('storage/u362.png')}}" alt=""><span>智能门锁</span></p>
                            <p><img src="{{asset('storage/u364.png')}}" alt=""><span>冰箱</span></p>
                            <p><img src="{{asset('storage/u370.png')}}" alt=""><span>空调</span></p>
                            <p><img src="{{asset('storage/u372.png')}}" alt=""><span>电吹风</span></p>
                            <p><img src="{{asset('storage/u374.png')}}" alt=""><span>洗衣机</span></p>
                            <p><img src="{{asset('storage/u376.png')}}" alt=""><span>饮水机</span></p>
                            <p><img src="{{asset('storage/u382.png')}}" alt=""><span>24小时热水</span></p>
                            <p><img src="{{asset('storage/u384.png')}}" alt=""><span>Wi-Fi</span></p>
                            </div>
                        </div>
                        <div>
                            <div class="font-m m-color">有偿服务</div>
                            <div class="center">
                            <p><img src="{{asset('storage/u398.png')}}" alt=""><span>桌游棋牌</span></p>
                            <p><img src="{{asset('storage/u396.png')}}" alt=""><span>零食饮料</span></p>
                            <p><img src="{{asset('storage/u392.png')}}" alt=""><span>一次性洗漱用品</span></p>
                            <p><img src="{{asset('storage/u394.png')}}" alt=""><span>床品四件套</span></p>
                            </div>
                        </div>
                    </div>
                    <hr class="mysplit" style="margin: 0.5em;">
                    <button class="m-color font-m"
                            data-dismiss="modal"
                            style="border:none;width:100%;height:100%;background-color:white;">朕知道了</button>
                </div>
            </div>
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
    </style>
    @endsection
@section('scripts')
    <script src="{{url('js/jssor.slider.min.js')}}"></script>
    <script src="{{url('js/roomList.js')}}"></script>
    <!--<script src="{{url('js/login.js')}}"></script>-->
    <script src="{{url('js/dayRoomClick.js')}}"></script>
@endsection