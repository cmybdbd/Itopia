
@extends('layout.app')

@section('content')
    <div class="myHeader" style="position:fixed;top:0px;width:100%;margin-bottom: 2vh;box-shadow:0 1px 6px #eeeeee">
        <div class="mybtn-group" style="top:0px;width:100%;height:60px;position:absolute;">
            <div id="myOrder">
                <img src="{{asset('storage/map/myOrder.png')}}" style="position:absolute;width:40px;top:24px;left:30px;" alt="">
                <span style="font-size:14px;font-weight:500;position:absolute;top:68px;left:22px;">
                我的订单
                </span>
            </div>
            <div id="equipment">
                <img src="{{asset('storage/map/roomFacilities.png')}}" style="position:absolute;width:40px;top:24px;right:30px;" alt="">
                <span style="font-size:14px;font-weight:500;position:absolute;top:68px;right:22px;">
                    小屋设施
                </span>
            </div>
        </div>
    </div>
    <div class="content" style="height:100%;width:100%;">
            <!--onmouseover="getMousePos(event)"-->
        <div style="max-wdith:100%;max-height:100%;overflow:scroll;">
            <img id="mapImg" class="blend" scrollLeft="100" clientLeft="100" style="position:absolute;top:0px;z-index:-1;height:800px;width:1050px;overflow:hidden;">
        </div>

        <div id = "frl">
            <img src="{{asset('storage/map/landmark.png')}}" style="position:absolute;top:400px;left:335px;width:45px;z-index=1;">
            <div>
                <span style="width:80px;position:absolute;top:420px;left:395px;font-size:14px;z-index:2;">芙蓉里 <span class="m-color" style="font-weight:600;">5</span> 间</span>
                <img src="{{asset('storage/map/label.png')}}" style="position:absolute;top:410px;left:375px;height:48px;z-index=1;">
            </div>
        </div>
        
        <div id = "hdzy">
            <img src="{{asset('storage/map/landmark.png')}}" style="position:absolute;top:520px;left:390px;width:45px;z-index=1;">
            <div>
                <span style="width:90px;position:absolute;top:540px;left:450px;font-size:14px;z-index:2;">大河庄苑 <span class="m-color" style="font-weight:600;">5</span> 间</span>
                <img src="{{asset('storage/map/label.png')}}" style="position:absolute;top:530px;left:430px;width:130px;height:48px;z-index=1;">
            </div>
        </div>

        <div id = "zgy">
        <img src="{{asset('storage/map/landmark.png')}}" style="position:absolute;top:270px;left:680px;width:45px;z-index=1;">
        <div>
            <span style="width:80px;position:absolute;top:290px;left:740px;font-size:14px;z-index:2;">中关园 <span class="m-color" style="font-weight:600;">5</span> 间</span>
            <img src="{{asset('storage/map/label.png')}}" style="position:absolute;top:280px;left:720px;height:48px;z-index=1;">
        </div>
        </div>

        <div id = "kyxq">
            <img src="{{asset('storage/map/landmark.png')}}" style="position:absolute;top:470px;left:730px;width:45px;z-index=1;">
            <div>
                <span style="width:90px;position:absolute;top:490px;left:790px;font-size:14px;z-index:2;">科育小区 <span class="m-color" style="font-weight:600;">5</span> 间</span>
                <img src="{{asset('storage/map/label.png')}}" style="position:absolute;top:480px;left:770px;width:130px;height:48px;z-index=1;">
            </div>
        </div>

        <div id = "dxy">
            <img src="{{asset('storage/map/landmark.png')}}" style="position:absolute;top:580px;left:350px;width:45px;z-index=1;">
            <div>
                <span style="width:80px;position:absolute;top:600px;left:410px;font-size:14px;z-index:2;">稻香园 <span class="m-color" style="font-weight:600;">5</span> 间</span>
                <img src="{{asset('storage/map/label.png')}}" style="position:absolute;top:590px;left:390px;height:48px;z-index=1;">
            </div>
        </div>

    </div>
    <div style="position:fixed;width:100%;bottom:64px;z-index:10;">
        <div id='day' class="circle" style="text-align:center;position:absolute;bottom:0;left:20%">
            <p class="font-xl" style="margin-top:16px;font-weight:500;">时租</p>
            <p class="font-l m-color" style="margin-top:-10px;font-weight:500;">19 / 小时</p></div>
        <div id='night' class="circle" style="text-align:center;position:absolute;bottom:0;right:20%">
            <p class="font-xl" style="margin-top:16px;font-weight:500;">包夜</p>
            <p class="font-l m-color" style="margin-top:-10px;font-weight:500;">179 / 夜</p></div>
    </div>

    <div id="param">
        <div class="uid" data-content="{{\Illuminate\Support\Facades\Auth::id()}}"></div>
        <div class="uphoneN" data-content="{{\Illuminate\Support\Facades\Auth::user()->phonenumber}}"></div>
        <div class="uidN" data-content="{{\Illuminate\Support\Facades\Auth::user()->idnumber}}"></div>
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

        .blend
        {
            overflow: hidden;
            background-size:1068px;
            background-image: url({{asset('storage/map/mapPKU.png')}}), -webkit-linear-gradient( top,#aaa,#000);
            -moz-background-image: url({{asset('storage/map/mapPKU.png')}}), -moz-linear-gradient( top,#aaa,#000);
            background-blend-mode: screen;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{url('js/login.js')}}"></script>
    <script>
    $("#equipment").on('click',function () {
        $(".equipment-content").modal('show');
    });
    $("#dxy").on('click',function () {
        //window.location.replace('/getDayRooms/dxy');
        window.location.href='/getDayRooms/dxy';
    });
    $("#dhzy").on('click',function () {
        //window.location.replace('/getDayRooms/dhzy');
        window.location.href='/getDayRooms/dhzy';
    });
    $("#kyxq").on('click',function () {
        //window.location.replace('/getDayRooms/kyxq');
        window.location.href='/getDayRooms/kyxq';
    });
    $("#frl").on('click',function () {
        //window.location.replace('/getDayRooms/frl');
        window.location.href='/getDayRooms/frl';
    });
    $("#zgy").on('click',function () {
        //window.location.replace('/getDayRooms/zgy');
        window.location.href='/getDayRooms/zgy';
    });
    </script>
@endsection