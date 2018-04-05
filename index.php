<?php
/**
* 
*/
class WeChat{

	//打通微信和服务端
	 public function index(){
	    //获得参数 signature nonce token timestamp
	   		$timestamp = $_GET['timestamp'];
			$nonce = $_GET['nonce'];
			$token = 'JackeyEtingLove';//这个自己跟微信那边填写一致
			$signature = $_GET['signature'];
			$echostr = $_GET['echostr'];
			$array = array($timestamp,$nonce,$token);
			sort($array);
	   		$str = sha1(implode('',$array)); //合并成字符串并sha1加密
	       if ($str == $signature && $echostr) {//判断该数据源是不是微信后台的
	       	//第一次接入weixin api 接口的时候
	       	echo $echostr;
	       }else{
	       		$this->responsMsg();
	       }
		}


	//跟用户互动的方法
	public function responsMsg(){
		//1、获取到微信推送过来的post数据(xml格式)
		$postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
		$tmpstr = $postArr;//获取数据格式
		$postObj = simplexml_load_string($postArr);//将xml转换成object

		//用户订阅公众号
		$this->Subcibe($postObj);
		//用户发送文字，后台回复一个单图文
		$this->DanTuWen($postObj);
	}



	//微信用户订阅公众号方法
	public function Subcibe($postObj){

		if (strtolower($postObj->MsgType) == 'event') {//判断该数据包是否是订阅事件推送
			
			if (strtolower($postObj->Event == 'subscribe')) {//如果是关注subscribe 事件

				$arr = [//这里一定要是二维数组
						[
							'title'=>'imooc',
							'description'=>'imooc is very cool',
							'picUrl'=>'http://www.imooc.com/static/img/common/logo.png',
							'url'=>'http://www.imooc.com'
						],
					   ];
			//回复用户消息（单图文格式），也可以其他的，自定义
				$indexModel = new \Org\Util\IndexModel();
				$indexModel->responseSubscribe($postObj,$arr);
		 }//end subscribe
		}//end event判断
	}


	//微信单图文函数
	public function DanTuWen($postObj){
		//用户仿宋tuwen1关键字的时候，回复一个单图文
		if (strtolower($postObj->MsgType) == 'text'&&strtolower(trim($postObj->Content))==strtolower('JackeyEting')) {
			//$arr这里从数据库那里获取数据
			$arr = array(
				array(
					'title'=>'we',
					'description'=>'This is about us.',
					'picUrl'=>'http://vipgz1.idcfengye.com:10035/TP_News/Public/images/we.jpg',
					'url'=>'http://vipgz1.idcfengye.com:10035/TP_News/gridAnimation/index.html'
					),
				array('title'=>'EtingBaby',
					'description'=>'hao123 is very cool',
					'picUrl'=>'http://vipgz1.idcfengye.com:10035/TP_News/Public/images/eting01.jpg',
					'url'=>'http://www.hao123.com'
					),
				array('title'=>'Jackey',
					'description'=>'qq is very cool',
					'picUrl'=>'http://vipgz1.idcfengye.com:10035/TP_News/Public/images/me.jpg',
					'url'=>'http://www.qq.com'
					),
				);
			//实例化模型
			$indexModel = new \Org\Util\IndexModel();
			$indexModel->responseMsgNews($postObj,$arr);

		}else {//回复文本消息
					switch (trim($postObj->Content)) {
						case 1:
							$content = '1.你是我的小可爱0.0';
							break;
						case 2:
							$content = '2.我是你的小心肝';
							break;
						case 3:
							$content = '3.I LOEV YOU';
							break;
						case '百度':
							$content = "请点击<a href='http://www.baidu.com'>百度连接</a>";
							break;
						case '天气预报':
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL, "http://v.juhe.cn/weather/index?format=2&cityname=广州&key=1163d602ba7f2c63f4e9994db9212810");
							//添加key到header
							curl_setopt($ch, CURLOPT_HTTPHEADER,array("application/x-www-form-urlencoded;charset=utf-8"));
							curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
							$res = curl_exec($ch);
							$resArr = json_decode($res,true);

							$content= $resArr['result']['today']['city']."\n".$resArr['result']['today']['week']."\n".$resArr['result']['today']['temperature'];
							break;
	            case 'qixi':
	            $arr = array(
	            array(
	              'title'=>'we',
	              'description'=>'This is about us.',
	              'picUrl'=>'http://vipgz1.idcfengye.com:10035/TP_News/gridAnimation/images/qixi.jpg',
	              'url'=>'http://vipgz1.idcfengye.com:10035/TP_News/gridAnimation/index.html'
	              ),);
	            //实例化模型
	            $indexModel = new \Org\Util\IndexModel();
	            $indexModel->responseMsgNews($postObj,$arr);
	            break;

						default:
							$content = '您好,欢迎关注JackeyEting的微信公众账号';
							break;
					}
						//实例化模型
				$indexModel = new \Org\Util\IndexModel();
				$indexModel->responseText($postObj,$content);
			}//end else
		}

}