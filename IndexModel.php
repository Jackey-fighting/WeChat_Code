<?php
namespace Org\Util;

class IndexModel{
		/*回复多图文
			@param obj $postObj 微信客户端请求服务器的xml对象
			@param array $arr 从数据库获取的数据,二维数组
		*/
	public function responseMsgNews($postObj,$arr){
		$toUser = $postObj->FromUserName;
		$fromUser = $postObj->ToUserName;
		$template = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<ArticleCount>".count($arr)."</ArticleCount>
					<Articles>";
		foreach ($arr as $k => $v) {
			$template.="<item>
					<Title><![CDATA[".$v['title']."]]></Title>
					<Description><![CDATA[".$v['description']."]]></Description>
					<PicUrl><![CDATA[".$v['picUrl']."]]></PicUrl>
					<Url><![CDATA[".$v['url']."]]></Url>
					</item>";
		}
		$template.="</Articles>
					</xml>";
		echo sprintf($template,$toUser,$fromUser,time(),"news");
	}

	/*回复单文本
			@param obj $postObj 微信客户端请求服务器的xml对象
			@param array $arr 从数据库获取的数据
		*/
	public function responseText($postObj,$content){
		$template = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";		//注意模板的顺序，中括号
				$fromUser = $postObj->ToUserName;
				$toUser = $postObj->FromUserName;
				$time = time();
				$msgType = 'text';
				echo sprintf($template,$toUser,$fromUser,$time,$msgType,$content);
	}

	//回复用户的关注事件
	public function responseSubscribe($postObj,$arr){
		//回复用户信息
		/*	$toUser = $postObj->FromUserName;
			$fromUser = $postObj->ToUserName;
			$time = time();
			$msgType = 'text';
			$content = '欢迎关注JackeyEting的微信公众账号:分别输入1、 2、 3 来看看你家宝贝的心声 (*^__^*) ';
			$template ="
				<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[%s]]></MsgType>
				<Content><![CDATA[%s]]></Content>
				</xml>
			";
			$info = sprintf($template,$toUser,$fromUser,$time,$msgType,$content);
			echo $info;*/
			$this->responseMsgNews($postObj,$arr);
	}
}