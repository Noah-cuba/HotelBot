<?php
$url = 'http://webservice.recruit.co.jp/hotpepper/gourmet/v1/?key=2f2c45d48d7fc12d&lat=34.67&lng=135.52&range=5&order=4&format=json';
$ch = curl_init();
//URLとオプションを指定
curl_setopt($ch, CURLOPT_URL, $url);//URL取得
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//curl_exec()の返り値を文字列で返す
//URLの情報を取得
$response = curl_exec($ch);
$result = json_decode($response, true);//取得したURLのJSONコードをデコード
$shop_info =  $result['results']['shop'];
foreach ($shop_info  as $key => $value) {
	$shopinfo .= $value['name'] . "\n";
	$shopinfo .= $value['coupon_urls']['pc'] . "\n\n";
	if ($key == 2) {
		break;
	}
}
?>
