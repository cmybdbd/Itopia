
@extends('layout.app')

@section('content')
    <div class="myHeader" style="margin-bottom: 2vh;box-shadow:0 1px 6px #eeeeee">
        <div class="mybtn-group" style="">
            <div id="myOrder">
                <i class="fa fa-user-circle fa-fw m-color font-b"></i>
                <span style="margin-top: 1vh">
                我的订单
                </span>
            </div>
            <div id="equipment">
                <img src="{{asset('storage/u329.png')}}" style="width:1.4em" alt="">

                <span style="margin-top: 1vh">
                    小屋设施
                </span>
            </div>
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
                        <span class="room-used {{$room->isUsing()? 'u-color':'m-color'}}" style="padding:0 2vw;border: 1px solid;border-radius: 3px;display:flex;flex-direction: row;justify-content: center">
                            {{$room->isUsing() ? '使用中':'可使用'}}
                        </span>
                    </div>
                    <div class="myrow"  style="justify-content: space-between">
                        <span class="m-color" style="font-weight: bold;">¥ {{$room->hourPrice}}/时 ¥ {{$room->nightPrice}}/夜</span>
                        @if($room->isUsing())
                            @if($room->nextTime() != 0)
                                <span class="room-state b-color">可预约<span class="m-color">{{(date('H',$room->nextTime())== 11? '明早':'' ). date('H:i',$room->nextTime())}}</span>使用</span>
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
                        <input type="number" id="inp{{$i}}" style="text-align: center;font-size:3em; width: 1.4em;">
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
    </style>
    @endsection
@section('scripts')
    <script>
        $(function () {

            $("#equipment").on('click',function () {
                $(".equipment-content").modal();
            });

            var validatePhone =$("#validatePhone");
            var phoneN = $("#phoneN");
            validatePhone.on('shown.bs.modal', function () {
                phoneN.focus();
            });

            if(!$("#param .uphoneN").attr("data-content")) {
                var wait = 60;

                function time(o) {
                    if (wait === 0) {
                        o.removeAttribute("disabled");
                        o.textContent = "获取验证码";
                        wait = 60;
                    } else {

                        o.setAttribute("disabled", true);
                        o.textContent = "重新发送(" + wait + ")";
                        wait--;
                        setTimeout(function () {
                                time(o)
                            },
                            1000)
                    }
                }

                //alert('no idnumber');
                var inp0 = $("#inp0"),
                    inp1 = $("#inp1"),
                    inp2 = $("#inp2"),
                    inp3 = $("#inp3");

                validatePhone.modal('show');
                $("#sendCode").on('click', function () {
                    phone = phoneN.val();
                    if (phone.match(/^\d{11}$/)) {
                        strpol = '0123456789';
                        pwd = '';
                        for (i = 0; i < 4; i++) {
                            pwd += strpol.charAt(Math.floor(Math.random() * 10));
                        }
                        param = {
                            'mblNo': phone,
                            'repVar': pwd + '|10|17302175859',
                        };

                        $.ajax({
                            type: 'get',
                            dataType: 'jsonp',
                            jsonpCallback: 'callback',
                            url: 'http://renthouse.wecash.net/itopia/checkphone.php?m=sendCode&' +
                            'p=' + JSON.stringify(param),
                            success: function (e) {
                                console.log(e);
                                inp0.focus();

                                $.ajax({
                                    type: 'POST',
                                    url: '/session/vcode',
                                    data:{
                                        'code': pwd,
                                        _token:$("meta[name='csrf-token']").attr('content')
                                    },
                                    success: function(e){
                                        console.log(e);
                                    }
                                });
                            }
                        });
                        time(this);
                    }
                    else {
                        $("#phoneN").focus();
                    }
                });

                inp0.bind('input', function () {
                    if(inp0.val().match(/^\d$/))
                        inp1.focus();
                });
                inp1.bind('input', function () {
                    if(inp1.val().match(/^\d$/))
                    inp2.focus();
                });
                inp2.bind('input', function () {
                    if(inp2.val().match(/^\d$/))
                    inp3.focus();
                });
                inp3.bind('input', function () {
                    if (inp3.val().match(/^\d$/)) {
                        $.ajax({
                            url: '/vcode/validate',
                            type:'POST',
                            data:{
                                'dynCode': inp0.val() + inp1.val() + inp2.val() + inp3.val(),
                                'phone': phone,
                                _token:$("meta[name='csrf-token']").attr('content')
                            },
                            success: function (e) {
                                console.log(e);
                                if (e.code == 200) {
                                    $("#validatePhone").modal('hide');
                                    validateID.modal('show');

                                }
                                else {
                                    $(".errormsg").text('验证码有误');
                                    setTimeout(function () {
                                        $(".errormsg").text('');
                                    }, 3000);
                                    inp0.val('');
                                    inp1.val('');
                                    inp2.val('');
                                    inp3.val('');
                                    inp0.focus();
                                }
                            }
                        })

                    }
                });
            };
            if(!$("#param .uidN").attr("data-content")) {
                var validateID = $("#validateIdNumber");
                validateID.on("shown.bs.modal", function(){
                    $("#RealId").focus();
                })
                if($("#param .uphoneN").attr("data-content"))
                    validateID.modal('show');
                $("#validateID").on("click",function(){
                    var RealName = $("#RealName").val();
                    var RealId = $("#RealId").val();

                    if(RealId.match(/^\d{17}\w$/)) {
                        $.ajax({
                            url: '/idAuth?name=' + RealName + "&id_card="+RealId,
                            success:function(e){
                                console.log(e);
                                if(e.code == 200)
                                {
                                    validateID.modal('hide');
                                }
                                else
                                {
                                    validateID.modal('hide');
                                    $("#idNumberError").modal('show');
                                }
                            }
                        })
                    }
                    else
                    {
                        $("#RealId").attr('placeholder','请输入正确的身份证号')
                            .val('')
                            .focus();
                    }
                })
                $("#idNumberError button").on("click",function(){
                    $("#idNumberError").modal('hide');
                    validateID.find('input').val('');
                    validateID.modal('show');
                })
            }
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