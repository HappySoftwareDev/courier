<?php
$aData = json_decode(file_get_contents("../admin/pages/website.json"));
$firebase_push_key = !empty($aData->firebase_push_key) ? $aData->firebase_push_key : "";

function sendNotification(){
    $url ="https://fcm.googleapis.com/fcm/send";

    $fields=array(
        "to"=>$_REQUEST['token'],
        "notification"=>array(
            "body"=>$_REQUEST['message'],
            "title"=>$_REQUEST['title'],
            "icon"=>$_REQUEST['icon'],
            "click_action"=>"https://google.com"
        )
    );

    $headers=array(
        'Authorization: key='.$firebase_push_key,
		//AAAA07DOqQo:APA91bFFiArg2IF9-SxJG_baKDyh70d4EKhslRd1NrLFGUtih_ewf40RDoNXDHRAicCMrxDwSh0Qff3nm5bo-uJiRBnEhPm9fgt5Dbv7-vx2UaPkcqR8EgcTYW88itSylo7_jtKnul3k,
        'Content-Type:application/json'
    );

    $ch=curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST,true);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($fields));
    $result=curl_exec($ch);
    print_r($result);
    curl_close($ch);
}
sendNotification();