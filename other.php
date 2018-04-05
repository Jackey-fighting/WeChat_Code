<?php
	//curl的简单实例
   function http_curl($url,$post,$json,$data){
   	//获取imooc
   	//1.初始化curl
   	$ch = curl_init();
   	//2.设置curl的参数
   	curl_setopt($ch, CURLOPT_URL, $url.$post.':'.$json);
   	curl_setopt($ch, CURLOPT_HEADER, 0);
 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
   	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
   	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   	//3.采集
   	$output = curl_exec($ch);
   	//4.关闭
   //	curl_close($ch);

   	$output?var_dump($output):die(curl_error($ch));
   }

   function getWxAccessToken(){
   	//1.请求地址
   	$appid = 'wx08ec59d5b53df012';
   	$secret = '5a83854e5869d6d7cc5e5dfedd3fbe4c';
   	$url ="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
   	//2.初始化
   	$ch = curl_init();
   	//3.设置参数
   	curl_setopt($ch, CURLOPT_URL, $url);
   	curl_setopt($ch, CURLOPT_HEADER, 0);
   	//如果获取的curl_exec返回值为NULL，需要添加以下两句，不验证证书
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
 	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
   	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   	//4.调用接口
   	$res = curl_exec($ch);
   	//5.关闭curl
   	curl_close($ch);

  	if (curl_error($ch)) {
   		var_dump(curl_error($ch));
  	 	}

  	 	$arr = json_decode(trim($res),true);
  	 	var_dump($arr);
   }

   function getWxServerIp(){//这里是来获取微信服务的IP。来确认发过来的是微信服务器的
   	$accessToken = "8cmkQtaYsw_3tJqz83fKGYUdA0PJiyOPPmooEbEwhAnPwGhb7ubaKmYag_Ae6tI01QjYaMa4nAKzXuC9GmPec6YK4ie_ycfY77QZs0lL78g2rdCwUD3K_PNS7BhGkgrQSSOjAEAMMI";
   	$url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=".$accessToken;
   	$ch = curl_init();
   	curl_setopt($ch, CURLOPT_URL, $url);
   	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   	//如果获取的curl_exec返回值为null，需要添加以下两句，不验证证书
   	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
   	$res = curl_exec($ch);//执行后的返回值
   	if (curl_error($ch)) {
   		var_dump(curl_error($ch));
   	}
   	//json_decode使用true是转成数组，而不是对象
   	$arr = json_decode($res,true);
   	echo "<pre>";
   	var_dump($arr);
   	echo "</pre>";
   }

   function getQrCode(){
   	//1.获取ticket票据
   	//2.全国票据access_token 网页授权access_token  微信js-SDK jsapi_ticket
   	 $access_token="SSV3W4e-DIjNoNy8vpKqk7kbMyTI9FwOinY6ZUmzXwgmCX1GGlECNoIcyc11dy07xsy0e-N4gjVQnl2fQ-452vc2Ea6DtC00RpcYo_uG-8KI8d1NzWqpn2AW6Z4dYwqEJABhABATKL";
   	$url = " https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
   	//{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": 123}}}
   	$postArr = array(
   			'expire_seconds'=>604800,
   			'action_name'=>'QR_SCENE',
   			'action_info'=>array(
   				'scene'=>array(
   					'scene_id'=>2000
   				)
   			)
   		);
   //	die(http_build_query($postArr));
   	$postJson = json_encode($postArr);
   	$res = $this->http_curl($url,'post','json',$postJson);
   }

   function getToken(){
   	//1.请求地址
   	$appid = 'wx99c9cf70ca747384';
   	$secret = '330850c4a718f5c373c37497e0b0669f';
   	$url ="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
   	//2.初始化
   	$ch = curl_init();
   	//3.设置参数
   	curl_setopt($ch, CURLOPT_URL, $url);
   	curl_setopt($ch, CURLOPT_HEADER, 0);
   	//如果获取的curl_exec返回值为NULL，需要添加以下两句，不验证证书
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
 	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
   	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   	//4.调用接口
   	$res = curl_exec($ch);
   	//5.关闭curl
   	curl_close($ch);

  	if (curl_error($ch)) {
   		var_dump(curl_error($ch));
  	 	}

  	 	$arr = json_decode(trim($res),true);
  	 	var_dump($arr);
   }