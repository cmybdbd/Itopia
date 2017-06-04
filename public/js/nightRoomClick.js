var dayShift = 0;
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

    $("#lastnight").on('click',function () {
        if(dayShift>0){
            dayShift--;
            var date_time = new Date();
            date_time.setTime(date_time.getTime() + dayShift * 24*60*60*1000);

            var month = date_time.getMonth()+1;
            var day = date_time.getDate();
            var date_td = month+"月"+day+"日";

            date_time.setTime(date_time.getTime()+24*60*60*1000);//tomorrow
            var monthtm = date_time.getMonth()+1;
            var daytm = date_time.getDate();
            var date_tm = monthtm+"月"+daytm+"日";
 
            date_time.setTime(date_time.getTime()-2*24*60*60*1000);//yesterday
            var monthyt = date_time.getMonth()+1;
            var dayyt = date_time.getDate();
            var date_yt = monthyt+"月"+dayyt+"日";
 
            //显示在容器里
            var tm = document.getElementById("tomorrow");
            var yt = document.getElementById("yesterday");
 
            document.getElementById("tomorrow").innerHTML= date_tm;
            document.getElementById("yesterday").innerHTML= date_yt;
            var tags = document.getElementsByName("today");
            for(var i in tags)//对标签进行遍历 
                tags[i].innerHTML= date_td;
        }
    });

    $("#nextnight").on('click',function () {
        if(dayShift<7){
            dayShift++;
            var date_time = new Date();
            date_time.setTime(date_time.getTime() + dayShift * 24*60*60*1000);

            var month = date_time.getMonth()+1;
            var day = date_time.getDate();
            var date_td = month+"月"+day+"日";

            date_time.setTime(date_time.getTime()+24*60*60*1000);//tomorrow
            var monthtm = date_time.getMonth()+1;
            var daytm = date_time.getDate();
            var date_tm = monthtm+"月"+daytm+"日";
 
            date_time.setTime(date_time.getTime()-2*24*60*60*1000);//yesterday
            var monthyt = date_time.getMonth()+1;
            var dayyt = date_time.getDate();
            var date_yt = monthyt+"月"+dayyt+"日";
 
            //显示在容器里
            var tm = document.getElementById("tomorrow");
            var yt = document.getElementById("yesterday");
 
            document.getElementById("tomorrow").innerHTML= date_tm;
            document.getElementById("yesterday").innerHTML= date_yt;
            var tags = document.getElementsByName("today");
            for(var i in tags)//对标签进行遍历 
                tags[i].innerHTML= date_td;
        }
    });

    $("#on-left").mouseover(function(){
        $("#left-arrow").attr("src","../../../storage/order/leftarrow-main.png");
    });
        
    $("#on-left").mouseout(function(){
        $("#left-arrow").attr("src","../../../storage/order/leftarrow.png");
    });

    $("#on-right").mouseover(function(){
        $("#right-arrow").attr("src","../../../storage/order/rightarrow-main.png");
    });
        
    $("#on-right").mouseout(function(){
        $("#right-arrow").attr("src","../../../storage/order/rightarrow.png");
    });

    $("#dxy").on('click',function () {
        window.location.href='/getNightRooms/dxy';
    });
    $("#dhzy").on('click',function () {
        window.location.href='/getNightRooms/dhzy';
    });
    $("#kyxq").on('click',function () {
        window.location.href='/getNightRooms/kyxq';
    });
    $("#frl").on('click',function () {
        window.location.href='/getNightRooms/frl';
    });
    $("#zgy").on('click',function () {
        window.location.href='/getNightRooms/zgy';
    });
    $("#allHome").on('click',function () {
        window.location.href='/nightPage';
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
                window.location.href = '../create/night/' + uid + '/' + $(this).attr('data-content') + '/' + dayShift;
            /*window.location.href = window.location.href.replace(
                'nightPage',
                'create/night/' + uid + '/' + $(this).attr('data-content')
            )*/
        }
    });
});