<?php

$API_URL = 'https://api.line.me/v2/bot/message';
$ACCESS_TOKEN = '8ovBSLxu7IgauHpSp+0Q2x+9kuAv/046vwUpcTDNePWjB2jI861JAEEKC9AedwxTqcRHj9VvO/9EbqzkLyQz+2jpdTXeo3kQ3YF5sky+9wyu+bokqGAygv4NMDmn/e2WLMw0LNGenhFYO+w2RmY1oAdB04t89/1O/w1cDnyilFU='; 
$channelSecret = '1dc4857497fdc40dd2fbd826d42b1149';

$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array

$jsonFlex = [
    "type" => "flex",
    "altText" => "Hello Flex Message",
    "contents" => [
	  "type": "bubble",
	  "direction": "rtl",
	  "header": {
		"type": "box",
		"layout": "vertical",
		"contents": [
		  {
			"type": "text",
			"text": "สวัสดีท่านลูกค้า ตรอ",
			"weight": "bold",
			"size": "xl",
			"align": "center",
			"contents": []
		  },
		  {
			"type": "text",
			"text": "โปทางร้านเรามีโปรโมชั่นเด็ดๆ ",
			"weight": "bold",
			"align": "center",
			"gravity": "bottom",
			"contents": []
		  },
		  {
			"type": "text",
			"text": "สำหรับคุณโดยเฉพาะ",
			"weight": "bold",
			"align": "center",
			"contents": []
		  }
		]
	  },
	  "body": {
		"type": "box",
		"layout": "vertical",
		"contents": [
		  {
			"type": "text",
			"text": "ตรวจสภาพรถพร้อม พรบ ลด 15%",
			"align": "center",
			"contents": []
		  }
		]
	  },
	  "footer": {
		"type": "box",
		"layout": "horizontal",
		"contents": [
		  {
			"type": "button",
			"action": {
			  "type": "uri",
			  "label": "Youtube ความรู้",
			  "uri": "https://www.youtube.com/channel/UCVsgagmwK71BfwusWyjRS4A"
			}
		  }
		]
	  }
	  
    ]
  ];



if ( sizeof($request_array['events']) > 0 ) {
    foreach ($request_array['events'] as $event) {
        error_log(json_encode($event));
        $reply_message = '';
        $reply_token = $event['replyToken'];


        $data = [
            'replyToken' => $reply_token,
            'messages' => [$jsonFlex]
        ];

        print_r($data);

        $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);

        $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);

        echo "Result: ".$send_result."\r\n";
        
    }
}

echo "OK";




function send_reply_message($url, $post_header, $post_body)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

?>
