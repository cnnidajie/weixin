<?php

	require('class/class_just.php');
	
	define('TOKEN', 'cnnidajie');
	
	$wechatObj = new wechatCallbackapiTest();
	$wechatObj->valid();
	
	//$asd = new wechatCallbackapiTest();
	//$asd -> judgment("联系 蓝雨麦郎 hello,word!!!", "蓝雨麦郎", "asd");
	
	
	class wechatCallbackapiTest
	{
		public function valid()
		{
			$echoStr = $_GET['echostr'];
			
			if($this->checkSignature())
			{
				echo $echoStr;
				$this->responseMsg();
				exit;
			}
			
		}
		
		/*
		 * ----------------------------------------------------------------------------
		 *    根据腾讯公众平台API接口文档参考：
		 *    
		 *    对其进行以下操作：
		 *    
		 *	  1. 将token、timestamp、nonce三个参数进行字典序排序
		 *    2. 将三个参数字符串拼接成一个字符串进行sha1加密
         *    3. 开发者获得加密后的字符串可与signature对比，标识该请求来源于微信
		 * ----------------------------------------------------------------------------
		 * */
		
		private function checkSignature()
		{
			$signature = $_GET['signature'];
			$timestamp = $_GET['timestamp'];
			$nonce = $_GET['nonce'];
			
			$token = TOKEN;
			
			$tmpArr = array($token, $timestamp, $nonce);
			sort($tmpArr);                                   // 对数组进行字典序排序
			
			$tmpStr = implode($tmpArr);                      // 将数组拼接成一个字符串
			$tmpStr = sha1($tmpStr);                         // 将字符串进行SHA1加密
			
			if($tmpStr == $signature)
				return true;
			else
				return false;
			
		}
		
		/*
		 * ----------------------------------------------------------------------------
		 *    
		 *    备注：本方法对返回过来的用户信息进行分析，获取第一个参数，判断是否为功能
		 *    		如果为功能，则进入相应的类方法进行操作，并返回true,否则，则返回false
		 *    
		 *    Author:倪大杰
		 *    
		 * ----------------------------------------------------------------------------
		 * */
		
		private function judgment($str, $fromUsername, $toUsername)
		{
			$judgment = explode(" ", $str);
			$just = new just();
			
			switch($judgment[0])
			{
				case '域名过期查询':
					if(!empty($judgment[1]))
						$just->expireQuery($judgment[1], $fromUsername, $toUsername);
					else
					{
						$result = textFormat($toUsername, $fromUsername, "请填写域名参数");
			
						echo $result;
					}
					
					return true;
					
				case '收录查询':
					if(!empty($judgment[1]))
						$just->includedQuery($judgment[1], $fromUsername, $toUsername);
					else
					{
						$result = textFormat($toUsername, $fromUsername, "请填写域名参数");
			
						echo $result;
					}
					
					return true;
					
				case 'PR值查询':
					if(!empty($judgment[1]))
						$just->prQuery($judgment[1], $fromUsername, $toUsername);
					else
					{
						$result = textFormat($toUsername, $fromUsername, "请填写域名参数");
			
						echo $result;
					}
					return true;
					
				case '联系':
					if((!empty($judgment[1])) && (!empty($judgment[2])))
						$just->emailSend($judgment[2], $judgment[1], $fromUsername, $toUsername);
						
						return true;
				
				default:
					return false;
			}
		}
		
		/*
		 * ----------------------------------------------------------------------------
		 *    
		 *    备注：本方法用于接收用户发送过来的信息并提交给judgment方法进行判断
		 *    		如judgment方法返回false,现阶段则进行简单的回复，后阶段将会
		 *    		进行更多的操作
		 *    
		 *    Author:倪大杰
		 *    
		 * ----------------------------------------------------------------------------
		 * */
		
		public function responseMsg()
		{
			$postStr = $GLOBALS['HTTP_RAW_POST_DATA'];
			
			if(!empty($postStr))
			{
				$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
				
				$fromUsername = $postObj->FromUserName;
				$toUsername = $postObj->ToUserName;
				$keyword = trim($postObj->Content);
				
				if(!empty($keyword))
				{
					if($this->judgment($keyword, $fromUsername, $toUsername))
						return;
					else
					{
						$textCon =  "尊敬的用户，你好:\n".
									"本微信公众平台使用了由\"编程之路\"微信公众帐号开发的智航微信智能系统，现在正在内部开发调试中\n".
									"如果您想快速反馈本智能系统的BUG或想联系小编，可以使用\"联系功能\"\n".
									"格式如：\"联系 名字 内容\"发送，中间用空格隔开，本微信将会自动发送至小编的邮箱中，小编将会迅速与您回复\n".
									"如：\"联系 蓝雨麦浪 智航微信智能系统\",本条消息将会发送至小编的QQ邮箱";
						
						$result = textFormat($toUsername, $fromUsername, $textCon);
					
						echo $result;
					}
				}
				
			}
			else
			{
				echo "";
				exit;
			}
		}
	}
	
	
	function textFormat($fromUsername, $toUsername, $str)
	{
		$textTime = time();
		
		$textXml = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName> 
 					<CreateTime>%s</CreateTime>
 					<MsgType><![CDATA[text]]></MsgType>
 					<Content><![CDATA[%s]]></Content>
					<FuncFlag>1</FuncFlag>
					</xml>";
		
		$result = sprintf($textXml, $toUsername, $fromUsername, $textTime, $str);
		
		return $result;
						
		
	}
?>
