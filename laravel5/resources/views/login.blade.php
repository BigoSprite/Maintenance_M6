<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
        <script src="http://libs.baidu.com/jquery/2.0.0/jquery.js"></script>
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
            font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>

        <input id="postBtnId" type="submit" value="postBtn" >

    </body>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#postBtnId').click(function(){
                $.ajax({
                    url: 'localhost:8888/account/login',
                    type: "get",
                    data: {'username':"hanzhiwei", '_token': "token"},
                    success: function(data){
                        alert(data);
                    },
                    error:function () {
                        alert("error");
                    }
                });
            });
        });
    </script>
</html>