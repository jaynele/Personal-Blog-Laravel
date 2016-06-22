<?php
include(__DIR__.'/TopSdk.php');
$c = new TopClient;
$appkey = '23386140';
$secret = '9feb6e4588c4f41f566b464363c22c8b';
$c->appkey = $appkey;
$c->secretKey = $secret;
$rand = mt_rand(100000,999999);
$req = new AlibabaAliqinFcSmsNumSendRequest;
$req->setExtend("123456");
$req->setSmsType("normal");
$req->setSmsFreeSignName("注册验证");
$req->setRecNum("18600615086");
$req->setSmsParam("{\"code\":\"{$rand}\",\"product\":\"短信测试\"}");
$req->setSmsTemplateCode("SMS_8270413");
$resp = $c->execute($req);
var_dump($resp);
?>