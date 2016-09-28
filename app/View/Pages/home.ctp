<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title>Demo Chat</title>
    <link rel="icon" type="image/x-icon" href="/chat/favicon.ico">
    <script src="/chat/js/jquery-3.1.0.js" type="text/javascript"></script>
    <script src="/chat/js/chat.js" type="text/javascript"></script>
    <style>
        body{
            margin: 0;
            padding: 0;
            background-image: url("/chat/img/bg-demo.png");
        }
        body, div#mypage{
            width: 100%;
            height: 100vh;
        }
        input[type=text], input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        input#btnlogin{
            background-color: #0d9fbe;
            background-image: linear-gradient(to bottom, #0d9fbe, #0d9fbe);
            background-repeat: repeat-x;
            border: medium none;
            color: white;
            cursor: pointer;
            margin: 8px 0;
            padding: 14px 20px;
            text-align: center;
            width: 310px;
        }
        div#loginFrm{
            width: 350px;
            margin: 0 auto;
            padding: 180px;
        }
    </style>
    <script>
        function login(){
            $("#error").hide();
            var param = getquerystring('frmLogin');
            $.post(
                '/chat/login',
                param,
                function (data) {
                    var obj = $.parseJSON(data);
                    if(obj['error'] != ''){
                        $("#error").show();
                    } else {
                        $('form:first').submit();
                    }
            }); 
            return; 
        }
    </script>
</head>
<body>
    <div id="mypage">
        
        <div id="loginFrm" class="login">
            <span id="error" style="color:red; font-weight:bold; display:none;">* Have error when login, please check again!</span>
            <form action="/chat/top" name="frmLogin" method="POST">
                <input type="text" placeholder="Enter Email" name="email" required>

                <input type="password" placeholder="Enter Password" name="pass" required>

                <input id="btnlogin" value="Sign In" onclick="login();"></input>
            </form>
        </div>
    
    </div>
</body>
</html>

