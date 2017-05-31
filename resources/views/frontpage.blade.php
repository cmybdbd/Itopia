<!--day room list
5.31 UI 1.0 
-->
@extends('layout.app')

@section('content')
    <div class="myHeader" style="margin-bottom: 2vh;box-shadow:0 1px 6px #eeeeee">
        <div class="mybtn-group" style="height:44px;">
            <div id="myOrder" style="height:44px;">
                <span style="margin-top: 1vh">
                    今日使用
                </span>
            </div>
            <div id="equipment" style="height:44px;">
                <span style="margin-top: 1vh">
                    明日使用
                </span>
                <br>
                <span id="tomorrow"></span>
            </div>
        </div>
        <div class="mybtn-group" style="height:44px;">
            <div id="allHome" style="width:33%;height:44px;">
                <span style="margin-top: 1vh">
                    全   部
                </span>
            </div>
            <div id="nearestHome" style="width:33%;height:44px;">
                <span style="margin-top: 1vh">
                    离我最近
                </span>
            </div>
            <div id="chooseArea" style="width:33%;height:44px;">
                <span style="margin-top: 1vh">
                    选择小区
                </span>
                <div id="triangle-down-b" style="position:absolute;right:10px;top:23px;">
            </div>
        </div>
    </div>
    <div class="content">
        @foreach($rooms as $key => $room)
            <div class="roomItem" data-content="{{$room->id}}">
                    <div class="myrow"  id="slide_{{$key}}" style="margin-bottom: 1vh;margin-left:auto;margin-right:auto;display:block;text-align:center;width: 300px;height: 200px;overflow:hidden;visibility:hidden;position:relative;top:0px;left:0px;" >
                        <div data-u="slides" style="width: 300px;height: 200px; overflow:hidden;position:relative;top:0px;left:0px;">
                            <?php $imgFiles = \Illuminate\Support\Facades\File::files('storage/room'.($key+1));?>
                            @foreach($imgFiles as $img)
                               <!-- <img src="{{asset('storage/arch.jpg')}}" style="width: 100%" >-->
                               <div>
                                   <img src="{{$img}}" data-u="image" alt="" width="300px">
                               </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="myrow"  style="justify-content: space-between;margin-left:12px;margin-right:12px;margin-bottom:10px;">
                        <span class="item">{{$room->title}}</span>
                        <span class="m-color" style="float:right;font-weight: 500;">¥ {{$room->hourPrice}}/小时</span>
                        <br>
                        <span class="room-state room-used {{$room->isUsing()? 'button-occupied':'button-available'}}" style="width:56px;padding:0 2vw;border: 1px solid;border-radius:12px;justify-content: center;">
                            {{$room->isUsing() ? '使用中':'可使用'}}
                        </span>
                        @if($room->isUsing())
                            @if($room->nextTime() != 0)
                                <span class="room-state b-color">可预约<span class="m-color">{{(date('H',$room->nextTime())== 11? '明早':'' ). date('H:i',$room->nextTime())}}</span>使用</span>
                            @elseif(in_array(date('Y-m-d 00:00:00',\App\Utils\Utils::curNight()), json_decode($room->usingNight())))
                                <span class="room-state b-color">今日已约满</span>
                            @else
                                <span class="room-state m-color">可预约包夜</span>
                            @endif
                        @else
                            <span class="room-state b-color" style="float:right;">即时使用</span>
                        @endif
                    </div>
            </div>
        @endforeach
    </div>
    <div class="footer m-color" style="text-align: center;margin-bottom:4vh">
        更多iTOPIA即时私人空间将陆续开放，敬请期待！
    </div>
    <div id="param">
        <div class="uid" data-content="{{\Illuminate\Support\Facades\Auth::id()}}"></div>
        <div class="uphoneN" data-content="{{\Illuminate\Support\Facades\Auth::user()->phonenumber}}"></div>
        <div class="uidN" data-content="{{\Illuminate\Support\Facades\Auth::user()->idnumber}}"></div>
    </div>

    <div id="validatePhone" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="m-color">
                    <h4 style="text-align: center;line-height:2em">注册/登录</h4>
                </div>
                <hr class="mysplit">
                <div class="modal-body">
                    <div class="input-group input-group-lg">
                        <input type="number" class="form-control" id="phoneN" max="99999999999" placeholder="请输入你的手机号">
                        <span class="input-group-btn">
                            <button class="btn btn-secondary" id="sendCode" type="button">获取验证码</button>
                        </span>
                    </div>
                </div>
                <div class="" style="padding-bottom: 2.5em;display:flex; justify-content: space-around;">
                    @for($i = 0; $i < 4; $i ++)
                        <input type="number" id="inp{{$i}}" style="text-align: center;font-size:2em; width: 1.6em;">
                    @endfor
                </div>
                <p class="errormsg" style="color: red; position: absolute;left:1em;bottom: 0em;"></p>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div id="validateIdNumber" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="m-color">
                    <h4 style="text-align: center;line-height:2em">身份验证</h4>
                </div>
                <hr class="mysplit">
                <div class="modal-body">
                    <div class="input-group input-group-lg" >
                        <input type="text" class="form-control" id="RealId" placeholder="请输入身份证号">
                    </div>
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control" id="RealName" placeholder="请输入姓名">
                    </div>
                </div>
                <div>
                    <button class="btn btn-default form-control font-b" style="height: 3em" id="validateID">确 认</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div id="idNumberError" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="b-color" style="padding:1em 2em">主人, 你输入的身份证号有误哦！</div>
                </div>

                <div>
                    <button class="btn btn-default form-control m-color" style="height: 3em" id="">朕重新输入一遍</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


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
@endsection