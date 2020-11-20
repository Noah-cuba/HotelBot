<?php
require_once('./LINEBotTiny.php');

$channelAccessToken = 'GyPgX5Zn6Q1Vo8dY23LRnpuY6iJIGEnfCsS1UxKBoG88dRx176B66WhtXyJA8ZUwUu2+7bC/LoghCseqo8wlnGx+PpjquzETcGhZRyOOA4whoP+L4cJ4jWtciZgFEM/floTLBii2esmIMXimQvklRgdB04t89/1O/w1cDnyilFU=';
$channelSecret = '7b9b28b3623a41d6a4660102597105ae';

$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
	switch ($event['type']) {
	case 'message':
		$message = $event['message'];
		switch ($message['type']) {
		case 'location':
			$lat = $message['latitude'];
			$lng = $message['longitude'];
/*$url = 'http://webservice.recruit.co.jp/hotpepper/gourmet/v1/?key=2f2c45d48d7fc12d&lat=' . $lat . '&lng=' . $lng . '&format=json';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);//URL取得
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//curl_exec()の返り値を文字列で返す
			//URLの情報を取得
			$response = curl_exec($ch);
			$result = json_decode($response, true);//取得したURLのJSONコードをデコード
			$shop_info =  $result['results']['shop'];
			foreach ($shop_info  as $key => $value) {
				$shop_info .= $value['name'] . "\n";
				$shop_info .= $value['coupon_urls']['pc'] . "\n\n";
				if ($key == 4) {
					break;
				}
			}
 */			$client->replyMessage(array(
				'replyToken' => $event['replyToken'],
				'messages' => array(
					array(
						'type' => 'text',
						'text' => $lat
					)
				)
			));
 			break;
		default:
			error_log('Unsupported message type: ' . $message['type']);
			break;
		}
		break;
	default:
		error_log('Unsupported event type: ' . $event['type']);
		break;
	}
};
?>

