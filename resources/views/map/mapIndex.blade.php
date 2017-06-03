
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
    <div class="content" style="height:100%;overflow:hidden;">
        <div class="map">
        <img class="blend" onmouseover="getMousePos(event)" style="position:absolute;top:0px;z-index:-1;height:100%;width:1000px;overflow:scroll">
        </div>
    </div>
    <div style="position:fixed;width:100%;bottom:64px;">
        <div id='day' class="circle" style="text-align:center;position:absolute;bottom:0;left:20%">
            <p class="font-xl" style="margin-top:16px;font-weight:500;">时租</p>
            <p class="font-l m-color" style="margin-top:-10px;font-weight:500;">19 / 小时</p></div>
        <div id='night' class="circle" style="text-align:center;position:absolute;bottom:0;right:20%">
            <p class="font-xl" style="margin-top:16px;font-weight:500;">包夜</p>
            <p class="font-l m-color" style="margin-top:-10px;font-weight:500;">159 / 夜</p></div>
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
            background-image: url({{asset('storage/map/mapPKU.png')}}), -moz-linear-gradient( top,#aaa,#000);
            background-blend-mode: screen;
        }
    </style>
@endsection
@section('scripts')
    <!--<script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>-->
    <script src="{{url('js/login.js')}}"></script>

    <!--<script src="{{url('js/jssor.slider.min.js')}}"></script>
    <script src="{{url('js/roomList.js')}}"></script>
    <script type="javascript/text">
    function getMousePos(event) {
        var e = event || window.event;
        var scrollX = document.documentElement.scrollLeft || document.body.scrollLeft;
        var scrollY = document.documentElement.scrollTop || document.body.scrollTop;
        var x = e.pageX || e.clientX + scrollX;
        var y = e.pageY || e.clientY + scrollY;
        return { 'x': x, 'y': y };
        console(x + " "+ y);
    }
    </script>-->
@endsection