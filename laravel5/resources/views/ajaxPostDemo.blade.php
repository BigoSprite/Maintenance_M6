<html>
<head>
    <title>Laravel Ajax Post示例</title>
    {{--<meta name="_token" content="{{ csrf_token() }}"/>--}}

    {{--<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>--}}
    <script src = "jquery.min.js"></script>
    <script type="application/javascript">
        function getMessage(){

//            $.ajaxSetup({
//                headers: {
//                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//                }
//            });

            $.ajax({
                type:'post',
                async:true,
//                url:'ajaxPostUrl',
//                url:'http://221.236.173.192:8888/cors/test',
//                url:'http://221.236.173.192:8888/ajaxPostUrl',
//                url:'http://221.236.173.192:8888/api/admin/distributeRoomRegister',
//                url:'api/admin/update/password',
                url:'api/admin/register/user',
                data:{'username':"misayozi", 'password':'misayozi'},
//                url:'api/admin/verify/login',
//                data:{'username':"hanzhiwei2", 'password':'hanzhiwei2'},

//                url:'http://221.236.173.192:8888/api/admin/register/realEstate',
//                data:{
//                    'dbName':'THotel',
//                    'realEstateName': 'T酒店',
//                    'address':'test address1',
//                    'description':'test desc',
//                    'manageCompany':'uestc',
//                    'serviceEndDateTime':'2018-02-11-22',
//                    'contactPersonName':'hanzhiwei',
//                    'contactTel':'15828251950',
//                    'longitude':'0',
//                    'latitude':'0',
//                    'nodeInfo_nodeName':'冠城花园',
//                    'dbIp':'127.0.0.1',
//                    'dbPort':'3306',
//                    'dbUserName':'root',
//                    'dbPassword':'root',
//                    'isDiscarded':'0'
//                },


//                url:'api/admin/register/node',
//                data:{
//                    'nodeName':'宜宾',
//                    'nodeIp': '127.0.0.1',
//                    'nodeUserName':'root',
//                    'nodePassword':'root123',
//                    'address':'四川 宜宾',
//                    'remark':'该服务器座落在四川宜宾32号街道'
//                },
//                url:'api/admin/update/node',
//                data:{
//                    'nodeName':'宜宾',
//                    'nodeIp': '127.0.0.1',
//                    'nodeUserName':'root',
//                    'nodePassword':'root123',
//                    'address':'四川 宜宾',
//                    'remark':'该服务器座落在四川宜宾32号街道 HW'
//                },


//                url: 'api/content/register/distributionRoom/jinyehotel',
//                data:{
//                    'roomName':'配电室',
//                    'description':"miaoshu",
//                    'address':'uestc',
//                    'contactPerson':'hanzhiwei',
//                    'contactTel':'15828251950'
//                },

//                url:'api/content/register/asset/jinyehotel',
//                data:{
//                    'distributionRoomInfo_serialId':'1',
//                    'name':'开关2',
//                    'type':"switch",
//                    'unit':'个',
//                    'amount':'4',
//                    'addDate':'2015-01-11'
//                },

//                  url:'api/content/update/device',
//                  data:{
//                      'gprsID':'0000000002',
//                      'deviceName':'昂思数显222',
//                      'deviceTypeName':'US2000',
//                      'deviceRemark':'deviceRemark test',
//                      'monitoredUnitName':'0',
//                      'realestateinfo_dbName':'jinyehotel',
//                      'protocolVersion':'1',
//                      'protocolRemark':'test remark',
//                      'contactPersonName':'hanzhiwei',
//                      'contactTel':'15888765678',
//                      'deviceDetailInfo':'null test',
//                      'isDiscarded':'0',
//                      'addDate':'2017-09-02-11'
//                  },

//                    url:'api/content/update/deviceStatus',
//                    data:{
//                        'gprsID':'0000000001',
//                        'isLogin':'1',
//                        'lastLoginTime':'2018-02-11',
//                        'alarmFlag':'flag1111',
//                        'alarmUpdateTime':'2018-02-11',
//                        'isOperating':'1',
//                        'operationDesc':'test111',
//                        'operationUpdateTime':'2018-02-11'
//                    },

//                url:'api/content/update/node/realEstateInfo',
//                data:{
//                    'dbName':'jinyehotel',
//                    'realEstateName':'金叶大厦11',
//                    'address':'测试地址',
//                    'description':'测试描述'
//                },

//                url:'api/content/update/distributionRoom',
//                data:{
//                    'serialId':'10',
//                    'roomName':'配电室2',
//                    'description':'test',
//                    'address':'测试地址',
//                    'productionPro':'test',
//                    'telephoneNumber':'12344556778',
//                    'installationDate':'2019-01-22'
//                },

//                url:'api/content/register/asset',
//                data:{
//                    'distributionRoomInfo_serialId':'0',
//                    'name':'昂思数显表1',
//                    'type':'电表',
//                    'unit':'个',
//                    'amount':'2',
//                    'addDate':'2017-09-11'
//                },

//                url:'api/content/update/deviceTypeInfo',
//                data:{
//                    'name':'US2000',
//                    'typeDesc':'电表'
//                },



                dataType: 'json',
//                headers: {
//                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//                },
                success:function(data){
                    $("#msg").html(data.msg);
                },
                error:function(){
                    alert("error...");
                }
            });
        }
    </script>
</head>

<body>
<div id = 'msg'>
    <br/>
    <input type="button" value="POST" onclick="return getMessage()" />

</div>

</body>

</html>