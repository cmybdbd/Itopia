@extends('layout.app')
@section('style')
    <link rel="stylesheet" href="{{url('css/starrr.css')}}">
    <style>
        .starrr{
            margin-top: 1em;
            margin-bottom: 1em;
        }
        .starrr  a{
            font-size:3em;
            color: var(--main-color);
        }
        .mainTag{
            display: none;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .mainTag p{
            display: flex;
            align-items: center;
            border: 1px solid var(--used-color);
            border-radius: 10px;
            line-height: 1.5em;
            padding: 0.4em 1em;

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
            border: 1px solid var(--used-color);
            border-radius: 150px;
            line-height: 1.2em;
            text-align: center;
            padding: 0.4em 0em;
            margin: 0.25em;
            width: 30%;
        }
        p.selected{
            border-color: var(--main-color);
            background-color: var(--main-color);
            color: white;
        }
    </style>
@endsection
@section('content')
    <div>
        <div class="mybox">
            <div class="flex-center m-color font-b">
                感谢主人使用iTOPIA空间
            </div>
            <hr class="mysplit">
            <div class="flex-center b-color">
            希望主人能留下对iTOPIA的意见建议(*￣︶￣*)
            </div>
            <div class="flex-center b-color">
            填写就有机会获得小 i 送出的多小时免费体验哦
            </div>
            <div class="flex-center">
                <div class="starrr"></div>
            </div>

            <div class="tags">
                <div class="mainTag">
                    <p>地理位置不够好</p>
                    <p>安全设施不够好</p>
                    <p>房间设施不够好</p>
                    <p>微信平台不好用</p>
                </div>
                <div class="tagDetail">
                    <div>
                        地理位置
                        <div class="tag">
                            <p>距离较远</p>
                            <p>不容易找到</p>
                            <p>周边交通不便</p>
                        </div>
                    </div>
                    <div>
                        安全设施
                        <div class="tag">
                            <p>密码锁不方便</p>
                            <p>安全无保障</p>
                        </div>
                    </div>
                    <div>
                        房间设施
                        <div class="tag">
                            <p>家具种类少</p>
                            <p>房间卫生差</p>
                            <p>设施损坏</p>
                            <p>布局不合理</p>
                            <p>隔音效果差</p>
                            <p>缺少娱乐功能</p>
                        </div>
                    </div>
                    <div>
                        微信平台
                        <div class="tag">
                            <p>操作复杂</p>
                            <p>系统漏洞</p>
                            <p>客服不及时</p>
                        </div>
                    </div>

                </div>
            </div>

            <textarea class="form-control custom-textarea" name="" id="" cols="30" rows="6"></textarea>
        </div>
        <div class="lr">
            <button id="commit" class="btn btn-block btn-default m-color font-b">提 交</button>
        </div>
    </div>




    <div id="param">
        <div id="userId" data-content="{{\Illuminate\Support\Facades\Auth::user()->id}}"></div>
        <div id="orderId" data-content="{{$oid}}"></div>
    </div>
@endsection
@section('scripts')
    <script src="{{url('/js/starrr.js')}}"></script>
    <script>
        $(function () {
            var starNum = 0;
            $('.starrr').starrr({
                change: function(e, value){
                    starNum = value;
                    console.log(starNum);
                    if(value != 5)
                    {
                        $(".mainTag").css('display','flex');
                    }
                    else
                    {
                        $(".show").removeClass('show');
                        $(".selected").removeClass('selected');
                        $(".mainTag").css('display','none');
                    }
                }
            });
            $("#commit").on('click', function () {
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