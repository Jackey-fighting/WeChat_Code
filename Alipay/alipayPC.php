<?php
header('Content-type:text/html; Charset=utf-8');
/*** 请填写以下配置信息 ***/
$appid = '2016092400583862';//https://open.alipay.com 账户中心->密钥管理->开放平台密钥，填写添加了电脑网站支付的应用的APPID
$returnUrl = 'http://test.sxslzs.cn/aplipay-wechat/return.php';     //付款成功后的同步回调地址
$notifyUrl = 'http://test.sxslzs.cn/aplipay-wechat/notify.php';     //付款成功后的异步回调地址
$outTradeNo = uniqid();     //你自己的商品订单号，不能重复
$payAmount = 0.01;          //付款金额，单位:元
$orderName = 'Jackey-支付测试';    //订单标题
$signType = 'RSA2';			//签名算法类型，支持RSA2和RSA，推荐使用RSA2
//商户私钥，填写对应签名算法类型的私钥，如何生成密钥参考：https://docs.open.alipay.com/291/105971和https://docs.open.alipay.com/200/105310
$rsaPrivateKey='MIIEpAIBAAKCAQEA2f5UTUkRELrR+tteVBirWncdPqparTuSJ4RHg1hsISwcncKZWaB2d97446Ri0fLB7d5E0jEw4XNtjDH3pF9Vpunfix6bjPpNvHr64GdqvTIccZl2qUNxdx3+3zY49jZqJRxI0ui6PkCJ9PnIwq0LVkQH5+NihEXoSwTGxAaFQCli/C3d/WL3tKNU5cYYmFbCiK5sARbFIZn15rp4wZgJKyhy/Muwdp4yvrpEvdzNLpqe2DR1MmPuirF5+0jxcUqj9oprt0keS9HTngkYTU26gOCE7I+54fYoMkVBAMcqi74JI5qmKxQvvHL5JHVi7/5aZzGdesr1y0pas17QqICu2wIDAQABAoIBAQDJzRxDc3l90ERkgsE+/ptaItyKz28j4Pq65ETDfY6T4t8W2DfX9ajV7S7gpaPpkV4fktyI7IrAmnd2CiejHbIP039irVH4XxqpeftW08XHIWWdcCCeLtYSHE1+Wxa+Lr9yXU25GUKYMGzFwJouRb0x/caHz0K7CnAxSlmqzBJ8wl3SBkpotPPcZop6D1sDbkNTbZUcjNmvkUyTW1EgG6GEcpaar+kwMD3cg3X5BKCvWXq5wgLe7XWVQNep5pWHueX0vn77e0FAaMXjqTa/jlkAZxs4Usl1G79eTCTjmNGb+5LfRKaQIbbPcljvElQ23ylAz398GOQe91mbe38+8p/xAoGBAPNg2kogLEtR8muWDz/ILWN2t78mHuCASF4rmFUB2lxZTM+KJfGEXVRFnrfxnBVRlmxNIssWQkW61o/ZMZoUX36sXE+ARVyo/nQXPlXzGfz/d/GIbver2a79zmAfJruf4nAHVjZZU04wzA6dI0nOgwtvRiSoUiwTOCcpXTKm0n2TAoGBAOVMdhramrSZgJBCDllNKH6lmZaSK/DqeWvLJsd4+7FAAaTz/T187egruQHYBM8wgmBYn+R66UDuLO6AZgofHb+oVbMnqrtlijMSLrUiHVLDTCDwzB5FbonuaqL0kMk8EVgOpxNGjjZM0jzCPPToozrQzylK4Zoz19mbaWvEExaZAoGBALKrN5WTaPEih8VTtH4uhqOuU9aQNbq6cmYvuvUtFxEUvb7evFxBwAJN2edQCDXeX3/CYPiWrrBiKYIRAMkMi86C2oHCuSj9J1AygCC5ByskoPlAH7bTAkvlJ8yJEfZLugBkYnYjvXR5flR8J5vXb3zFg8kFiM2yjlaxlynILl7hAoGAUCAQ4T9kchl1wHMkunXo4aCSc/guHKiCt3Us3uVa5kxchryv0G24YLnuk0NeItxroqk1bky493SDBPCfN4g6CAAVul3xHjzUNxZydd8u6f3Ou3AJk8ZlYxOJ9dmKQpeX4/Jy1ZyBE15y1MJ3NImaiHHxAhflj9Hv6l2RUBQbK3kCgYBDjlvqaeD2Gm/QyqStFE0vKGkcleB/0xnjRfvngIGacqn8mjAv9P5mUBC9z4SY/ZK3mEkS2P903PDwZTVp3D1fhpXqRlkTF+4dvBnF1vWD1xL0yarZ9zoRadON6jrwtGtJiuLPGiVL+dOmY9zK/2LwepjOkdRLGZAgcIK+ows87g==';		
/*** 配置结束 ***/
$aliPay = new AlipayService();
$aliPay->setAppid($appid);
$aliPay->setReturnUrl($returnUrl);
$aliPay->setNotifyUrl($notifyUrl);
$aliPay->setRsaPrivateKey($rsaPrivateKey);
$aliPay->setTotalFee($payAmount);
$aliPay->setOutTradeNo($outTradeNo);
$aliPay->setOrderName($orderName);
$sHtml = $aliPay->doPay();
echo $sHtml;

