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
                    'dayPage',
                    'create/day/' + uid + '/' + $(this).attr('data-content')
            )
            });

});
