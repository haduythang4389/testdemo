<script>
    var top_message_id = "<?php echo $top_message_id; ?>";
    $("#top_message_id").val(top_message_id);
</script>
<?php foreach($arrChat as $key => $value) {?>
    <?php if ($userID != $value['Chat']['from']) { ?>
    <li class="left clearfix"><span class="chat-img pull-left">
        <img class="img-circle" alt="User Avatar" src="/chat/img/u.png">
        </span>
        <div class="chat-body clearfix">
            <p>
                <?php echo $value['Chat']['message']; ?>
            </p>
        </div>
    </li>
    <?php } else { ?>
    <li class="right clearfix">
        <span class="chat-img pull-right">
            <img class="img-circle" alt="User Avatar" src="/chat/img/me.png">
        </span>
        <div class="chat-body clearfix">
            <p>
                <?php echo $value['Chat']['message']; ?>
            </p>
        </div>
    </li>
    <?php } ?>
<?php } ?>