class AlipayService
{
    protected $appId;
    protected $returnUrl;
    protected $notifyUrl;
    protected $charset;
    //私钥值
    protected $rsaPrivateKey;
    protected $totalFee;
    protected $outTradeNo;
    protected $orderName;

    public function __construct()
    {
        $this->charset = 'utf8';
    }

    public function setAppid($appid)
    {
        $this->appId = $appid;
    }

    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
    }

    public function setNotifyUrl($notifyUrl)
    {
        $this->notifyUrl = $notifyUrl;
    }

    public function setRsaPrivateKey($saPrivateKey)
    {
        $this->rsaPrivateKey = $saPrivateKey;
    }

    public function setTotalFee($payAmount)
    {
        $this->totalFee = $payAmount;
    }

    public function setOutTradeNo($outTradeNo)
    {
        $this->outTradeNo = $outTradeNo;
    }

    public function setOrderName($orderName)
    {
        $this->orderName = $orderName;
    }

    /**
     * 发起订单
     * @return array
     */
    public function doPay()
    {
        //请求参数
        $requestConfigs = array(
            'out_trade_no'=>$this->outTradeNo,
            'product_code'=>'FAST_INSTANT_TRADE_PAY',
            'total_amount'=>$this->totalFee, //单位 元
            'subject'=>$this->orderName,  //订单标题
        );
        $commonConfigs = array(
            //公共参数
            'app_id' => $this->appId,
            'method' => 'alipay.trade.page.pay',             //接口名称
            'format' => 'JSON',
            'return_url' => $this->returnUrl,
            'charset'=>$this->charset,
            'sign_type'=>'RSA2',
            'timestamp'=>date('Y-m-d H:i:s'),
            'version'=>'1.0',
            'notify_url' => $this->notifyUrl,
            'biz_content'=>json_encode($requestConfigs),
        );
        $commonConfigs["sign"] = $this->generateSign($commonConfigs, $commonConfigs['sign_type']);
        //var_dump($commonConfigs);exit;
        return $this->buildRequestForm($commonConfigs);
    }

    /**
     * 建立请求，以表单HTML形式构造（默认）
     * @param $para_temp 请求参数数组
     * @return 提交表单HTML文本
     */
    protected function buildRequestForm($para_temp) {

        //$sHtml = "正在跳转至支付页面...<form id='alipaysubmit' name='alipaysubmit' action='https://openapi.alipay.com/gateway.do?charset=".$this->charset."' method='POST'>";
        $sHtml = "正在跳转至支付页面...<form id='alipaysubmit' name='alipaysubmit' action='https://openapi.alipaydev.com/gateway.do?charset=".$this->charset."' method='POST'>";
        while (list ($key, $val) = each ($para_temp)) {
            if (false === $this->checkEmpty($val)) {
                $val = str_replace("'","&apos;",$val);
                $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
            }
        }
        //submit按钮控件请不要含有name属性
        $sHtml = $sHtml."<input type='submit' value='ok' style='display:none;''></form>";
        $sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";
        return $sHtml;
    }

    public function generateSign($params, $signType = "RSA") {
        return $this->sign($this->getSignContent($params), $signType);
    }

    protected function sign($data, $signType = "RSA") {
        $priKey=$this->rsaPrivateKey;
        $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($priKey, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');
        if ("RSA2" == $signType) {
            openssl_sign($data, $sign, $res, version_compare(PHP_VERSION,'5.4.0', '<') ? SHA256 : OPENSSL_ALGO_SHA256); //OPENSSL_ALGO_SHA256是php5.4.8以上版本才支持
        } else {
            openssl_sign($data, $sign, $res);
        }
        $sign = base64_encode($sign);
        return $sign;
    }

    /**
     * 校验$value是否非空
     *  if not set ,return true;
     *    if is null , return true;
     **/
    protected function checkEmpty($value) {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;

        return false;
    }

    public function getSignContent($params) {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {
                // 转换成目标字符集
                $v = $this->characet($v, $this->charset);
                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }

        unset ($k, $v);
        return $stringToBeSigned;
    }

    /**
     * 转换字符集编码
     * @param $data
     * @param $targetCharset
     * @return string
     */
    function characet($data, $targetCharset) {
        if (!empty($data)) {
            $fileType = $this->charset;
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
                //$data = iconv($fileType, $targetCharset.'//IGNORE', $data);
            }
        }
        return $data;
    }
}
