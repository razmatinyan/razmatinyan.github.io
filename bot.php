<?php

$data = json_decode(file_get_contents('php://input'), TRUE);
file_put_contents('file.txt', '$data: ' . print_r($data, 1) . "\n", FILE_APPEND);
define('TOKEN', '5165014793:AAGuQ5vswTJP_BvwBXETYm1lcIMvGGe_MGM');

$data = $data['callback_query'] ? $data['callback_query'] : $data['message'];

$message = mb_strtolower(($data['text'] ? $data['text'] : $data['data']),'utf-8');

if ( $message == '/start' ) {
   $method = 'sendMessage';
   $send_data = [
      'text' => 'My Buttons...',
      'reply_markup' => [
         'resize_keyboard' => true,
         'keyboard' => [
            [
               ['text' => 'Button 1'],
               ['text' => 'Button 2']
            ],
            [
               ['text' => 'Button 3'],
               ['text' => 'Button 4']
            ]
         ]
      ]
   ];
} else {
   $method = 'sendMessage';
   $send_data = [
      'text' => 'Ապեր չեմ ջոգմ ինչ ես խոսում!'
   ];
}

$send_data['chat_id'] = $data['chat']['id'];

sendTelegram( $method, $send_data);

function sendTelegram($method, $data, $headers = []) {                                               
   $curl = curl_init();
   curl_setopt_array($curl, [
      CURLOPT_POST => 1,
      CURLOPT_HEADER => 0,
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => 'https://api.telegram.org/bot' . TOKEN . '/' . $method,
      CURLOPT_POSTFIELDS => json_encode($data),
      CURLOPT_HTTPHEADER => array_merge(array("Content-Type: application/json"), $headers)
   ]);                      
   $result = curl_exec($curl);
   curl_close($curl);
   return (json_decode($result, 1) ? json_decode ($result, 1) : $result);
}


?>