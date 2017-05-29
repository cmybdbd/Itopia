
@extends('layout.app')

@section('content')
    <div class="myHeader" style="position:fixed;top:3%;width:100%;margin-bottom: 2vh;box-shadow:0 1px 6px #eeeeee">
        <div class="mybtn-group" style="width:100%;height:60px;position:absolute;">
            <div id="myOrder">
                <img src="{{asset('storage/map/myOrder.png')}}" style="width:5em;margin-left:-40%;" alt="">
                <!--<span style="margin-top: 1vh">
                我的订单
                </span>-->
            </div>
            <div id="equipment">
                <img src="{{asset('storage/map/roomFacilities.png')}}" style="width:5em;margin-right:-40%;" alt="">
                <!--<span style="margin-top: 1vh">
                    小屋设施
                </span>-->
            </div>
        </div>
    </div>
    <div class="content" style="height:100%;overflow:hidden;">
        <img src="{{asset('storage/map/mapPKU.png')}}" style="position:absolute;top:0px;z-index:-1;height:100%;width:auto;overflow:scroll">
    </div>
    <div style="position:fixed;width:100%;bottom:8%;">
        <div class="circle" style="text-align:center;position:absolute;bottom:10%;left:16%">
            <p class="font-xl" style="margin-top:10px;">时租</p>
            <p class="font-m m-color" style="margin-top:-10px;">19/时</p></div>
        <div class="circle" style="text-align:center;position:absolute;bottom:10%;right:16%">
            <p class="font-xl" style="margin-top:10px;">包夜</p>
            <p class="font-m m-color" style="margin-top:-10px;">159/夜</p></div>
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
    <script>
        $(function () {

            var jssor_1_SlideshowTransitions = [
                {
                    $Duration:1000,
                    x:-0.3,
                    $During:{$Left:[0.3,0.7]},
                    $Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},
                    $Opacity:0
                },
                {
                    $Duration:1000,
                    x:0.3,
                    $SlideOut:true,
                    $Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},
                    $Opacity:0
                }
            ];

            var jssor_1_options = {
                $AutoPlay: 1
            };
            var jssor_slider = [];
            for (i =0 ;i< $(".roomItem").length;i++) {
                jssor_slider[i] = new $JssorSlider$("slide_"+i, jssor_1_options);
            }
           // var jssor_2_slider = new $JssorSlider$("jssor_2", jssor_1_options);

            /*responsive code begin*/
            /*remove responsive code if you don't want the slider scales while window resizing*/
            function ScaleSlider() {
                var uload = false;
                for(i=0; i< $(".roomItem").length;i++) {
                    var refwidth = jssor_slider[i].$Elmt.parentNode.clientWidth;
                    var refheight = jssor_slider[i].$Elmt.parentNode.clientHeight;
                    if (refwidth) {
                        if(refheight / refwidth > 1)
                        {
                            jssor_slider[i].$ScaleHeight(Math.min(refheight,200));
                        }
                        else
                        {
                            jssor_slider[i].$ScaleWidth(Math.min(refwidth,300));
                        }
                    }
                    else {
                        uload =true;
                    }
                }
                if(uload)
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();
            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);




            $("#equipment").on('click',function () {
                $(".equipment-content").modal();
            });

            var validatePhone =$("#validatePhone");
            var phoneN = $("#phoneN");
            validatePhone.on('shown.bs.modal', function () {
                phoneN.focus();
            });


            var uid = $("#param .uid").attr('data-content');
            $("#myOrder").on('click',function () {
                window.location.href = window.location.href.replace('home','orderList/'+uid);
            });
            $(".roomItem").on('click', function () {
                var t1 =false,t2=false;
                /*
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
                            url: '/savePhone/' + phoneN.val(),
                            data: {
                                _token:$("meta[name='csrf-token']").attr('content')
                            },
                            type: 'POST',
                            success: function () {
                                $("#validatePhone").modal('hide');
                                console.log('save phone');
                            }
                        });
                        /*$.ajax({
                            type: 'get',
                            dataType: 'jsonp',
                            jsonpCallback: 'callback',
                            url: 'http://renthouse.wecash.net/itopia/checkphone.php?m=sendCode&' +
                            'p=' + phone,
                            success: function (e) {
                                console.log(e);
                                inp0.focus();
                            }
                        });*//*
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
                                    $("#validatePhone").modal('hide');*/

                    //alert('no idnumber');
                    /*
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
                                            $("#param .uphoneN").attr("data-content",phone);
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
                }
                else{
                    t1 =true;
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
                                    $("#param .uidN").attr("data-content", RealId);
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
                else
                {
                    t2 = true;
                }
                */
                //if(t1  && t2)
                if(1)
                {
                    window.location.href = window.location.href.replace(
                        'home',
                        'create/' + uid + '/' + $(this).attr('data-content')
                    )
                }
            });

        });

    </script>
@endsection