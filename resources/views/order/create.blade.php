@extends('layout.app')
@section('style')
    <style>
        .nav-pills > li.active{
            border: 1px var(--main-color) solid;
            border-radius: 4px;
            box-shadow: 0 1px 10px #eeeeee;
        }
        .nav-pills > li.active > a{
            color: var(--main-color) !important;
            background: transparent !important;
        }
        .nav-pills > li{
            width: 44%;

            border: 1px var(--used-color) solid;
            border-radius: 4px;
            box-shadow: 0 1px 10px #eeeeee;
        }
        .nav-pills > li > a{
            color: var(--used-color);
            background: transparent !important;
        }
        .nav-pills > li >a >div{
            text-align: center;
        }
        .present{
            text-align: right;
        }
        .scrollPicker, .noPicker{
            flex-grow: 1;
            text-align:right;
        }
        .selectPanel{

            margin-bottom: 1vh; !important;
            padding-left:0.8em;
            padding-top: 1em;
            padding-bottom: 1em;
            padding-right: 0.8em;
            position: relative;
            display: flex;
        }

        .cbox{
            position: relative;
        }
        #agreement{
            opacity:0;
        }
        .cbox label{
            position: absolute;
            width: 1.2em;
            height: 1.2em;
            top: 0.2em;
            left: -1px;
            background: white;
            border: 1px solid var(--b-font-color);
            border-radius:5px;
        }
        .cbox label:after{
            opacity : 0;
            content: '';
            position: absolute;
            width: 0.85em;
            height: 0.4em;
            background: transparent;
            top: 0.22em;
            left: 0.15em;
            border: 1px solid var(--main-color);
            border-top: none;
            border-right: none;
            transform:rotate(-45deg);
        }
        .cbox input[type=checkbox]:checked + label:after{
            opacity: 1;
        }

        i.fa{
            display: flex;
            align-items:center;
            margin-left:0.5em;
            color: var(--used-color)
        }
    </style>
