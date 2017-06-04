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
//                url:'api/admin/register/user',

//                url:'api/admin/verify/login',
//                data:{'username':"hanzhiwei2", 'password':'hanzhiwei2'},

//                url:'api/admin/update/realEstate',
//                data:{
//                    'dbName':'guachenghuayuan1',
//                    'realEstateName': '冠城花园1',
//                    'address':'test address',
//                    'description':'test desc',
//                    'manageCompany':'uestc',
//                    'serviceEndDateTime':'2018-02-11-22',
//                    'contactPersonName':'hanzhiwei',
//                    'contactTel':'15828251950',
//                    'longitude':'23',
//                    'latitude':'23',
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



//                data:{
//                    'serialId':"5",
//                    'roomName':'配电室5',
//                    'description':"miaoshu",
//                    'address':'uestc',
//                    'productionPro':'switch',
//                    'telephoneNumber':'15828251950',
//                    'installationDate':'2015-01-11'
//                },

//                url:'api/content/insertAssetInfo',
//                data:{
//                    'serialId': '111',
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

                url:'api/content/update/node/realEstateInfo',
                data:{
                    'dbName':'jinyehotel',
                    'realEstateName':'金叶大厦11',
                    'address':'测试地址',
                    'description':'测试描述'
                },



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