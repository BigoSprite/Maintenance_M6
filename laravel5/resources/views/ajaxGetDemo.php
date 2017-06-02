<html>
<head>
    <title>Laravel Ajax示例</title>

    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script type="application/javascript">
        function getMessage(){
            $.ajax({
                type:'get',
                url:'getmsg',
                data: '_token = <?php echo csrf_token() ?>', <!-- get请求可不加 -->
                success:function(data){
                    $("#msg").html(data.msg);
                }
            });
        }
    </script>
</head>

<body>
<div id = 'msg'>
    这条消息将会使用Ajax来替换.
    点击下面的按钮来替换此消息.

    <br/>
    <input type="button" value="change msg" onclick="return getMessage()" />

</div>

</body>

</html>