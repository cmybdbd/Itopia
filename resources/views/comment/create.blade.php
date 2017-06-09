<!--comment create page
6.2 UI 1.0 textarea word counter added
       1.1 UI update
-->
@extends('layout.app')
@section('style')
    <link rel="stylesheet" href="{{url('css/starrr.css')}}">
    <style>
        .mainTag{
            display: none;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .mainTag p{
            display: flex;
            align-items: center;
            /*border: 1px solid var(--used-color);*/
            border: 1px solid #cccccc;
            border-radius: 17px;
            line-height: 1.5em;
            padding: 6px 24px;

        }

        .tagDetail > div{
            display: none;
        }
        .tagDetail > div.show{
            display: block;
        }
        .tag{
            margin-top: 0.3em;
            margin-bottom: 0.3em
        }
        .tag p{
            font-size: 0.8em;
            display: inline-block;
            /*border: 1px solid var(--used-color);*/
            border: 1px solid #cccccc;
            border-radius: 150px;
            line-height: 1.2em;
            text-align: center;
            padding: 4px 0px 6px 0px;
            margin: 0.25em;
            width: 30%;
        }
        p.selected{
            /*border-color: var(--main-color);
            background-color: var(--main-color);*/
            border-color: #1dccb8;
            background-color: #1dccb8;
            color: white;
        }
        .custom-textarea{
            margin-top:18px;
        }
    </style>
@endsection
@section('content')
    <div class="font-l"
        style="background-color:#eeeeee;width:100%;height: 44px;margin:0;display:flex;align-items: center;justify-content: center">您的评价
    </div>
    <!--<hr class="mysplit"-->
    <div class="mybox" style="box-shadow:none;">
        <div class="mybox" style="box-shadow:none;">
            <div class="flex-center m-color font-l">
                感谢主人使用蜗壳空间
            </div>
            <hr class="mysplit" style="margin-top:6.4px;">
            <div class="flex-center b-color font-m">
            希望主人能留下对iTOPIA的意见建议(*￣︶￣*)
            </div>
            <div class="flex-center b-color font-m">
            填写就有机会获得小蜗送出的多小时免费体验哦
            </div>
            <div class="flex-center" style="height:90px;">
                <div class="starrr"></div>
            </div>

            <div class="tags">
                <div class="mainTag">
                    <p style="cursor:pointer;">地理位置不够好</p>
                    <p style="cursor:pointer;">安全设施不够好</p>
                    <p style="cursor:pointer;">房间设施不够好</p>
                    <p style="cursor:pointer;">微信平台不好用</p>
                </div>
                <div class="tagDetail">
                    <div>
                        地理位置
                        <div class="tag">
                            <p style="cursor:pointer;">距离较远</p>
                            <p style="cursor:pointer;">不容易找到</p>
                            <p style="cursor:pointer;">周边交通不便</p>
                        </div>
                    </div>
                    <div>
                        安全设施
                        <div class="tag">
                            <p style="cursor:pointer;">密码锁不方便</p>
                            <p style="cursor:pointer;">安全无保障</p>
                        </div>
                    </div>
                    <div>
                        房间设施
                        <div class="tag">
                            <p style="cursor:pointer;">家具种类少</p>
                            <p style="cursor:pointer;">房间卫生差</p>
                            <p style="cursor:pointer;">设施损坏</p>
                            <p style="cursor:pointer;">布局不合理</p>
                            <p style="cursor:pointer;">隔音效果差</p>
                            <p style="cursor:pointer;">缺少娱乐功能</p>
                        </div>
                    </div>
                    <div>
                        微信平台
                        <div class="tag">
                            <p style="cursor:pointer;">操作复杂</p>
                            <p style="cursor:pointer;">系统漏洞</p>
                            <p style="cursor:pointer;">客服不及时</p>
                        </div>
                    </div>

                </div>
            </div>

            <textarea class="form-control custom-textarea" name="" id="commentText" cols="30" rows="6" onkeyup="countChar(this)"></textarea>
            <p style="margin-top:12px;"><span id="wordcount">0</span>/100，最少输入15字</p>
        </div>
    </div>
    <button class="btn btn-block btn-default btn-main" id="commit">提交</button>


    <div id="param">
        <div id="userId" data-content="{{\Illuminate\Support\Facades\Auth::user()->id}}"></div>
        <div id="orderId" data-content="{{$oid}}"></div>
    </div>
@endsection
@section('scripts')
    <script src="{{url('/js/starrr.js')}}"></script>
    <script>
        var t1=0,t2=0;
        var starNum = -1;
        function countChar(val){
            var len = val.value.length;
            var num;
            if (len >= 100) {
                val.value = val.value.substring(0, 100);
                num = 100;
            } else {
                num = len;
            }
            if(num<15)
            {
                $("#wordcount").css('color','red');
                if(starNum !=5)
                {
                    idCommit.addClass('disabled');
                    idCommit.removeClass('m-color');
                }
            }
            else{
                $("#wordcount").css('color','#777');
                t1 = 1;
                if(t1&&t2)
                {  
                    idCommit.removeClass('disabled');
                    idCommit.addClass('m-color');
                }
            }
            $("#wordcount").html(num);
        };
        //var a = getElementById("#commentText");
        //countChar(a);
        $(function () {
            idCommit =$("#commit");
            idCommit.addClass('disabled');
            $('.starrr').starrr({
                change: function(e, value){
                    t2=1;
                    starNum = value;
                    if(t1&&t2 || starNum == 5)
                    {
                        idCommit.removeClass('disabled');
                        idCommit.addClass('m-color');
                    }
                    console.log(starNum);
                    if(value != 5)
                    {
                        idCommit.addClass('disabled');
                        if(t1&&t2)
                        {
                            idCommit.removeClass('disabled');
                            idCommit.addClass('m-color');
                        }
                        $(".mainTag").css('display','flex');
                    }
                    else
                    {
                        idCommit.removeClass('disabled');
                        idCommit.addClass('m-color');
                        $(".show").removeClass('show');
                        $(".selected").removeClass('selected');
                        $(".mainTag").css('display','none');
                    }
                }
            });
            $("#commit").on('click', function () {
                if(starNum == -1)
                {
                    return;
                }
                seletedp =$("p.selected");
                selectedTag = [];
                for (i = 0 ;i < seletedp.length;i++)
                {
                    selectedTag.push(seletedp[i].innerText);
                }
                $.ajax({
                    url: 'create',
                    data: {
                        _token:$("meta[name='csrf-token']").attr('content'),
                        'userId': $("#userId").attr("data-content"),
                        'orderId': $("#orderId").attr('data-content'),
                        'starNum': starNum,
                        'tag': selectedTag,
                        'text': $("textarea").val()
                    },
                    type: 'POST',
                    success:function (res) {
                        console.log(res);
                        if(res.code == 200)
                        {
                            window.location.href = window.location.href.replace(
                                /comment.*/,
                                'commentResult'
                            );
                        }
                    }
                });

            });
            $("#return").on("click",function () {
                window.location.href = window.location.href.replace(
                    /comment.*/,
                    'home'
                );
            });
            $(".tags p").on('click',function(){
                $(this).toggleClass('selected');
            })
            p = $(".mainTag > p");
            tdiv = $(".tagDetail>div");
            $(p[0]).on('click',function(){
                $(tdiv[0]).toggleClass('show')
            })

            $(p[1]).on('click',function(){
                $(tdiv[1]).toggleClass('show')
            })

            $(p[2]).on('click',function(){
                $(tdiv[2]).toggleClass('show')
            })

            $( p[3]).on('click',function(){
                $(tdiv[3]).toggleClass('show')
            })


        });


    </script>
@endsection