<script>
    window.setInterval(function(){
        autoLoadMsg();
    }, 3000);

    $(document).ready(function() {
        $("#message").val("");
        $("#search_user").val("");
        $("#chatarea").scroll(function (event) {
                var mode = $("#mode").val();
                var scroll = $("#chatarea").scrollTop();
                // load message when posision of scrollbar at top
                if(scroll == 0 && mode != '') {
                    loadOldMsg();
                }
        });

        $('#list_friends li').click(function() {
            $('#list_friends li').removeClass('selected');
            $(this).addClass('selected');
        });
    });

    function startMsg(id){
        $("#mode").val("");
        $("#top_message_id").val("");
        $("#bottom_message_id").val("");
        $("#chatarea").html("");
        $("#friend_id").val(id);
        var str = 'id=' + id;
        $.post(
            '/chat/top/getMsg',
            str,
            function (data) {
                $("#chatarea").html(data);
                $("#room").show();
                $('.timeline').scrollTop($('.timeline')[0].scrollHeight);
                $("#mode").val('chat');
        });
    }

    function sendMsg(){
        if($("#message").val() != ''){
            var param = getquerystring('insert_log');
            $.post(
                '/chat/top/insertMsg',
                param,
                function (data) {
                    $("#message").val("");
                    $("#chatarea ul").append(data);
                    $('.timeline').scrollTop($('.timeline')[0].scrollHeight);
            });
            return; 
        } else {
            return;
        }
        
    }

    function autoLoadMsg(){
        var param = getquerystring('insert_log');
        $.post(
            '/chat/top/autoloadMsg',
            param,
            function (data) {
                if(data != '') {
                    $("#chatarea ul").append(data);
                    $('.timeline').scrollTop($('.timeline')[0].scrollHeight);
            }
        });
        return;
    }

    function loadOldMsg(){
        var param = getquerystring('insert_log');
        $.post(
            '/chat/top/loadOldMsg',
            param,
            function (data) {
                if(data != '') {
                    $("#chatarea ul").prepend(data);
                    $('.timeline').scrollTop(200);
            }
        });
        return;
    }

    
</script>

<nav id="slide_left"></nav>
<div id="main_contents" class="open" style="left: 230px; width: calc(100% - 460px);">
    <div class="navbar">
        <a href="/chat/" style="line-height:80px; float :right; font-size:15px; color: #fff; text-decoration: inherit; font-weight:bold; padding-right:15px;">Logout</a>
    </div>
    <div id="mainContainer" style="height:100%;">
        <div id="contentCol" class="chats">
            <div class="message">
                <div class="list">
                    <div class="search_room">
                        <input type="text" placeholder="Search" value="" name="search_user" id="search_user">
                        <button name="search_button" value="search" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <ul id="list_friends" style="height: 400px;">
                        <?php foreach($arrUserOnline as $key => $value) {?>
                            <a href="javascript:void(0);" onclick="startMsg(<?php echo $value['User']['id']; ?>);" style="height:20px,">

                                <img style="width:25px; height:25px; margin: 5px;" src="/chat/img/u.png" alt="User Avatar" class="img-circle">
                                <li><?php echo $value['User']['user_name']; ?></li>
                            </a>
                        <?php }?>
                    </ul>
                </div>
                <div style="width: calc(100% - 224px); display:none;" class="room" id="room" >
                    <div class="key_1">
                        <div id="chatarea" class="timeline">
                           
                        </div>
                    </div>
                    <div class="form">
                        <div style="display:none ; color: red; font-size: 15px; line-height: 30px; margin-top: -30px;">
                            <span>Have new message</span>
                        </div>
                        <form method="POST" name="insert_log" id="insert_log">
                            <input type="hidden" value="" name="mode" id="mode">
                            <input type="hidden" value="" name="friend_id" id="friend_id">
                            <input type="hidden" value="" name="top_message_id" id="top_message_id">
                            <input type="hidden" value="" name="bottom_message_id" id="bottom_message_id">
                            <textarea name="message" placeholder="Input Text..." id="message"></textarea>
                            <div class="button_area">
                                <ul>
                                    <li><input onclick="sendMsg();" name="send" value="Send" class="send_msg"></li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<nav id="slide_right"></nav>