@endsection
@section('content')
    <div class="mybox">
        <div class="f-color font-b">
            {{$room->title}}
        </div>
        <div class="b-color">
            地址：{{$room->address}}
        </div>
    </div>

    <div style="margin: 3vw;">
        <div class="m-color font-m">
            选择使用方式
        </div>
        <ul class="nav nav-pills" role="tablist" style="margin-top: 2vh;display:flex;justify-content: space-between">
            <li role="presentation" class="active custom-li ">
                <a href="#byHour" aria-controls="byHour" role="tab" id="useHour"
                data-toggle="pill">
                    <div>分时使用</div>
                    <div>(11:00-23:00)</div>
                    <div id="hourPrice" data-content="{{$room->hourPrice}}">
                        {{$room->hourPrice}}/小时
                    </div>
                </a>
            </li>
            <li role="presentation" class="custom-li">
                <a href="#byNight" aria-controls="byNight" role="tab" id="useNight"
                data-toggle="pill">
                    <div>预约包夜</div>
                    <div>(23:30-次日10:30)</div>
                    <div id="nightPrice" data-content="{{$room->nightPrice}}">
                        {{$room->nightPrice}}/夜
                    </div>
                </a>
            </li>
        </ul>
        <div class="tab-content" style="margin-top: 3vw;">
            <div class="m-color font-m">选择使用时间</div>
            <div role="tabpanel" class="tab-pane active" id="byHour">

                <div class="mybox selectPanel">
                    开始时间
                    <div id="startTime" class="scrollPicker" data-content="{{$startDayTime}}">

                    </div>
                    <i class="fa fa-chevron-right" ></i>
                </div>

                <div class="mybox selectPanel" style="display:flex;">
                    使用时长
                    <div id="durationTime" class="scrollPicker" data-content="3600000" >
                        1 小时
                    </div>
                    <i class="fa fa-chevron-right" ></i>
                </div>
                <div class="mybox selectPanel">
                    结束时间
                    <div id="endTime" class="present noPicker">

                    </div>
                    <i class="fa fa-chevron-right"></i>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane " id="byNight">
                <div class="mybox selectPanel">
                    日期
                    <div id="dateTime" class="scrollPicker" data-content="{{$startNightTime}}"></div>
                    <i class="fa fa-chevron-right" ></i>
                </div>
            </div>
        </div>

        <div class="m-color font-m" style="margin-top: 3vw;">
            订单结算
        </div>
        <div class="mybox selectPanel">
            <span>总计</span>
            <div class="present" style="color: var(--price-color);flex-grow:1">
                <span id="totalPrice"></span>元
            </div>
        </div>
    </div>
    <div class="cbox b-color font-s" style="margin: 3vw;">
        <input type="checkbox" id="agreement" style="margin:0">
        <label for="agreement"></label>本人已获悉并同意<span id="tos">《iTOPIA即时私人空间用户服务协议》</span>
    </div>
    <div id="toPay" class="myTail font-b m-color" style="height:3em;margin-top: 2vh;box-shadow:0 -1px 6px #eeeeee">
        <button style="width: 100%;height: 100%; border:none;background:transparent">去支付</button>
    </div>

    <div class="modal fade bs-example-modal-sm tos-content" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div style="margin-left:5%;margin-right:5%;">
                        <div style="height: 36em;overflow: scroll;font-size:0.9em">
                            <h3>用户服务协议</h3>
                            <p>
                                北京闪银奇异科技有限公司（以下称“我司”）根据您的使用需求向您提供分时租房服务，您访问和使用有关网站、服务、微信公众号、应用程序提供的即时私人房间预约服务适用本用户服务协议（以下简称“协议”）。
                            </p>
                            提示条款
                            <p>
                                【审慎阅读】您在申请注册流程中点击同意本协议之前，应当认真阅读本协议。请您务必审慎阅读、充分理解各条款内容，特别是免除或者限制责任的条款、法律适用和争议解决条款。如您对协议有任何疑问，可向iTOPIA平台客服咨询。
                            </p>
                            <p>
                            【签约动作】当您按照注册页面提示填写信息、阅读并同意本协议且完成全部注册程序后，即表示您已充分阅读、理解并接受本协议的全部内容，并与iTOPIA达成一致，成为iTOPIA即时私人空间平台的用户。阅读本协议的过程中，如果您不同意本协议或其中任何条款约定，您应立即停止注册程序。
                            </p>
                            <h5>第一条 合同订立</h5>
                            <p>
                                本协议由您与iTOPIA即时私人空间平台的出租方同缔结，本协议对您与iTOPIA的出方均具有合同效力。您理解并同意，您通过iTOPIA平台使用我司的服务，即视为接受本《用户服务协议》并依据本协议与我司达成了合约。
                            </p>
                            <h5>第二条 用户注册</h5>
                            2.1如您申请使用我司提供的服务，请您在微信中关注“iTOPIA即时私人空间”微信公众号，或者下载我司提供的相关应用程序进行用户注册，注册时您必须保证提供真实有效的身份证明、移动电话号码等基本信息。您可以通过程序注册、手机验证等步骤注册成为iTOPIA平台注册用户，并拥有自己的账户。在使用过程中，您不得转让该账户，也不得许可或者协助他人使用您的账户使用预约服务，否则由此产生的一切责任均由您承担连带责任。
                            <br>
                            2.2如果您是代表个人签订本协议，您应具有完全民事行为能力；如果您是代表法人实体签订本协议，您应获得法人实体的合法授权，如您能够完整的填写法人实体的相关信息并完成全部注册步骤的，我司自动视为您已取得法人实体的授权。

                            <h5>第三条 保证及承诺</h5>
                            3.1您保证，您向我司提供的信息真实、准确、完整。我司有权随时验证您所提供的信息，并有权综合您的个人情况及我司规则选择拒绝向您提供分时租房服务服务或拒绝您使用相关网站、服务、应用程序。
                            <br>
                            3.2您的账户由您自行设置并由您负责保管，iTOPIA任何时候均不会主动要求您提供您的账户信息。因此，请务必保管好您的账户，账户安全由您自行负责，请确保您在每个上网时段结束时退出登录并以正确步骤离开iTOPIA平台。如果您的账户因您主动泄露或遭受他人攻击、诈骗等行为而给您和他人造成任何损失及后果，该等损失和后果均由您自行承担。
                            除iTOPIA存在过错外，您应对通过您的账户从事的所有行为和结果（包括但不限于预约房间、退还房间、发布信息、接收信息、开放通讯录等）负责。
                            如发现任何第三人未经授权使用您的账户登录iTOPIA平台或其他可能导致您账户遭窃、遗失的情况，建议您立即通知iTOPIA平台。您理解iTOPIA对您的任何请求采取行动均需要合理时间，除iTOPIA存在过错外，iTOPIA对在采取行动前已经产生的后果不承担任何责任。
                            <br>
                            3.3您承诺不会利用iTOPIA平台进行任何违法行为或下述行为：
                            <p>a.利用技术手段故意访问、记录、盗取、传播iTOPIA的数据和相关信息；</p>
                            <p>b.以任何方式侵犯他人的合法权益；</p>
                            <p>c.干扰或破坏iTOPIA平台、其服务器或其网络；</p>
                            <p>d.未经合法授权而截取、篡改、收集、储存、使用、传播或删除其他用户的个人信息或提供的其他信息；</p>
                            <p>e.其他未经合法授权的行为。</p>
                            <br>
                            3.4 您承诺在使用iTOPIA平台服务时，在iTOPIA平台所发布和传播的内容不得包含下述信息：
                            <p>a.违反宪法确定的基本原则的；</p>
                            <p>b.危害国家统一、主权和领土完整的；</p>
                            <p>c.泄露国家秘密，危害国家安全，损害国家荣誉和利益的；</p>
                            <p>d.煽动民族仇恨、民族歧视，破坏民族团结，侵害民族风俗、习惯的；</p>
                            <p>e.违背国家宗教政策，宣扬邪教、迷信的；</p>
                            <p>f.扰乱社会秩序，破坏社会稳定的；</p>
                            <p>g.宣扬淫秽、赌博、暴力、教唆犯罪的；</p>
                            <p>h.侮辱、诽谤、恐吓、涉及他人隐私等侵害他人合法权益的；</p>
                            <p>i.侵犯他人知识产权或涉及第三方商业秘密及其他专有权利的；</p>
                            <p>j.存在可能破坏、篡改、删除、影响iTOPIA平台任何系统正常运行或未经授权秘密获取Itopia平台及其他用户的数据、个人资料的病毒、木马、爬虫等恶意软件、程序代码的；</p>
                            <p>k.危害社会公德，诋毁民族优秀文化的；</p>
                            <p>l.国家法律、法规或政策禁止的其他内容。</p>

                            <h5>第四条  用户信息的保护及授权</h5>
                            4.1您同意并授权我司收集您的以下个人信息：
                            <p>a.身份识别信息，包括但不限于您的姓名、身份证明、联系地址、电话号码等信息；</p>
                            <p>b.您所处的地理位置信息；</p>
                            <p>c.平台操作信息，包括但不限于您的IP地址、设备型号、设备标识符、操作系统版本信息；</p>
                            <p>d.预约和使用信息，包括但不限于您的预约时间、预约地点和使用情况；</p>
                            <p>e.支付信息，包括但不限于您的支付时间、支付金额、支付工具、银行账户及支付账户信息；</p>
                            <p>f.个人信用信息，包括但不限于关于您的任何信用状况、信用评分、信用报告信息；</p>
                            <p>g.其他根据我司具体产品及服务的需要而收集的您的个人信息，包括但不限于您对我司及我司的产品或服务的意见、建议、您曾经使用或经常使用的移动应用软件以及使用场景和使用习惯等信息。</p>
                            4.2 您授权我司出于以下用途使用您的个人信息：
                            <p>a.向您提供iTOPIA平台的产品及服务，并进行iTOPIA平台相关网站及APP的管理和优化；</p>
                            <p>b.提升和改善iTOPIA平台现有产品及服务的功能和质量，包括但不限于产品及服务内容的个性化定制及更新；</p>
                            <p>c.开展iTOPIA平台产品及服务相关的市场活动，向您推送最新的市场活动信息及优惠方案；</p>
                            <p>d.设计、开发、推广全新的产品及服务；</p>
                            <p>e.提高iTOPIA平台产品及服务安全性，包括但不限于身份验证、客户服务、安全防范、诈骗监测、存档和备份；</p>
                            <p>f.协助行政机关、司法机构等有权机关开展调査，并遵守适用法律法规及其他向有权机关承诺之义务；</p>
                            <p>g.在收集信息之时所通知您的用途以及与上述任何用途有关的其他用途。</p>

                            <h5>第五条  违约与赔偿</h5>
                            5.1当您存在下列行为时，视为您违约：
                            <p>a.iTOPIA在用户认证信息复核过程中发现用户提供的认证信息不全、无效或虚假；</p>
                            <p>b.用户发生危及交易安全或账户安全的行为；</p>
                            <p>c.用户扰乱iTOPIA平台秩序，以任何方式可以规避iTOPIA的各类规则和市场管控措施，或者以不正当的方式获取、使用iTOPIA平台资源的行为；</p>
                            <p>d.用户在预约房间中进行赌博、卖淫等非法活动；</p>
                            <p>e.用户违反本协议的其他规定。</p>
                            如发生上述违约行为，iTOPIA对后果不承担法律责任，其后果及责任由您及相关责任人自行承担。您同意，iTOPIA有权调查用户违约情况，并采取停止服务、关闭用户账户、公示警告、终止协议等违规处理措施，iTOPIA没有义务在采取违规处理前通知用户。
                            iTOPIA可将对您上述违约行为处理措施信息以及其他经国家行政或司法机关生效法律文书确认的违法信息在iTOPIA平台上予以公示。
                            <br>
                            5.2在房间使用过程中，如您的行为使iTOPIA遭受损失（包括房间损坏的直接经济损失、商誉损失及对外支付的赔偿金、和解款、律师费、诉讼费等间接经济损失），您应赔偿iTOPIA的上述全部损失。如您的行为使iTOPIA遭受第三人主张权利，iTOPIA可在对第三人承担金钱给付等义务后就全部损失向您追偿。

                            <h5>第六条  付款</h5>
                            6.1您同意并认可iTOPIA平台现行公示或未来更新的有关服务价格标准，您可以在平台上查看相关价格。这些价格可能会随时更新，您必须自行留意服务价格。
                            <br>
                            6.2您在使用服务后应当根据iTOPIA平台的提示及时支付费用。逾期不支付费用且经催告后仍不履行支付义务的，我司有权拒绝您继续使用服务，同时您知悉并同意我司有权视情况将您的违约信息提交第三方征信机构。
                            <br>
                            6.3您在iTOPIA平台可以使用您的第三方电子支付账户（包括但不限于微信支付账户或支付宝支付账户）进行支付。处理您使用服务相关的付款时，除了受到本《用户服务协议》的约束之外，还要受电子支付服务商及信用卡/借记卡发卡行的条款和政策的约束。我司对于电子支付服务商或银行等支付机构发生的失误不承担责任。我司将获取与您服务相关的特定交易明细。在使用这些信息时，我司将严格遵守本协议约定的用户信息保护义务。

                            <h5>第七条  知识产权政策</h5>
                            在使用我司服务过程中，您认可并应尊重iTOPIA平台的知识产权，不得通过任何手段及形式侵犯iTOPIA平台的知识产权，否则应承担相应的损失赔偿及法律责任。

                            <h5>第八条  协议期限</h5>
                            <p>8.1我司和您订立的此份服务协议是无固定期限合约。</p>
                            <p>8.2您有权随时通过删除应用程序，取消公众号关注、注销账号等行为来终止协议，您一旦从事前述行为我司将禁止您使用iTOPIA平台应用程序及我司提供的具体服务。</p>
                            <p>8.3 如果您做出以下行为，我司有权随时单方终止本服务协议并立即禁止您使用应用程序和服务：</p>
                                a.您触犯或违反本《用户服务协议》中的任何条款；
                                <br>
                                b.我司认为，您滥用服务。
                            <p>我司没有义务提前通知您协议终止。本服务协议终止之后，我司将按照本《用户服务协议》约定的方式通知您。</p>

                            <h5>第九条  不可抗力</h5>
                            遭受不可抗力事件的一方可暂停中止履行本协议下的义务直至不可抗力事件的影响消除为止，并且无需为此承担违约责任，但应尽最大努力克服该事件，减少损失的扩大并及时将可不抗力事件进行通知。不可抗力指各方不能控制、不可预见或即使预见亦无法避免的事件，该事件足以妨碍、影响或延误任何一方根据本协议履行其全部或部分义务。该事件包括但不限于自然灾害、战争、政策变化、计算机病毒、黑客攻击或电信机构服务中断造成的事件。

                            <h5>第十条  其他</h5>
                            10.1如果本《用户服务协议》的某一（些）条款被认定为无效而其他条款仍能保持有效且其执行不受影响，我司可决定是否继续履行该等其他条款。
                            <br>
                            10.2我司保留随时修改或替换本《用户服务协议》条款，或者更改、暂停或中断服务或应用程序（包括但不限于，任何功能、数据库或内容的可用性）的权利。届时，我司只需在网站及应用程序平台上发布通告或发送通知。如果您不同意我司对本《用户服务协议》所做的修改，您有权停止使用服务。如果您继续使用服务，视为您接受我司对本《用户服务协议》的修改。

                            <h5>第十一条  管辖约定</h5>
                            本《用户服务协议》适用中国法律。本协议签订地为北京市朝阳区，关于本《用户服务协议》的违约、终止、履行、解释或有效性，以及产生的任何冲突、赔偿或纠纷，由北京闪银奇异科技有限公司所在地人民法院管辖。

                            <h5>第十二条 解释及未尽事宜</h5>
                            <p>本《用户服务协议》条款的最终解释权属于北京闪银奇异科技有限公司所有。</p>
                            <p>本协议未尽事宜以iTOPIA平台规则为准。</p>
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


    <div id="param">
        <div id="userId" data-content="{{\Illuminate\Support\Facades\Auth::id()}}"></div>
        <div id="roomId" data-content="{{$room->id}}"></div>
        <div id="exs" data-content="{{$olderOrder}}"></div>
        <div id="isUsing" data-content="{{$room->isUsing()}}"></div>
        <div id="nextTime" data-content="{{$room->nextTime()}}"></div>
        <div id="usingNight" data-content="{{$room->usingNight()}}"></div>
    </div>
