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

    $("#on-left").on('click',function () {
        if(dayShift>0){
            dayShift--;
            updateDate(dayShift);
        }
    });

    $("#on-right").on('click',function () {
        if(dayShift<7){
            dayShift++;
            updateDate(dayShift);
        }
    });
/*
    $("#on-left").on('mouseout',function(){
        $("#left-arrow").attr("src","../../../storage/order/leftarrow.png");
    });
        
    $("#on-left").on('mouseover',function(){
            $("#left-arrow").attr("src","../../../storage/order/leftarrow-main.png");
    });

    $("#on-right").on('mouseout',function(){
        $("#right-arrow").attr("src","../../../storage/order/rightarrow.png");
    });

    $("#on-right").on('mouseover',function(){
           $("#right-arrow").attr("src","../../../storage/order/rightarrow-main.png");
    });
  */      

function updateDate(dayShift){
                  /*update time*/
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

            /*update btn*/
           roomGroup =  document.URL[document.URL.length-3];
        console.log(roomGroup);
        switch (roomGroup){
            case 'z': //zgy
            startIndex = 1;
            endIndex = 3;
                break;
            case 'h': //dhz9
            startIndex = 7;
            endIndex = 10;
                break;
            case 'f': //frl
            startIndex = 4;
            endIndex = 6;
                break;
            case 'd': //dxy
            startIndex = 1;
            endIndex = 3;
                break;
            default: //dayPage
            startIndex = 1;
            endIndex = 10;
            break;    
        }

            var r;
            for(i=startIndex;i<=endIndex;i++)
            {   
                $.ajax({
                    url: '/isNightBooked/' + $("#"+i).attr("data-content")  + "/"+dayShift,
                    type: 'GET',
                    async : false,
                    success:function(p){
                        r = p.isBooked;
                        //console.log(p.isBooked);
                    },
                    error:function(msg){
                        console.log(msg);
                    }
                });
                console.log('r= '+r);
                //$("#btn"+i).text(r);
                $("#btn"+i).attr('data-content',r);
                if(r==0)
                {
                    $("#btn"+i).text('已订出');
                    $("#btn"+i).addClass('button-occupied');
                    $("#btn"+i).removeClass('button-available');
                }
                else{
                    $("#btn"+i).text('可使用');
                    $("#btn"+i).removeClass('button-occupied');
                    $("#btn"+i).addClass('button-available');
                }
            }
}

    $("#dxy").on('click',function () {
        window.location.href='/getNightRooms/dxy';
    });
    $("#dhzy").on('click',function () {
        window.location.href='/getNightRooms/dhz9';
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

/******************************************/

    var date_time = new Date();  
    date_time.setTime(date_time.getTime());
    var pickerText =new Array(8);
    for (i = 0;i<=7;i++)
    {
        pickerText[i] = (date_time.getMonth()+1) + '月' + date_time.getDate()+'日';
        date_time.setTime(date_time.getTime() + 24*60*60*1000);
    }


    var duration = [
                {
                    text: "今日(" + pickerText[0] + ')',
                    value: 0
                },
                {
                    text: "明日(" + pickerText[1] + ')',
                    value: 1
                },
                {
                    text: pickerText[2],
                    value: 2
                },
                {
                    text: pickerText[3],
                    value: 3
                },
                {
                    text: pickerText[4],
                    value: 4
                },
                {
                    text: pickerText[5],
                    value: 5
                },
                {
                    text: pickerText[6],
                    value: 6
                },
                {
                    text: pickerText[7],
                    value: 7
                },
            ];

            var durationPicker = new Picker({
                data: [duration],
                selectIndex: [0],
                title: '',
                id: 'durationPicker'
            });


            durationPicker.on('picker.select', function(selectedVal, selectedIndex){
                durationTime.attr('data-content', duration[selectedIndex[0]].value);

                dayShift = durationTime.attr("data-content");
                updateDate(dayShift);
            });
            

            durationTime = $('#durationTime');
            
            durationTime.parent().on('click',function () {
                durationPicker.show();
            });

/************************************************/

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