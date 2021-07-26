
<html>
<head>
</head>
<body>
<form method="post">
Area:<input type="text" name = "area"> <br>
year <input type="text" name = "dtf"><br>
month <input type="text" name = "dtt"><br>
formal bedroom <input type="text" name = "bds"><br>
dens <input type="text" name = "bdsp"><br>
price <input type="text" name = "pr"><br>
ratio <input type="text" name = "tp"><br>
post code <input type="text" name = "lv"><br>
<input type = "submit">
</form>

<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<?php   
	   
function getPostIpData($url,$data=array()){
 
    $ipData = array(
        119.120.'.'.rand(1,255).'.'.rand(1,255),
        124.174.'.'.rand(1,255).'.'.rand(1,255),
        116.249.'.'.rand(1,255).'.'.rand(1,255),
        118.125.'.'.rand(1,255).'.'.rand(1,255),
        42.175.'.'.rand(1,255).'.'.rand(1,255),
        124.162.'.'.rand(1,255).'.'.rand(1,255),
        211.167.'.'.rand(1,255).'.'.rand(1,255),
        58.206.'.'.rand(1,255).'.'.rand(1,255),
        117.24.'.'.rand(1,255).'.'.rand(1,255),
        203.93.'.'.rand(1,255).'.'.rand(1,255),
    );
  
    $ip = $ipData[array_rand($ipData)];

    $referUrl = "http://www.baidu.com";
    $agentArray=[
     
        "safari 5.1 – MAC"=>"Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11",
        "safari 5.1 – Windows"=>"Mozilla/5.0 (Windows; U; Windows NT 6.1; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50",
        "Firefox 38esr"=>"Mozilla/5.0 (Windows NT 10.0; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0",
        "IE 11"=>"Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; .NET4.0C; .NET4.0E; .NET CLR 2.0.50727; .NET CLR 3.0.30729; .NET CLR 3.5.30729; InfoPath.3; rv:11.0) like Gecko",
        "IE 9.0"=>"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0",
        "IE 8.0"=>"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)",
        "IE 7.0"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0)",
        "IE 6.0"=>"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)",
        "Firefox 4.0.1 – MAC"=>"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
        "Firefox 4.0.1 – Windows"=>"Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
        "Opera 11.11 – MAC"=>"Opera/9.80 (Macintosh; Intel Mac OS X 10.6.8; U; en) Presto/2.8.131 Version/11.11",
        "Opera 11.11 – Windows"=>"Opera/9.80 (Windows NT 6.1; U; en) Presto/2.8.131 Version/11.11",
        "Chrome 17.0 – MAC"=>"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_0) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11",
        "傲游（Maxthon）"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Maxthon 2.0)",
        "腾讯TT"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; TencentTraveler 4.0)",
        "世界之窗（The World） 2.x"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
        "世界之窗（The World） 3.x"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; The World)",
        "360浏览器"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; 360SE)",
        "搜狗浏览器 1.x"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; SE 2.X MetaSr 1.0; SE 2.X MetaSr 1.0; .NET CLR 2.0.50727; SE 2.X MetaSr 1.0)",
        "Avant"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Avant Browser)",
        "Green Browser"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
    ];
    $userAgent=$agentArray[array_rand($agentArray,1)]; 
    $header = array(
        'CLIENT-IP:'.$ip,
        'X-FORWARDED-FOR:'.$ip,
    );    
    $curl = curl_init(); 
    curl_setopt($curl, CURLOPT_URL, $url); 
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_REFERER, $referUrl);  
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); 
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); 
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); 
    curl_setopt($curl, CURLOPT_POST, 1); 
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); 
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    $info = curl_exec($curl); 
    if (curl_errno($curl)) {
        echo 'Errno'.curl_error($curl);
    }
    curl_close($curl); 
    return $info;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){

	if(!empty($_POST['area'])){
		$postData['area'] = $_POST['area'];
	}
	if(!empty($_POST['dtf'])){
		$postData['dtf'] = $_POST['dtf'];
	}
	if(!empty($_POST['dtt'])){
		$postData['dtt'] = $_POST['dtt'];
	}
	if(!empty($_POST['bds'])){
		$postData['bds'] = $_POST['bds'];
	}
	if(!empty($_POST['bdsp'])){
		$postData['bdsp'] = $_POST['bdsp'];
	}
	if(!empty($_POST['pr'])){
		$postData['pr'] = $_POST['pr'];
	}
	if(!empty($_POST['tp'])){
		$postData['tp'] = $_POST['tp'];
	}
	if(!empty($_POST['lv'])){
		$postData['lv'] = $_POST['lv'];
	}
	
	$url = 'http://18.191.157.81:8000/bay_value_condo/';
	$data = json_decode(getPostIpData($url,$postData),true);
	$yvs = $data['yvs'];
	$xvs = $data['xvs'];
	$dataPoints = [];
	for($i = 0; $i< count($yvs); $i++){
		array_push($dataPoints,["y" =>$yvs[$i],"x"=>$xvs[$i]]);
	}
	echo '<h3>from '.$data['frm'].'</h3>';
	echo '<h3>to '.$data['to'].'</h3>';
	echo '<h3>avg '.$data['avg'].'</h3>';
	echo '<pre>';
	var_dump($data);

}

 
	   
?>

<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	title: {
		text: "normal distribution"
	},
	axisY: {
		title: "yvs"
	},
	axisX:{
		title:"xys",
		stripLines: [{
			value: <?php echo json_encode($data['recent'], JSON_NUMERIC_CHECK); ?>,
			label: "recent"
		},
		{
			value: <?php echo json_encode($data['rec2'], JSON_NUMERIC_CHECK); ?>,
			label: "rec2"
		},
		{
			value: <?php echo json_encode($data['eval'], JSON_NUMERIC_CHECK); ?>,
			label: "eval"
		}
		]
	},
	data: [{
		type: "line",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
<body>
</html>