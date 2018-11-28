1、配置：
$appid = '2016092400583862';//https://open.alipay.com 账户中心->密钥管理->开放平台密钥，填写添加了电脑网站支付的应用的APPID
$returnUrl = 'http://test.sxslzs.cn/aplipay-wechat/return.php'; //付款成功后的同步回调地址
$notifyUrl = 'http://test.sxslzs.cn/aplipay-wechat/notify.php'; //付款成功后返回信息给服务端，服务端并回应success
$outTradeNo = uniqid();     //你自己的商品订单号，不能重复
$payAmount = 0.01;          //付款金额，单位:元
$orderName = 'Jackey-支付测试';    //订单标题

2、配置生成签名工具的时候，密钥就填在沙箱的 公钥 下，私钥 就配置在alipayPc.php的 $rsaPrivateKey，
公钥 放在 return.php 和 notify.php 的 $alipayPublicKey

3.还不懂，参考 https://blog.csdn.net/qwqw3333333/article/details/83652205


支付宝，微信支付，附带源码
第一个源码(分的很开，单独)
https://github.com/dedemao/alipay

第二个源码(推荐)
https://github.com/zoujingli/pay-php-sdk
