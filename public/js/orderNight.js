$(document).ready(function(){
    timeCount($("#timeCount"));
});

var btn;
var clock = '';
var nums = 180;//3min

function timeCount(thisBtn){
    btn = thisBtn;
    btn.html('(3分0秒)');
    clock = setInterval(doLoop, 1000); //一秒执行一次
}

function doLoop(){
    var mins = 0;
    nums--;
    t = nums;
    while(t>=60)
    {
        mins++;
        t=t-60;
    }
    var secs = t;

    if(nums > 0){
        btn.html('('+mins+'分'+secs+'秒)');
    }else{
        //alert('已过期，请重新付款！');
        window.location.href='/home';
    }
}

        $(function() {
            $("#tos").on('click',function(){
                $(".tos-content").modal();
            });

             $("#agreement").click(function(){
                if ($(this).is(':checked')) {
                    $('#toPay').addClass('btn-main');
                    $('#toPay').removeClass('btn-main-third');
                }
                else{
                    $('#toPay').removeClass('btn-main');
                    $('#toPay').addClass('btn-main-third');
                }
            });
             
            function showHumanDay(ts)
            {
                return dateFormat(ts, "yyyy年mm月dd日");
            }
            function showHumanTime(ts)
            {

                return dateFormat(ts, 'yyyy年mm月dd日 HH:MM');
            }
            function showHumanHour(ts)
            {
                return dateFormat(ts, 'HH:MM');
            }

            var startTime = $('#startTime'),
                durationTime = $('#durationTime'),
                endTime = $("#endTime"),
                dateTime = $("#dateTime");
            console.log(startTime.attr('data-content'));

            function checkToPay(){
                return $("#agreement").is(':checked') && $("#totalPrice").text() != "";
            }

            $("#toPay").on('click', function(){
                if(checkToPay() && $("#toPay button").text()!= '下单中...')
                {
                    var r=confirm("提前24小时以上才可取消订单哟，主人确认支付吗")
                if (r==true)
                {
                    //alert('系统维护中，请您明日再订~');
                    //return;
                    $("#toPay button").text('下单中...');

                    temptime = new Date(dateFormat(new Date(), 'yyyy/mm/dd 00:00:00')).getTime();
                    if(dateFormat(new Date(), 'HH') > 5)
                    {

                        temptime += 24*60*60*1000;
                    }
                    console.log('temptime='+temptime);
                    // night
                    var dayShift = document.URL[document.URL.length-1];
                    var st,ed,dt;
                    if(!isNaN(dayShift))
                    {
                        st = $("#startTime").attr('data-content')*1.0 + dayShift*86400;
                        ed = $("#endTime1").attr('data-content')*1.0 + dayShift*86400;
                        dt = temptime/1000 + dayShift*86400;
                    }
                    else{
                        st = $("#startTime").attr('data-content')*1.0;
                        ed = $("#endTime1").attr('data-content')*1.0;
                        dt = temptime/1000;
                    }
                        data = {
                            _token: $("meta[name='csrf-token']").attr('content'),
                            'userId': $("#userId").attr('data-content'),
                            'roomId': $("#roomId").attr('data-content'),
                            'startTime': st,
                            'endTime'  : ed,
                            'duration' : 12,//+durationTime.attr('data-content')/3600000,
                            'price'   : +($('#totalPrice').text()),
                            'date'     : dt|0,
                            'isDay'    : 0
                        };

                    exs =$("#exs").attr("data-content");
                    if( exs != "")
                    {
                        data['uuid'] = JSON.parse(exs)['id'];
                    }
                    console.log(data);
                    console.log(startTime.attr('data-content'));
                    $.ajax({
                        url:'/order/create',
                        data: data,
                        type: 'POST',
                        datatype: 'json',
                        success: function(param){
                            console.log(param);
                            if(param['code'] == '200' && param['param']['code'] == 200)
                            {
                                window.location.href = param['param']['content']['payUrl'];
                            }
                            else
                            {
                                $("#toPay button").text('下单失败');
                                window.location.href=window.location.href;
                            }

                        },
                        error: function (e){
                             $("#toPay button").text('下单失败');
                                window.location.href=window.location.href;
                        }
                    });
                }
                    //window.location.href = 'result/0';
            }else{;}
            });
        });