var dayShift = 0;
var td = new Array(7);
var tdbtn = new Array(7);
var tdstate = new Array(7);
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



    var validatePhone =$("#validatePhone");
    var phoneN = $("#phoneN");
    validatePhone.on('shown.bs.modal', function () {
        phoneN.focus();
    });


    $("#useToday").on('click',function () {
        dayShift = 0;
        $("#useToday").addClass("nav-active");
        $("#useTomorrow").removeClass("nav-active");
        
        for(var j=1;j<=6;j++)
        {
             if(td[j]!=null){
                str = $('#nextdaytime'+j).attr('data-content');
                document.getElementById('btn'+j).innerHTML = td[j];
                document.getElementById('roomState'+j).innerHTML = tdstate[j];
                state = $('#roomState'+j).attr('data-content');
                if(state == 0)
                {
                    $('#roomState' + j).addClass('button-available');
                    $('#roomState' + j).removeClass('button-occupied');
                }
                else{
                    $('#roomState' + j).removeClass('button-available');
                    $('#roomState' + j).addClass('button-occupied');
                }
                $('#btn' + j).attr('data-content',tdbtn[j]);
                //console.log(td[j]);
            }
        }
    });
    
    $("#useTomorrow").on('click',function () {
        var date = new Date();
        dayShift = 1;
        $("#useTomorrow").addClass("nav-active");
        $("#useToday").removeClass("nav-active");
            
        for(var j=1;j<=6;j++)
        {
            //console.log('j ='+ j +  $('#nextdaytime'+j).attr('data-content'));
            ndt = $('#nextdaytime'+j).attr('data-content');
            tp = $('#roomtype'+j).attr('data-content');
            console.log(document.getElementById('btn'+j).innerHTML);
            td[j] = document.getElementById('btn'+j).innerHTML;
            tdbtn[j] =  $('#btn' + j).attr('data-content');
            tdstate[j] = document.getElementById('roomState'+j).innerHTML; 
            
            tmp = '可预约<span name="timeS" class="m-color">明天'+ ndt +'</span>使用';
            document.getElementById('btn'+j).innerHTML = tmp;
            if(ndt!='-1')
            {   t=ndt.split(":");
                a = t[0]*1.0 + t[1]/60;
            }
            else
                a=25;
            if(a<=21.5-tp/2.0){
                $('#roomState'+j).addClass('button-available');
                $('#roomState'+j).removeClass('button-occupied');
                $('#roomState'+j).text('可预订');
                $('#btn' + j).attr('data-content','1');
            }
            else{
                $('#roomState'+j).removeClass('button-available');
                $('#roomState'+j).addClass('button-occupied');
                $('#roomState'+j).text('已订满');
                $('#btn' + j).attr('data-content','0');
                $('#btn' + j).text('已约满');
            }
            //console.log(a);
        }
    });

    $("#dxy").on('click',function () {
        window.location.replace('/getDayRooms/dxy');
        //window.location.href='/getDayRooms/dxy';
    });
    $("#dhzy").on('click',function () {
        window.location.replace('/getDayRooms/dhzy');
    });
    $("#kyxq").on('click',function () {
        window.location.replace('/getDayRooms/kyxq');
    });
    $("#frl").on('click',function () {
        window.location.replace('/getDayRooms/frl');
    });
    $("#zgy").on('click',function () {
        window.location.replace('/getDayRooms/zgy');
    });
    $("#allHome").on('click',function () {
        window.location.replace('/dayPage');
    });
    var uid = $("#param .uid").attr('data-content');
    $("#myOrder").on('click',function () {
        window.location.href = window.location.href.replace('home','orderList/'+uid);
    });
    $(".roomItem").on('click', function () {
        var t1 =false,t2=false;
        
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
        
        if(t1  && t2)//if(1)              
        {
            if($('#btn' + $(this).attr('id')).attr('data-content')==1)
                window.location.href = '../create/day/' + uid + '/' + $(this).attr('data-content') + '/' + dayShift;
            /*window.location.href = window.location.href.replace(
                'create/day/' + uid + '/' + $(this).attr('data-content')
            )*/
        }
    });
});

/*$(function () {
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
                    'dayPage',
                    'create/day/' + uid + '/' + $(this).attr('data-content')
            )
            });

});*/
