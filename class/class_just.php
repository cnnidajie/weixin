<?php

require("class_phpmailer.php");
class just
{
	public function expireQuery($url, $fromUsername, $toUsername)
	{
			
		$ch = curl_init();
		$str = "http://tool.chinaz.com/DomainDel/?wd=".$url;
		$whoisPreg = "/\<td class=\"deltd1\"\>([^<]+)<\/td\>\<\/tr\>|\<td class=\"deltd1\"\>\<b\>([^<]+)\<\/b\>\<\/td\>\<\/tr\>|\<b\>\<font color=\"red\" size=\"3\"\>([^<]+)\<\/font\>\<\/b\>/";
			
		curl_setopt($ch, CURLOPT_URL, $str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$out_put = curl_exec($ch);
			
		preg_match_all($whoisPreg, $out_put, $mathches);
			
		$textCon = "你好，域名 $url 查询如下:\n\n".
		"域名年龄：".$mathches[1][0]."\n\n".
		"域名状态：".$mathches[1][1]."\n\n".
		"域名创建时间：".$mathches[1][2]."\n\n".
		"域名到期时间：".$mathches[1][3]."\n\n".
		"域名删除时间：".$mathches[2][4]."\n\n".
		"删除倒计时：".$mathches[3][5]."\n\n";
			
		$result = textFormat($toUsername, $fromUsername, $textCon);
			
		echo $result;
			
			
	}
		
	function includedQuery($url, $fromUsername, $toUsername)
	{
		$ch = curl_init();
			
		$str = "http://tool.chinaz.com/Seos/Sites.aspx";
		$postStr = 'host='.$url.'&btnSearch=%E6%9F%A5+%E8%AF%A2';
			
		curl_setopt($ch, CURLOPT_URL, $str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postStr);
			
		$out_put = curl_exec($ch);
			
		$preg = "/.*target=_blank\>([^<]+)\<\/a\>/";
		preg_match_all($preg, $out_put, $mathches);
		
		$textCon =  "你好，你查询的域名:".$url."在各大搜索引擎收录如下:\n".
					"-----------------------\n".
				    "百度收录:".$mathches[1][2]."\n".
				    "百度反链:".$mathches[1][3]."\n".
					"SOSO收录:".$mathches[1][4]."\n".
					"搜狗收录:".$mathches[1][5]."\n".
					"-----------------------\n";
			
		$result = textFormat($toUsername, $fromUsername, $textCon);
			
		echo $result;
	}
	
	function prQuery($url, $fromUsername, $toUsername)
	{
		$ch = curl_init();
		
		$str = "http://tool.chinaz.com/ExportPR/?q=".$url;
		
		curl_setopt($ch, CURLOPT_URL, $str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$out_put = curl_exec($ch);
		
		$preg = "/PR输出值\<\/li\>[\s\S]+\<li\>\<img src=.*Rank_(\d).gif[\s\S]+\<li\>(\d+)\<\/li\>\r\n\<li\>([^<]+)/";
		preg_match($preg, $out_put, $mathches);
		
		$textCon =  "你好，你查询的域名:".$url."PR值如下:\n\n".
				    "网址:".$url."\n".
					"PR值:".$mathches[1]."\n".
					"出站链接数:".$mathches[2]."\n".
					"PR输出值:".$mathches[3]."\n";
		
		$result = textFormat($toUsername, $fromUsername, $textCon);
			
		echo $result;
	}
	
	function emailSend($str, $user, $fromUsername, $toUsername)
	{
		$smtpServer = "smtp.163.com";
		$smtpPort = 25;
		$smtpSendMail = "cnlyml@163.com";
		$smtpMailTo = "2250500636@qq.com";
		$smtpUser = "cnlyml@163.com";
		$smtpPass = "abcdef199593";
		
		$mailSubject = "微信公众平台有用户联系你";
		$mailBody = "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<title></title>
</head>
<div style=\"background-color:#e3e3e3\">
<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\" style=\"font-size:12px;font-family:Helvetica Neue, Luxi Sans, DejaVu Sans, Tahoma, Hiragino Sans GB, STHeiti, Microsoft YaHei, Arial, sans-serif;border-collapse:collapse;width:580px;background-color:#ffffff;\">
<tbody>
<tr>
    <td style=\"width:580px;height:55px;\" colspan=\"3\">
        <img src=\"../image/logo.jpg\" width=\"580px\" height=\"55px\"/>
    </td>
</tr>
<tr>
    <td style=\"max-width:30px;padding:0 15px;\"></td>
    <td style=\"max-width:520px;width:520px;padding:0;\">

        <table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\" width=\"520px\"><tbody>
        <tr>
            <td align=\"left\">
            <p style=\"padding:0;margin:0;color:#7e7e7e;font-size:14px;line-height:24px;\">尊敬的管理员：</p>
            <p style=\"padding:0;margin:0;text-indent:2em;color:#7e7e7e;font-size:14px;line-height:24px;\">来自微信公众平台用户通过联系功能给你发送来一封邮件</p>
            <p style=\"padding:0;margin:0;text-indent:2em;color:#7e7e7e;font-size:14px;line-height:24px;\">当你看完后请及时登录微信公众平台对其进行回复</p>
            <p style=\"padding:0;margin:0;text-indent:2em;color:#7e7e7e;font-size:14px;line-height:24px;padding-bottom:10px;\">本智能系统由<a href=\"http://cnlyml.cnblogs.com\">蓝雨麦郎</a>开发</p>
            </td>
        </tr>
        <tr>
		
            <td align=\"left\">
			
			<p style=\"padding:0;margin:10;color:#7e7e7e;font-size:14px;\">发送者:".$user."</p>
			<p style=\"padding:0;margin:0;color:#7e7e7e;font-size:14px;line-height:24px;\">发送内容:".$str."</p>
			</td>
        </tr>
        
        <tr>
            <td align=\"right\">
                <p style=\"padding:20px 0;margin-right:10px;color:#7e7e7e;font-size:14px;line-height:24px;\">智航微信智能系统</p>
            </td>
        </tr>
        <tr>
            <td>
                <table style=\"border-bottom:1px dashed #7e7e7e;\" width=\"520px;\"></table>
            </td>
        </tr>
        
                        </tbody></table>
                    </td>
                </tbody></table>
            </td>
        </tr>
        </tbody></table>


    </td>
    <td style=\"max-width:30px;padding:0 15px;\"></td>
</tr>
 

<tr><td style=\"min-height:10px;padding:5px;\" colspan=\"3\"></td></tr>
</tbody>
</table>
<table cellspacing=\"0\" cellpadding=\"0\" border=0 align=\"center\"><tbody><tr>
    <td height=\"60px\">
        <p style=\"padding:0;margin:0;color:#7e7e7e;font-size:14px;line-height:20px;\">
             2013 <a href=\"http://cnlyml.cnblogs.com\" style=\"color:#7e7e7e;\">JAVA编程之路</a>
        </p>
    </td>
</tr></tbody></table>
</div>
</html>
";
		
		$mail = new PHPMailer();
		
		$mail->IsSMTP();
		$mail->Host = $smtpServer;
		$mail->SMTPAuth = true;
		$mail->Username = $smtpUser;
		$mail->Password = $smtpPass;
		$mail->Port = $smtpPort;
		$mail->From = $smtpSendMail;
		$mail->FromName = "蓝雨麦郎";
		$mail->AddAddress($smtpMailTo);
		$mail->IsHTML(true);
		$mail->Subject = $mailSubject;
		$mail->Body = $mailBody;
		
		if($mail->Send())
		{
			$textCon = "邮件发送成功，因各种原因，将会在6小时内进行回复，敬请谅解......";
		
			$result = textFormat($toUsername, $fromUsername, $textCon);
			
			echo $result;
		}
		else 
		{
			$textCon = "因各种原因，邮件发送失败......";
		
			$result = textFormat($toUsername, $fromUsername, $textCon);
			
			echo $result;
		}
					
	}
}
?>