@endsection
@section('scripts')

    <script>
        $(function() {
            $("#tos").on('click',function(){
                $(".tos-content").modal();
            });
            $("#useHour").parent().click(function(e){
                $.ajax({
                    url: '/updatePageView/useHour',
                    type:'POST',
                    data: {
                        _token: $("meta[name='csrf-token']").attr('content')
                    }
                });
            })
            $("#useNight").parent().click(function(e){
                $.ajax({
                    url: '/updatePageView/useNight',
                    type:'POST',
                    data: {
                        _token: $("meta[name='csrf-token']").attr('content')
                    }
                });
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
            //var startts = startTime.attr('data-content')*1000;
            var startts = $("#nextTime").attr('data-content')*1000;
            var isUsing = $("#isUsing").attr('data-content');
            var usingNight = JSON.parse($("#usingNight").attr("data-content"));
            if(startts == 0)
            {
                $("#useNight").click();
                $("#useHour").parent().click(function(e){
                    e.preventDefault();
                    return false;
                })
                startts = new Date(dateFormat(new Date(), 'yyyy/mm/dd 00:00:00')).getTime();
            }

            var todayts, tomorrowts;
            var selectedDay = todayts, selectedTime;
            var istomorrow = false;
            if(dateFormat(startts, 'dd') > dateFormat(new Date(), 'dd'))
            {
                istomorrow = true;
            }

            todayts = new Date(dateFormat(startts, 'yyyy/mm/dd 00:00:00')).getTime();
            if(istomorrow)
            {
                todayts = todayts -24*60*60*1000;
            }

            tomorrowts = todayts + 24 * 60 * 60 * 1000;
            console.log(istomorrow)
            console.log(showHumanTime(startts));
            console.log(showHumanTime(todayts));


            startTime.text((istomorrow?'明天 ':'今天 ')+ showHumanHour(startts))
                .attr("data-content", startts);
            updateEndTime();
            updatePrice(0);

            var daytime = [{
                text: '今天',
                value: 0,
                sub: [
                ]
            },{
                text: '明天',
                value: 1,
                sub: [

                ]
            }];
            var weekday = [
                '星期天',
                '星期一',
                '星期二',
                '星期三',
                '星期四',
                '星期五',
                '星期六'
            ];
            var date = [];
            for(i = 0;i < 2; i++)
            {
                date[i] = {
                    text: daytime[i].text + ' ' + dateFormat(todayts+i*24*60*60*1000,'mm月dd日'),
                    value: i
                };
            }
            console.log(startts);
            for(i = 2;i < 7; i++)
            {
                temp = new Date(startts + i * 24*60*60*1000);

                date[i] = {
                    text: weekday[temp.getDay()] + ' ' + dateFormat(temp,'mm月dd日'),
                    value: i
                };
                console.log(date[i]);
            }

            if(!istomorrow)
            {
                for(i = 0; i< 4; i++)
                {
                    temp = startts + i * 30*60*1000;
                    if(dateFormat(temp, 'HH') > 22)
                        break;
                    daytime[0].sub[i+1] = {
                        text: showHumanHour(temp),
                        value: i * 30*60*1000
                    };
                }
                for (i = 0; i< 4; i++)
                {
                    daytime[1].sub[i] = {
                        text: showHumanHour(tomorrowts + (22 + i) * 30*60*1000),
                        value: (22+i) * 30*60*1000
                    }
                }

            }
            else {
                for(i = 0; i< 5; i++)
                {
                    temp = new Date('2000/01/01 20:00:00').getTime() + i * 30*60*1000;

                    daytime[0].sub[i] = {
                        text: showHumanHour(temp),
                        value: i * 30*60*1000
                    };
                }
                console.log(daytime);
                for (i = 0; i< 4; i++)
                {
                    daytime[1].sub[i] = {
                        text: showHumanHour(tomorrowts + (22 + i) * 30*60*1000),
                        value: (22+i) * 30*60*1000
                    }
                }

            }

            var duration = [
                {
                    text: "1 小时",
                    value: 60*60*1000
                },
                {
                    text: "1.5 小时",
                    value: 1.5*60*60*1000
                },
                {
                    text: "2 小时",
                    value: 2*60*60*1000
                },
                {
                    text: "2.5 小时",
                    value: 2.5*60*60*1000
                },
                {
                    text: "3 小时",
                    value: 3*60*60*1000
                },
                {
                    text: "3.5 小时",
                    value: 3.5 * 60 * 60 * 1000
                },
                {
                    text: "4 小时",
                    value: 4*60*60*1000
                }
            ];


            function creatList(obj, list){
                obj.forEach(function(item, index, arr){
                    var temp = {};
                    temp.text = item.text;
                    temp.value = item.value;
                    list.push(temp);
                })
            }
            var day = [];
            var time = [];

            creatList(daytime, day);

            creatList(daytime[istomorrow|0].sub, time);
            console.log(day);
            console.log(time);

            var startPicker = new Picker({
                data: [day, time],
                selectedIndex: [istomorrow|0, 0],
                title: '开始时间',
                id: 'startPicker'
            });
            var durationPicker = new Picker({
                data: [duration],
                selectIndex: [0],
                title: '使用时长',
                id: 'durationPicker'
            });
            var datePicker = new Picker({
                data:[date],
                selectedIndex: [isUsing|0],
                title: '选择日期',
                id:'datePicker'
            });
            console.log('isusing='+isUsing);

            startPicker.on('picker.select', function (selectedVal, selectedIndex) {
                var d = day[selectedIndex[0]].value;
                selectedDay = d === 0 ? '今天' : '明天';
                startTime.text(selectedDay + ' ' + time[selectedIndex[1]].text)
                    .attr("data-content", (d===0 ? startts :tomorrowts) + time[selectedIndex[1]].value);

                updateEndTime();
            });
            startPicker.on('picker.change', function (index, selectedIndex) {
                if (index === 0){
                    firstChange();
                }

                function firstChange() {
                    time = [];
                    checked = [];
                    checked[0] = selectedIndex;
                    var firstDay = daytime[selectedIndex];
                    creatList(firstDay.sub, time);

                    startPicker.refillColumn(1, time);
                    if(selectedIndex != istomorrow)
                    {
                        $($("#startPicker ul")[1]).children().addClass('disable');
                    }
                    else
                    {
                        var lis = $($("#startPicker ul")[1]).children();
                        for(i =2 ;i < lis.length;i++)
                        {
                            $(lis[i]).addClass('disable');
                        }
                    }
                    startPicker.scrollColumn(1, 0);
                }

            });



            durationPicker.on('picker.select', function(selectedVal, selectedIndex){
                durationTime.text(duration[selectedIndex[0]].text)
                    .attr('data-content', duration[selectedIndex[0]].value);

                updateEndTime();
                updatePrice(0);
            });
            datePicker.on('picker.select', function (selectedVal, selectedIndex) {
                dateTime.text(date[selectedIndex[0]].text.split(' ')[1])
                    .attr('data-content', date[selectedIndex[0]].value);

                updatePrice(1);
            })
            function updateEndTime(){
                endTime.text((istomorrow?'明天':'今天')+dateFormat((+startTime.attr("data-content")) + (+durationTime.attr("data-content")),
                    ' HH:MM'))
                    .attr('data-content', (+startTime.attr("data-content")) + (+durationTime.attr("data-content")));
            }
            function updatePrice(page) {
                if(page === 0)
                    $("#totalPrice").text((+durationTime.attr("data-content"))/(3600*1000) * (+$("#hourPrice").attr("data-content")) );
                else {
                    $t = dateTime.attr('data-content');
                    if($t > 7)
                    {
                        $t = ($t - new Date().getTime()/1000|0)/ (24*60*60);
                    }
                    if ($t + dateFormat(new Date(), 'dd') >= 27) {
                        var pprice = 149;
                        var roomId = $("#roomId").attr('data-content');
                        if (roomId === 'ae50f8da-225e-11e7-b33a-00163e028324') {
                            pprice = 179;
                        }
                        else if (roomId === 'ae50f8da-225e-11e7-b33b-00163e028924') {
                            pprice = 159;
                        }
                        $("#totalPrice").text(pprice);
                    }
                    else {
                        $("#totalPrice").text($("#nightPrice").attr("data-content"));
                    }
                }
            }
            function checkToPay(){
                return $("#agreement").is(':checked') && $("#totalPrice").text() != undefined;
            }
            $("#useHour").click(function(){
                updatePrice(0);
            });
            $("#useNight").click(function(){
                updatePrice(1);
            });

            startTime.parent().on('click', function () {
                startPicker.show();
            });
            durationTime.parent().on('click',function () {
                durationPicker.show();
            });
            dateTime.parent().on('click', function () {
                datePicker.show();
            });

            $("#toPay").on('click', function(){
                if(checkToPay() && $("#toPay button").text()!= '下单中...')
                {
                    $("#toPay button").text('下单中...');

                    temptime = new Date(dateFormat(new Date(), 'yyyy/mm/dd 00:00:00')).getTime();
                    if(dateFormat(new Date(), 'HH') > 5)
                    {
                        temptime += 24*60*60*1000;

                    }
                    console.log('temptime='+temptime);
                    if(!$('#byHour').hasClass('active'))
                    {
                        temptime = tomorrowts + dateTime.attr('data-content') * 24*60*60*1000;
                        data = {
                            _token: $("meta[name='csrf-token']").attr('content'),
                            'userId': $("#userId").attr('data-content'),
                            'roomId': $("#roomId").attr('data-content'),
                            'startTime': (temptime-30*60*1000)/1000|0,
                            'endTime'  : (temptime+21*30*60*1000)/1000|0,
                            'duration' : +durationTime.attr('data-content')/3600000,
                            'price'   : +($('#totalPrice').text()),
                            'date'     : temptime /1000|0,
                            'isDay'    : $('#byHour').hasClass('active') ? 1:0
                        };
                    }
                    else
                    {
                        data = {
                            _token: $("meta[name='csrf-token']").attr('content'),
                            'userId': $("#userId").attr('data-content'),
                            'roomId': $("#roomId").attr('data-content'),
                            'startTime': (+startTime.attr('data-content'))/1000|0,
                            'endTime'  : (+endTime.attr('data-content'))/1000|0,
                            'duration' : +durationTime.attr('data-content')/3600000,
                            'price'   : +($('#totalPrice').text()),
                            'date'     : temptime /1000|0,
                            'isDay'    : $('#byHour').hasClass('active') ? 1:0
                        };
                    }

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
                            alert(e.responseText);
                            //console.log(e.responseText);
                        }
                    });
                }
                    //window.location.href = 'result/0';
            });


            // ******************************
            //   disable date
            for (i = 0; i < 7; i++)
            {
                //console.log('date='+dateFormat(startts + (i+1)*24*60*60*1000, 'yyyy-mm-dd 00:00:00'))
                //console.log(usingNight.indexOf(dateFormat(todayts + (i+1)*24*60*60*1000, 'yyyy-mm-dd 00:00:00')))
                if(usingNight.indexOf(dateFormat(todayts + (i+1)*24*60*60*1000, 'yyyy-mm-dd 00:00:00')) != -1)
                {
                    $("#datePicker [data-val='"+(i)+"']").addClass('disable');
                }
                else
                {
                    if(dateTime.text() == '')
                    {
                        dateTime.text(date[i].text.split(' ')[1])
                            .attr('data-content', date[i].value);
                    }
                }
            }

            // disable duration
            for(i = 0;i < duration.length;i++)
            {
                if( dateFormat(startts+duration[i].value,'HH')>= 23)
                {
                    for (j = i; j< duration.length; j++)
                        $($("#durationPicker li")[j]).addClass('disable');
                    break;
                }
            }

            // disable time
            if(istomorrow)
            {
                $($("#startPicker [data-val='0']")[0]).addClass('disable');
            }
            else {
                $($("#startPicker [data-val='1']")[0]).addClass('disable');
            }

            var lis = $($("#startPicker ul")[1]).children();
            for(i =2 ;i < lis.length;i++)
            {
                $(lis[i]).addClass('disable');
            }

        });
    </script>
    @endsection