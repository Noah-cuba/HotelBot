<?php
//===========================================================
//  各種設定
//===========================================================
//文字コードの設定
mb_language("Japanese");
mb_internal_encoding("UTF-8");
	//Google Map APIのAPIキー設定
	$myKey = "AIzaSyC_n5KEEX8Q1hnpTmqMneWovBaFkSj-W7o";
	// 現在位置取得
$address = "葛西駅";
$origin = urlencode($address);
	//===========================================================
	//  APIで現在位置の緯度軽度を取得
	//===========================================================
	// geocoding API使用のURL指定
$url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $origin . "+CA&key=" . $myKey;
	// geocoding APIからの出力を取得
$contents= file_get_contents($url);
	// JSONデータに変換
$jsonData = json_decode($contents,true);
	// 緯度と軽度を取得
$lat = $jsonData["results"][0]["geometry"]["location"]["lat"];
$lng = $jsonData["results"][0]["geometry"]["location"]["lng"];
	//===========================================================
	//  APIで緯度と軽度から周辺の施設を検索
	//===========================================================
	// Places API使用のURL指定
$place_url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=" . $lat . "," . $lng . "&radius=500&keyword=ラブホテル&key=" . $myKey;
	// Places APIからの出力を取得
$contents_place = file_get_contents($place_url);
	// JSONデータに変換
$jsonData_place = json_decode($contents_place, true);
	// ホテル名と評価を格納する配列を定義・格納
$hotel_data = [];
	// ホテル総合データJSON変数定義
$json = [];
foreach ($jsonData_place["results"] as $key => $val) {
	$hotel_data[$val["name"]] = $val["rating"];
}
	// 評価の降順に並び替え
arsort($hotel_data);
foreach ($hotel_data as $destination => $rating) {
		// echo $destination . "：" . $rating . "<br>";
			// 現在位置からの距離と時間を格納する変数初期化。
	$distance = "";
	$time = "";
			//-----------------------------------------------------------
			//  APIで検索した施設と現在位置との距離と行くまでの時間を計算
			//-----------------------------------------------------------
	$destination = urlencode($destination);
		// echo $destination . '<br>';
		// echo $myKey . '<br>';
			// 現在位置と目的施設の距離やかかる時間を取得
	$directions_url = "https://maps.googleapis.com/maps/api/directions/json?origin=" . $origin . "&destination=" . $destination . "&mode=walking&key=" . $myKey;
			// echo $directions_url . '<br>';
			// APIの返答を取得
	$contents_direction = file_get_contents($directions_url);
	$jsonData_direction = json_decode($contents_direction, true);
			// var_dump($jsonData_direction);
	foreach ($jsonData_direction["routes"] as $key => $val) {
				// var_dump($val["legs"][0]["distance"]["text"]);
				// echo "現在位置からの距離：" . $val["legs"][0]["distance"]["text"] . "<br>";
					// 目的地までの距離と時間を取得
		$distance = $val["legs"][0]["distance"]["text"];
		$time = $val["legs"][0]["duration"]["text"];
	}
		// echo "<br>";
			// JSON用の配列に格納。
	$json_val = [
		'name' => urldecode($destination),
		'rating' => $rating,
		'distance' => $distance,
		'time' => $time
	];
	array_push($json, $json_val);
}
	// var_dump($json);
	// for ($i = 0; $i < count($json); $i++) {
	//     echo "ホテル名：" . $json[$i]['name'] . '<br>';
	//     echo "評価数：" . $json[$i]['rating'] . '<br>';
	//     echo "距離：" . $json[$i]['distance'] . '<br>';
	//     echo "時間：" . $json[$i]['time'] . '<br>';
	//     echo "<br>";
	// }
$list = "https://love-hotels.jp/t/?q=tokyo,edogawa";
$content = file_get_contents($list);
// for ($i = 0; $i < 9724; $i++) {
    // $content =  htmlspecialchars($content);
    // var_dump($content);
    // echo strip_tags($content);
//}
	/*preg_match_all("|<a href=\"(.*?)\".*?>(.*?)</a>|mis",$content,$matches); */
preg_match_all("|<td>(.*?)</td>|mis",$content,$matches);
preg_match_all('|<span class="star">(.*?)</span>|mis',$content,$star_matches);
	// var_dump($star_matches[0]);
for ($i = 0; $i < count($matches[0]); $i = $i + 4) {
	$json_val = [
		'name' => $matches[0][$i],
		'rate' => $star_matches[0][$i/4],
		'address' => $matches[0][$i+1],
		'phone' => $matches[0][$i+2],
		'link' => $matches[0][$i+3]
	];
	array_push($json, $json_val);
}
