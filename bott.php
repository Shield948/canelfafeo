<?php
include __DIR__."/modules/bot.php";

//////////////===[START]===//////////////

if(strpos($message, "/start") === 0){
if(!isBanned($userId) && !isMuted($userId)){

  if($userId == $config['adminID']){
    $messagesec = "<b>Type /admin to know admin commands</b>";
  }

    addUser($userId);
    bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"<b>Hello @$username,

Type /cmds to know all my commands!</b>

$messagesec",
	'parse_mode'=>'html',
	'reply_to_message_id'=> $message_id,
    'reply_markup'=>json_encode(['inline_keyboard' => [
        [
          ['text' => "💠 Created By 💠", 'url' => "t.me/RedHoodPRO"]
        ],
        [
          ['text' => "💎 𝓡𝓮𝓭𝓗𝓸𝓸𝓭𝓟𝓡𝓞 💎", 'url' => "t.me/RedHoodshop"]
        ],
      ], 'resize_keyboard' => true])
        
    ]);
  }
}

//////////////===[CMDS]===//////////////


?>
