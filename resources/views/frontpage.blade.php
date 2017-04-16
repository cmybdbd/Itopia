
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
                        <input type="number" id="inp{{$i}}" style="text-align: center; width: 2em">
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
                    <div class="input-group input-group-lg">
                        <input type="number" class="form-control" id="RealId" placeholder="请输入身份证号">
                        <input type="text" class="form-control" id="RealName" placeholder="请输入姓名">
                    </div>
                </div>
                <div>
                    <button class="btn btn-default form-control font-b" style="height: 3em" id="validateID">确 认</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('scripts')
    <script>
        $(function () {
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
                        $.ajax({
                            type: 'get',
                            dataType: 'jsonp',
                            jsonpCallback: 'callback',
                            url: 'http://renthouse.wecash.net/itopia/checkphone.php?m=sendCode&' +
                            'p=' + phone,
                            success: function (e) {
                                console.log(e);
                                inp0.focus();
                            }
                        });
                        time(this);
                    }
                    else {
                        $("#phoneN").focus();
                    }
                });

                inp0.bind('input', function () {
                    inp1.focus();
                });
                inp1.bind('input', function () {
                    inp2.focus();
                });
                inp2.bind('input', function () {
                    inp3.focus();
                });
                inp3.bind('input', function () {
                    if (inp3.val().match(/^\d$/)) {
                        console.log('http://renthouse.wecash.net/itopia/checkphone.php?m=checkCode&' +
                            'p=' + inp0.val() + inp1.val() + inp2.val() + inp3.val());
                        $.ajax({
                            dataType: 'jsonp',
                            jsonpCallback: "jsonp",
                            url: 'http://renthouse.wecash.net/itopia/checkphone.php?m=checkCode&' +
                            'p=' + inp0.val() + inp1.val() + inp2.val() + inp3.val(),
                            success: function (e) {
                                console.log(e);
                                if (e.code == 200) {
                                    $("#validatePhone").modal('hide');
                                    $.ajax({
                                        url: '/savePhone/' + phoneN.val(),
                                        data: {
                                            _token:$("meta[name='csrf-token']").attr('content')
                                        },
                                        type: 'POST',
                                        success: function () {
                                            console.log('save phone');
                                        }
                                    });
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
                        });
                    }
                });
            };
            if(!$("#param .uidN").attr("data-content")) {
                var validateID = $("#validateIdNumber");
                validateID.modal('show');
                $("#validateID").on("click",function(){
                    var RealName = $("#RealName").val();
                    var RealId = $("#RealId").val();

                    if(RealId.match(/^\d{18}$/)) {
                        $.ajax({
                            url: '/idAuth?name=' + RealName + "&id_card="+RealId,
                            success:function(e){
                                console.log(e);
                                if(e.code == 200)
                                {
                                    validateID.modal('hide');
                                }
                            }
                        })
                    }
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