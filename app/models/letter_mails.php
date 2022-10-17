<?php

/**
* 
*/
use Controller\Controller;

class letter_mails extends Controller
{
	
	public function verification($email=false, $code=false)
	{
		return '
    <table height="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:14px;font-family:Microsoft Yahei,Arial,Helvetica,sans-serif;padding:0;margin:0;color:#333;background: linear-gradient(50deg, #EFF2F7 0, #eff0f7 100%);background-repeat:repeat-x;background-position:bottom; width: 100%;">
    <tbody>
    <tr>
    <td>
    <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
    <td align="center" valign="middle" style="padding:33px 0; display: flex; text-align: center;">
    <span style="margin-left: auto;margin-right: auto;">
    <img src="https://lh3.googleusercontent.com/Ck5PMNr4QY_IqQFeKzpwZ086m_Lbg2cFZ_bnuASmHn_NHlDpY6WO8piF5E3lS44F6v0Sp6k0VijKn3LDOWEowdgGxpgryei6a_Q2pCLVR5uhaeKAVMyEzX5D-UGMcpvuSXJ3v3oe8mrMHm-a6R4AuGSNEPGUD7YyggLobFO_IPN9hef7Z48OZfpxPfq_YW7S7IufqwC9hIjDBb61ZqypC8T7Q19cbMhul4ee3MDmuOtdU_w-6FcCu2usuNNQeeAEk0DuM7npCNStNdMtTmNRn0rpKD7igLfKZgQwZSK-u6YpgPR3zIwYMPHlRyuL2rDsQ0Qq-jf4hwcvE22zkTg8bKMqrH7HtvUCu7N8J5sPBqVPk_WEgucW8WsLJShytmrm9jhbh5zd9VOqi1co8Ty9LSxyg7h6Njl0sPcQ7_bpVmUIyhsQW1fismJ-Yz1fXqK9pWy-yoMRxmeP_nwoyDgZdFyVb396BQuMllfLULnZ1YDHfjmMjWBRgPh2oG49v3mvq8kROgQirMMIVHfRWeusaPM3eAraI91-CrDAmMmOwAiGGliThZQLy5PDTueMz4rBo17Z7VkFATFa8KF4aT_R7mWpebCIL3sKQqqXWqLZ-gFjYYCtDhls4zni60i971fAiCEU5HY--YdJgd9JSlyDdE3CN9FEPHBt_NamMApm_5hyScTiNF-mU5i-nE5kQREbafDo63u4pommpQJ8Eb7HY5SbXSbW9YjKr0AnykgIXzrvNwWGZUPrFK7uY7gPJz1qPIuDQwJcLPWoR8uuCA=w798-h491-no#https://w3llsquad.or.id/assets/img/icon/w.png" style="border:0; padding: 20px; width: 110px; height: 80px;" class="CToWUd">
    <img src="https://lh3.googleusercontent.com/pw/AM-JKLWsAA6nWBx6HAExhC6an2B85TXGIaoF1OKQHSnF43xVseL2z0dgG0g6W_yhK13kMvOdjmZ0KBWR8eXa_wjbhAAYjao4JtgUclakwVGHoI9I14bHJosQYjX-F0NVJvGunaGkFKuoUEq6q_gVVvifCO1a=s549-no#https://i.ibb.co/nnPjxkL/favicon.png" width="91" style="border:0; padding: 20px;" class="CToWUd">
    </span>
    </td>
    </tr>
    <tr>
    <td>
    <div style="padding:0 30px;background:#fff">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
    <td style="border-bottom:1px solid #e6e6e6;font-size:18px;padding:20px 0 5px">
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tbody>
    <tr>
    <td>Email Verification</td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>

    <tr>
    <td style="font-size:14px;line-height:30px;padding:20px 0;color:#666">Dear user!<br>Your verification code is :</td>
    </tr>
    <tr>
    <td>
    <table width="50%" border="0" cellspacing="0" cellpadding="0" align="center" style="background:#f8f8f8;border:1px solid #d6d6d6">
    <tbody>
    <tr>
    <td style="line-height:26px;padding:20px 0" align="center">
    <span style="padding:5px 0;font-size:20px;font-weight:bolder;color:#e9b434;text-align: center;">'.$this->balitbangDecode($this->balitbangDecode($code)).'</span>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    <tr>
    <td style="font-size:14px;line-height:30px;padding:5px 0;color:#666">If you are having trouble, please click <strong><a style="text-decoration: none;" target="_blank" rel="noreferrer" href="'.$this->base_url("/console/verification/".$this->balitbangEncode($email)."/".$this->balitbangEncode($code)).'">verify now</a></strong> to make it easier.
    </td>
    </tr>
    <tr>
    <td style="font-size:14px;line-height:30px;padding:20px 0;color:#666">The code will remain valid for 10 minutes. Be sure to confirm that the domain name in the address bar is <strong><a href="myua.w3llsquad.or.id" style="text-decoration: none;">myua.w3llsquad.or.id</a></strong> before proceeding, beware of scams!</td>
    </tr>
    <tr>
    <td>
    <span style="padding:5px 0;font-weight:bolder;color:#F7010D">Security Warning :</span>
    </td>
    </tr>

    <tr>
    <td style="padding:10px 0 0 0;line-height:26px;color:#666">
    <ul style="margin-left: -20px;">
    <li>Don\'t tell anyone your password and second verification code!</li>
    <li>Do not contact any customer service claiming to be part of Myua!</li>
    <li>Don\'t send the verification code to anyone claiming to be part of Myua!</li>
    </ul>
    </td>
    </tr>
    <tr>
    <td style="padding:30px 0 15px 0;font-size:12px;color:#999;line-height:20px">W3LL Squad Team<br>System Mail, please do not reply
    </td>
    </tr>
    </tbody>
    </table>
    </div>
    </td>
    </tr>
    <tr>
    <td align="center" style="font-size:12px;color:#999;padding:20px 0">#WeGrowTogether ©W3LL Squad '.date("Y").'<br>Official website: <a href="www.w3llsquad.or.id" style="color:#999;text-decoration: none;">www.w3llsquad.or.id</a>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>';
  }

  public function reset($email=false, $code=false)
  {
    {
      return '
      <table height="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:14px;font-family:Microsoft Yahei,Arial,Helvetica,sans-serif;padding:0;margin:0;color:#333;background: linear-gradient(50deg, #EFF2F7 0, #eff0f7 100%);background-repeat:repeat-x;background-position:bottom; width: 100%;">
      <tbody>
      <tr>
      <td>
      <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tbody>
      <tr>
      <td align="center" valign="middle" style="padding:33px 0; display: flex; text-align: center;">
      <span style="margin-left: auto;margin-right: auto;">
      <img src="https://lh3.googleusercontent.com/Ck5PMNr4QY_IqQFeKzpwZ086m_Lbg2cFZ_bnuASmHn_NHlDpY6WO8piF5E3lS44F6v0Sp6k0VijKn3LDOWEowdgGxpgryei6a_Q2pCLVR5uhaeKAVMyEzX5D-UGMcpvuSXJ3v3oe8mrMHm-a6R4AuGSNEPGUD7YyggLobFO_IPN9hef7Z48OZfpxPfq_YW7S7IufqwC9hIjDBb61ZqypC8T7Q19cbMhul4ee3MDmuOtdU_w-6FcCu2usuNNQeeAEk0DuM7npCNStNdMtTmNRn0rpKD7igLfKZgQwZSK-u6YpgPR3zIwYMPHlRyuL2rDsQ0Qq-jf4hwcvE22zkTg8bKMqrH7HtvUCu7N8J5sPBqVPk_WEgucW8WsLJShytmrm9jhbh5zd9VOqi1co8Ty9LSxyg7h6Njl0sPcQ7_bpVmUIyhsQW1fismJ-Yz1fXqK9pWy-yoMRxmeP_nwoyDgZdFyVb396BQuMllfLULnZ1YDHfjmMjWBRgPh2oG49v3mvq8kROgQirMMIVHfRWeusaPM3eAraI91-CrDAmMmOwAiGGliThZQLy5PDTueMz4rBo17Z7VkFATFa8KF4aT_R7mWpebCIL3sKQqqXWqLZ-gFjYYCtDhls4zni60i971fAiCEU5HY--YdJgd9JSlyDdE3CN9FEPHBt_NamMApm_5hyScTiNF-mU5i-nE5kQREbafDo63u4pommpQJ8Eb7HY5SbXSbW9YjKr0AnykgIXzrvNwWGZUPrFK7uY7gPJz1qPIuDQwJcLPWoR8uuCA=w798-h491-no#https://w3llsquad.or.id/assets/img/icon/w.png" style="border:0; padding: 20px; width: 110px; height: 80px;" class="CToWUd">
      <img src="https://lh3.googleusercontent.com/pw/AM-JKLWsAA6nWBx6HAExhC6an2B85TXGIaoF1OKQHSnF43xVseL2z0dgG0g6W_yhK13kMvOdjmZ0KBWR8eXa_wjbhAAYjao4JtgUclakwVGHoI9I14bHJosQYjX-F0NVJvGunaGkFKuoUEq6q_gVVvifCO1a=s549-no#https://i.ibb.co/nnPjxkL/favicon.png" width="91" style="border:0; padding: 20px;" class="CToWUd">
      </span>
      </td>
      </tr>
      <tr>
      <td>
      <div style="padding:0 30px;background:#fff">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tbody>
      <tr>
      <td style="border-bottom:1px solid #e6e6e6;font-size:18px;padding:20px 0 5px">
      <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <tbody>
      <tr>
      <td>Reset Password</td>
      </tr>
      </tbody>
      </table>
      </td>
      </tr>

      <tr>
      <td style="font-size:14px;line-height:30px;padding:20px 0;color:#666">Dear user!<br>Your verification code is :</td>
      </tr>
      <tr>
      <td>
      <table width="50%" border="0" cellspacing="0" cellpadding="0" align="center" style="background:#f8f8f8;border:1px solid #d6d6d6">
      <tbody>
      <tr>
      <td style="line-height:26px;padding:20px 0" align="center">
      <span style="padding:5px 0;font-size:20px;font-weight:bolder;color:#e9b434;text-align: center;">'.$this->balitbangDecode($this->balitbangDecode($code)).'</span>
      </td>
      </tr>
      </tbody>
      </table>
      </td>
      </tr>
      <tr>
      <td style="font-size:14px;line-height:30px;padding:5px 0;color:#666">If you are having trouble, please click <strong><a style="text-decoration: none;" target="_blank" rel="noreferrer" href="'.$this->base_url("/console/setpass/".$this->balitbangEncode($email)."/".$this->balitbangEncode($this->balitbangEncode($code))).'">verify now</a></strong> to make it easier.
      </td>
      </tr>
      <tr>
      <td style="font-size:14px;line-height:30px;padding:20px 0;color:#666">The code will remain valid for 10 minutes. Be sure to confirm that the domain name in the address bar is <strong><a href="myua.w3llsquad.or.id" style="text-decoration: none;">myua.w3llsquad.or.id</a></strong> before proceeding, beware of scams!</td>
      </tr>
      <tr>
      <td>
      <span style="padding:5px 0;font-weight:bolder;color:#F7010D">Security Warning :</span>
      </td>
      </tr>

      <tr>
      <td style="padding:10px 0 0 0;line-height:26px;color:#666">
      <ul style="margin-left: -20px;">
      <li>Don\'t tell anyone your password and second verification code!</li>
      <li>Do not contact any customer service claiming to be part of Myua!</li>
      <li>Don\'t send the verification code to anyone claiming to be part of Myua!</li>
      </ul>
      </td>
      </tr>
      <tr>
      <td style="padding:30px 0 15px 0;font-size:12px;color:#999;line-height:20px">W3LL Squad Team<br>System Mail, please do not reply
      </td>
      </tr>
      </tbody>
      </table>
      </div>
      </td>
      </tr>
      <tr>
      <td align="center" style="font-size:12px;color:#999;padding:20px 0">#WeGrowTogether ©W3LL Squad '.date("Y").'<br>Official website: <a href="www.w3llsquad.or.id" style="color:#999;text-decoration: none;">www.w3llsquad.or.id</a>
      </td>
      </tr>
      </tbody>
      </table>
      </td>
      </tr>
      </tbody>
      </table>';
    }
  }

  public function changePass($email=false, $params=[])
  {
    return '
    <table height="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:14px;font-family:Microsoft Yahei,Arial,Helvetica,sans-serif;padding:0;margin:0;color:#333;background: linear-gradient(50deg, #EFF2F7 0, #eff0f7 100%);background-repeat:repeat-x;background-position:bottom; width: 100%;">
    <tbody>
    <tr>
    <td>
    <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
    <td align="center" valign="middle" style="padding:33px 0; display: flex; text-align: center;">
    <span style="margin-left: auto;margin-right: auto;">
    <img src="https://lh3.googleusercontent.com/Ck5PMNr4QY_IqQFeKzpwZ086m_Lbg2cFZ_bnuASmHn_NHlDpY6WO8piF5E3lS44F6v0Sp6k0VijKn3LDOWEowdgGxpgryei6a_Q2pCLVR5uhaeKAVMyEzX5D-UGMcpvuSXJ3v3oe8mrMHm-a6R4AuGSNEPGUD7YyggLobFO_IPN9hef7Z48OZfpxPfq_YW7S7IufqwC9hIjDBb61ZqypC8T7Q19cbMhul4ee3MDmuOtdU_w-6FcCu2usuNNQeeAEk0DuM7npCNStNdMtTmNRn0rpKD7igLfKZgQwZSK-u6YpgPR3zIwYMPHlRyuL2rDsQ0Qq-jf4hwcvE22zkTg8bKMqrH7HtvUCu7N8J5sPBqVPk_WEgucW8WsLJShytmrm9jhbh5zd9VOqi1co8Ty9LSxyg7h6Njl0sPcQ7_bpVmUIyhsQW1fismJ-Yz1fXqK9pWy-yoMRxmeP_nwoyDgZdFyVb396BQuMllfLULnZ1YDHfjmMjWBRgPh2oG49v3mvq8kROgQirMMIVHfRWeusaPM3eAraI91-CrDAmMmOwAiGGliThZQLy5PDTueMz4rBo17Z7VkFATFa8KF4aT_R7mWpebCIL3sKQqqXWqLZ-gFjYYCtDhls4zni60i971fAiCEU5HY--YdJgd9JSlyDdE3CN9FEPHBt_NamMApm_5hyScTiNF-mU5i-nE5kQREbafDo63u4pommpQJ8Eb7HY5SbXSbW9YjKr0AnykgIXzrvNwWGZUPrFK7uY7gPJz1qPIuDQwJcLPWoR8uuCA=w798-h491-no#https://w3llsquad.or.id/assets/img/icon/w.png" style="border:0; padding: 20px; width: 110px; height: 80px;" class="CToWUd">
    <img src="https://lh3.googleusercontent.com/pw/AM-JKLWsAA6nWBx6HAExhC6an2B85TXGIaoF1OKQHSnF43xVseL2z0dgG0g6W_yhK13kMvOdjmZ0KBWR8eXa_wjbhAAYjao4JtgUclakwVGHoI9I14bHJosQYjX-F0NVJvGunaGkFKuoUEq6q_gVVvifCO1a=s549-no#https://i.ibb.co/nnPjxkL/favicon.png" width="91" style="border:0; padding: 20px;" class="CToWUd">
    </span>
    </td>
    </tr>
    <tr>
    <td>
    <div style="padding:0 30px;background:#fff">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
    <td style="border-bottom:1px solid #e6e6e6;font-size:18px;padding:20px 0 5px">
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tbody>
    <tr>
    <td>Your Password change</td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>

    <tr>
    <td style="font-size:14px;line-height:30px;padding:20px 0;color:#666">Dear user!<br>Your password for the Myua account <span style="color:#207DF0">'. $this->e($email) .'</span> was changed on '. date("d-m-Y h:i a") .'</td>
    </tr>
    <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background:#f8f8f8;border:1px solid #d6d6d6">
    <tbody>
    <tr>
    <td width="120" align="right" valign="middle">
    <img src="https://ci6.googleusercontent.com/proxy/Kb7ALjSJ-RgMYlshoJUfVTfFg5xUxbjqY9POlGgv63k-VyruSMONG_04RuwYVOrYmEm-rgIWu2BgED6a_uXo1ahG-v98OUf3=s0-d-e1-ft#https://bc.schail.com/static/image/message/device.jpg" width="58" height="44" style="border:0" class="CToWUd">
    </td>
    <td style="line-height:26px;padding:20px 0">
    <table border="0" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
    <td align="right" width="120">Location</td>
    <td align="center" width="20">:</td>
    <td>'.$params['location'].'</td>
    </tr>
    <tr>
    <td align="right" width="120">IP Address</td>
    <td align="center" width="20">:</td>
    <td>'.$params['ipaddress'].'</td>
    </tr>
    <tr>
    <td align="right" width="120">Device</td>
    <td align="center" width="20">:</td>
    <td>'.$params['device'].'</td>
    </tr>
    <tr>
    <td align="right" width="120">Browser</td>
    <td align="center" width="20">:</td>
    <td>'.$params['browser'].'</td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    <tr>
    <td style="font-size:14px;line-height:30px;padding:5px 0;color:#666">If this was you, then you can safely ignore this email.</td>
    </tr>
    <tr>
    <td style="font-size:14px;line-height:30px;padding:20px 20px 0 0;color:#666">If this isn\'t you, your account has been compromised. Please change the new password immediately.</td>
    </tr>
    <tr>
    <td style="font-size:14px; padding:0 0;color:#666">
    <strong><a href="'. $this->base_url("/console/reset/".$this->e($email)) .'" style="text-decoration: none;">Reset Password</a></strong>
    </td>
    </tr>
    <tr>
    <td style="padding:30px 0 15px 0;font-size:12px;color:#999;line-height:20px">W3LL Squad Team<br>System Mail, please do not reply
    </td>
    </tr>
    </tbody>
    </table>
    </div>
    </td>
    </tr>
    <tr>
    <td align="center" style="font-size:12px;color:#999;padding:20px 0">#WeGrowTogether ©W3LL Squad '.date("Y").'<br>Official website: <a href="www.w3llsquad.or.id" style="color:#999;text-decoration: none;">www.w3llsquad.or.id</a>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    ';
  }

  public function verificationEmail($email=false, $code=false)
  {
    return '
    <table height="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:14px;font-family:Microsoft Yahei,Arial,Helvetica,sans-serif;padding:0;margin:0;color:#333;background: linear-gradient(50deg, #EFF2F7 0, #eff0f7 100%);background-repeat:repeat-x;background-position:bottom; width: 100%;">
    <tbody>
    <tr>
    <td>
    <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
    <td align="center" valign="middle" style="padding:33px 0; display: flex; text-align: center;">
    <span style="margin-left: auto;margin-right: auto;">
    <img src="https://lh3.googleusercontent.com/Ck5PMNr4QY_IqQFeKzpwZ086m_Lbg2cFZ_bnuASmHn_NHlDpY6WO8piF5E3lS44F6v0Sp6k0VijKn3LDOWEowdgGxpgryei6a_Q2pCLVR5uhaeKAVMyEzX5D-UGMcpvuSXJ3v3oe8mrMHm-a6R4AuGSNEPGUD7YyggLobFO_IPN9hef7Z48OZfpxPfq_YW7S7IufqwC9hIjDBb61ZqypC8T7Q19cbMhul4ee3MDmuOtdU_w-6FcCu2usuNNQeeAEk0DuM7npCNStNdMtTmNRn0rpKD7igLfKZgQwZSK-u6YpgPR3zIwYMPHlRyuL2rDsQ0Qq-jf4hwcvE22zkTg8bKMqrH7HtvUCu7N8J5sPBqVPk_WEgucW8WsLJShytmrm9jhbh5zd9VOqi1co8Ty9LSxyg7h6Njl0sPcQ7_bpVmUIyhsQW1fismJ-Yz1fXqK9pWy-yoMRxmeP_nwoyDgZdFyVb396BQuMllfLULnZ1YDHfjmMjWBRgPh2oG49v3mvq8kROgQirMMIVHfRWeusaPM3eAraI91-CrDAmMmOwAiGGliThZQLy5PDTueMz4rBo17Z7VkFATFa8KF4aT_R7mWpebCIL3sKQqqXWqLZ-gFjYYCtDhls4zni60i971fAiCEU5HY--YdJgd9JSlyDdE3CN9FEPHBt_NamMApm_5hyScTiNF-mU5i-nE5kQREbafDo63u4pommpQJ8Eb7HY5SbXSbW9YjKr0AnykgIXzrvNwWGZUPrFK7uY7gPJz1qPIuDQwJcLPWoR8uuCA=w798-h491-no#https://w3llsquad.or.id/assets/img/icon/w.png" style="border:0; padding: 20px; width: 110px; height: 80px;" class="CToWUd">
    <img src="https://lh3.googleusercontent.com/pw/AM-JKLWsAA6nWBx6HAExhC6an2B85TXGIaoF1OKQHSnF43xVseL2z0dgG0g6W_yhK13kMvOdjmZ0KBWR8eXa_wjbhAAYjao4JtgUclakwVGHoI9I14bHJosQYjX-F0NVJvGunaGkFKuoUEq6q_gVVvifCO1a=s549-no#https://i.ibb.co/nnPjxkL/favicon.png" width="91" style="border:0; padding: 20px;" class="CToWUd">
    </span>
    </td>
    </tr>
    <tr>
    <td>
    <div style="padding:0 30px;background:#fff">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
    <td style="border-bottom:1px solid #e6e6e6;font-size:18px;padding:20px 0 5px">
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tbody>
    <tr>
    <td>Change Email Verification</td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>

    <tr>
    <td style="font-size:14px;line-height:30px;padding:20px 0;color:#666">Dear user!<br>Your verification code is :</td>
    </tr>
    <tr>
    <td>
    <table width="50%" border="0" cellspacing="0" cellpadding="0" align="center" style="background:#f8f8f8;border:1px solid #d6d6d6">
    <tbody>
    <tr>
    <td style="line-height:26px;padding:20px 0" align="center">
    <span style="padding:5px 0;font-size:20px;font-weight:bolder;color:#e9b434;text-align: center;">'.$this->balitbangDecode($this->balitbangDecode($code)).'</span>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    <tr>
    <td style="font-size:14px;line-height:30px;padding:20px 0;color:#666">The code will remain valid for 10 minutes. Be sure to confirm that the domain name in the address bar is <strong><a href="myua.w3llsquad.or.id" style="text-decoration: none;">myua.w3llsquad.or.id</a></strong> before proceeding, beware of scams!</td>
    </tr>
    <tr>
    <td>
    <span style="padding:5px 0;font-weight:bolder;color:#F7010D">Security Warning :</span>
    </td>
    </tr>

    <tr>
    <td style="padding:10px 0 0 0;line-height:26px;color:#666">
    <ul style="margin-left: -20px;">
    <li>Don\'t tell anyone your password and second verification code!</li>
    <li>Do not contact any customer service claiming to be part of Myua!</li>
    <li>Don\'t send the verification code to anyone claiming to be part of Myua!</li>
    </ul>
    </td>
    </tr>
    <tr>
    <td style="padding:30px 0 15px 0;font-size:12px;color:#999;line-height:20px">W3LL Squad Team<br>System Mail, please do not reply
    </td>
    </tr>
    </tbody>
    </table>
    </div>
    </td>
    </tr>
    <tr>
    <td align="center" style="font-size:12px;color:#999;padding:20px 0">#WeGrowTogether ©W3LL Squad '.date("Y").'<br>Official website: <a href="www.w3llsquad.or.id" style="color:#999;text-decoration: none;">www.w3llsquad.or.id</a>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    ';
  }

  public function changeEmail($email=false, $second_email=false, $params=[])
  {
    return '
    <table height="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:14px;font-family:Microsoft Yahei,Arial,Helvetica,sans-serif;padding:0;margin:0;color:#333;background: linear-gradient(50deg, #EFF2F7 0, #eff0f7 100%);background-repeat:repeat-x;background-position:bottom; width: 100%;">
    <tbody>
    <tr>
    <td>
    <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
    <td align="center" valign="middle" style="padding:33px 0; display: flex; text-align: center;">
    <span style="margin-left: auto;margin-right: auto;">
    <img src="https://lh3.googleusercontent.com/Ck5PMNr4QY_IqQFeKzpwZ086m_Lbg2cFZ_bnuASmHn_NHlDpY6WO8piF5E3lS44F6v0Sp6k0VijKn3LDOWEowdgGxpgryei6a_Q2pCLVR5uhaeKAVMyEzX5D-UGMcpvuSXJ3v3oe8mrMHm-a6R4AuGSNEPGUD7YyggLobFO_IPN9hef7Z48OZfpxPfq_YW7S7IufqwC9hIjDBb61ZqypC8T7Q19cbMhul4ee3MDmuOtdU_w-6FcCu2usuNNQeeAEk0DuM7npCNStNdMtTmNRn0rpKD7igLfKZgQwZSK-u6YpgPR3zIwYMPHlRyuL2rDsQ0Qq-jf4hwcvE22zkTg8bKMqrH7HtvUCu7N8J5sPBqVPk_WEgucW8WsLJShytmrm9jhbh5zd9VOqi1co8Ty9LSxyg7h6Njl0sPcQ7_bpVmUIyhsQW1fismJ-Yz1fXqK9pWy-yoMRxmeP_nwoyDgZdFyVb396BQuMllfLULnZ1YDHfjmMjWBRgPh2oG49v3mvq8kROgQirMMIVHfRWeusaPM3eAraI91-CrDAmMmOwAiGGliThZQLy5PDTueMz4rBo17Z7VkFATFa8KF4aT_R7mWpebCIL3sKQqqXWqLZ-gFjYYCtDhls4zni60i971fAiCEU5HY--YdJgd9JSlyDdE3CN9FEPHBt_NamMApm_5hyScTiNF-mU5i-nE5kQREbafDo63u4pommpQJ8Eb7HY5SbXSbW9YjKr0AnykgIXzrvNwWGZUPrFK7uY7gPJz1qPIuDQwJcLPWoR8uuCA=w798-h491-no#https://w3llsquad.or.id/assets/img/icon/w.png" style="border:0; padding: 20px; width: 110px; height: 80px;" class="CToWUd">
    <img src="https://lh3.googleusercontent.com/pw/AM-JKLWsAA6nWBx6HAExhC6an2B85TXGIaoF1OKQHSnF43xVseL2z0dgG0g6W_yhK13kMvOdjmZ0KBWR8eXa_wjbhAAYjao4JtgUclakwVGHoI9I14bHJosQYjX-F0NVJvGunaGkFKuoUEq6q_gVVvifCO1a=s549-no#https://i.ibb.co/nnPjxkL/favicon.png" width="91" style="border:0; padding: 20px;" class="CToWUd">
    </span>
    </td>
    </tr>
    <tr>
    <td>
    <div style="padding:0 30px;background:#fff">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
    <td style="border-bottom:1px solid #e6e6e6;font-size:18px;padding:20px 0 5px">
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tbody>
    <tr>
    <td>Your Email change</td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>

    <tr>
    <td style="font-size:14px;line-height:30px;padding:20px 0;color:#666">Dear user!<br>Your email for Myua account '. $this->e($email) .' has been changed to '. $this->e($second_email) .' on '. date("d-m-Y h:i a") .'</td>
    </tr>
    <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background:#f8f8f8;border:1px solid #d6d6d6">
    <tbody>
    <tr>
    <td width="120" align="right" valign="middle">
    <img src="https://ci6.googleusercontent.com/proxy/Kb7ALjSJ-RgMYlshoJUfVTfFg5xUxbjqY9POlGgv63k-VyruSMONG_04RuwYVOrYmEm-rgIWu2BgED6a_uXo1ahG-v98OUf3=s0-d-e1-ft#https://bc.schail.com/static/image/message/device.jpg" width="58" height="44" style="border:0" class="CToWUd">
    </td>
    <td style="line-height:26px;padding:20px 0">
    <table border="0" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
    <td align="right" width="120">Location</td>
    <td align="center" width="20">:</td>
    <td>'.$params['location'].'</td>
    </tr>
    <tr>
    <td align="right" width="120">IP Address</td>
    <td align="center" width="20">:</td>
    <td>'.$params['ipaddress'].'</td>
    </tr>
    <tr>
    <td align="right" width="120">Device</td>
    <td align="center" width="20">:</td>
    <td>'.$params['device'].'</td>
    </tr>
    <tr>
    <td align="right" width="120">Browser</td>
    <td align="center" width="20">:</td>
    <td>'.$params['browser'].'</td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    <tr>
    <td style="font-size:14px;line-height:30px;padding:5px 0;color:#666">If this was you, then you can safely ignore this email.</td>
    </tr>
    <tr>
    <td style="padding:30px 0 15px 0;font-size:12px;color:#999;line-height:20px">W3LL Squad Team<br>System Mail, please do not reply
    </td>
    </tr>
    </tbody>
    </table>
    </div>
    </td>
    </tr>
    <tr>
    <td align="center" style="font-size:12px;color:#999;padding:20px 0">#WeGrowTogether ©W3LL Squad '.date("Y").'<br>Official website: <a href="www.w3llsquad.or.id" style="color:#999;text-decoration: none;">www.w3llsquad.or.id</a>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    ';
  }

  public function removeEmail($email=false, $params=[])
  {
    return '
    <table height="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:14px;font-family:Microsoft Yahei,Arial,Helvetica,sans-serif;padding:0;margin:0;color:#333;background: linear-gradient(50deg, #EFF2F7 0, #eff0f7 100%);background-repeat:repeat-x;background-position:bottom; width: 100%;">
    <tbody>
    <tr>
    <td>
    <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
    <td align="center" valign="middle" style="padding:33px 0; display: flex; text-align: center;">
    <span style="margin-left: auto;margin-right: auto;">
    <img src="https://lh3.googleusercontent.com/Ck5PMNr4QY_IqQFeKzpwZ086m_Lbg2cFZ_bnuASmHn_NHlDpY6WO8piF5E3lS44F6v0Sp6k0VijKn3LDOWEowdgGxpgryei6a_Q2pCLVR5uhaeKAVMyEzX5D-UGMcpvuSXJ3v3oe8mrMHm-a6R4AuGSNEPGUD7YyggLobFO_IPN9hef7Z48OZfpxPfq_YW7S7IufqwC9hIjDBb61ZqypC8T7Q19cbMhul4ee3MDmuOtdU_w-6FcCu2usuNNQeeAEk0DuM7npCNStNdMtTmNRn0rpKD7igLfKZgQwZSK-u6YpgPR3zIwYMPHlRyuL2rDsQ0Qq-jf4hwcvE22zkTg8bKMqrH7HtvUCu7N8J5sPBqVPk_WEgucW8WsLJShytmrm9jhbh5zd9VOqi1co8Ty9LSxyg7h6Njl0sPcQ7_bpVmUIyhsQW1fismJ-Yz1fXqK9pWy-yoMRxmeP_nwoyDgZdFyVb396BQuMllfLULnZ1YDHfjmMjWBRgPh2oG49v3mvq8kROgQirMMIVHfRWeusaPM3eAraI91-CrDAmMmOwAiGGliThZQLy5PDTueMz4rBo17Z7VkFATFa8KF4aT_R7mWpebCIL3sKQqqXWqLZ-gFjYYCtDhls4zni60i971fAiCEU5HY--YdJgd9JSlyDdE3CN9FEPHBt_NamMApm_5hyScTiNF-mU5i-nE5kQREbafDo63u4pommpQJ8Eb7HY5SbXSbW9YjKr0AnykgIXzrvNwWGZUPrFK7uY7gPJz1qPIuDQwJcLPWoR8uuCA=w798-h491-no#https://w3llsquad.or.id/assets/img/icon/w.png" style="border:0; padding: 20px; width: 110px; height: 80px;" class="CToWUd">
    <img src="https://lh3.googleusercontent.com/pw/AM-JKLWsAA6nWBx6HAExhC6an2B85TXGIaoF1OKQHSnF43xVseL2z0dgG0g6W_yhK13kMvOdjmZ0KBWR8eXa_wjbhAAYjao4JtgUclakwVGHoI9I14bHJosQYjX-F0NVJvGunaGkFKuoUEq6q_gVVvifCO1a=s549-no#https://i.ibb.co/nnPjxkL/favicon.png" width="91" style="border:0; padding: 20px;" class="CToWUd">
    </span>
    </td>
    </tr>
    <tr>
    <td>
    <div style="padding:0 30px;background:#fff">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
    <td style="border-bottom:1px solid #e6e6e6;font-size:18px;padding:20px 0 5px">
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tbody>
    <tr>
    <td>Remove Email</td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>

    <tr>
    <td style="font-size:14px;line-height:30px;padding:20px 0;color:#666">Dear user!<br>Your email for Myua account '. $this->e($email) .' has been removed on '. date("d-m-Y h:i a") .'</td>
    </tr>
    <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background:#f8f8f8;border:1px solid #d6d6d6">
    <tbody>
    <tr>
    <td width="120" align="right" valign="middle">
    <img src="https://ci6.googleusercontent.com/proxy/Kb7ALjSJ-RgMYlshoJUfVTfFg5xUxbjqY9POlGgv63k-VyruSMONG_04RuwYVOrYmEm-rgIWu2BgED6a_uXo1ahG-v98OUf3=s0-d-e1-ft#https://bc.schail.com/static/image/message/device.jpg" width="58" height="44" style="border:0" class="CToWUd">
    </td>
    <td style="line-height:26px;padding:20px 0">
    <table border="0" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
    <td align="right" width="120">Location</td>
    <td align="center" width="20">:</td>
    <td>'.$params['location'].'</td>
    </tr>
    <tr>
    <td align="right" width="120">IP Address</td>
    <td align="center" width="20">:</td>
    <td>'.$params['ipaddress'].'</td>
    </tr>
    <tr>
    <td align="right" width="120">Device</td>
    <td align="center" width="20">:</td>
    <td>'.$params['device'].'</td>
    </tr>
    <tr>
    <td align="right" width="120">Browser</td>
    <td align="center" width="20">:</td>
    <td>'.$params['browser'].'</td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    <tr>
    <td style="font-size:14px;line-height:30px;padding:5px 0;color:#666">If this was you, then you can safely ignore this email.</td>
    </tr>
    <tr>
    <td style="padding:30px 0 15px 0;font-size:12px;color:#999;line-height:20px">W3LL Squad Team<br>System Mail, please do not reply
    </td>
    </tr>
    </tbody>
    </table>
    </div>
    </td>
    </tr>
    <tr>
    <td align="center" style="font-size:12px;color:#999;padding:20px 0">#WeGrowTogether ©W3LL Squad '.date("Y").'<br>Official website: <a href="www.w3llsquad.or.id" style="color:#999;text-decoration: none;">www.w3llsquad.or.id</a>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    ';
  }

  public function addEmail($email=false, $params=[])
  {
    return '
    <table height="100%" cellpadding="0" cellspacing="0" border="0" style="font-size:14px;font-family:Microsoft Yahei,Arial,Helvetica,sans-serif;padding:0;margin:0;color:#333;background: linear-gradient(50deg, #EFF2F7 0, #eff0f7 100%);background-repeat:repeat-x;background-position:bottom; width: 100%;">
    <tbody>
    <tr>
    <td>
    <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
    <td align="center" valign="middle" style="padding:33px 0; display: flex; text-align: center;">
    <span style="margin-left: auto;margin-right: auto;">
    <img src="https://lh3.googleusercontent.com/Ck5PMNr4QY_IqQFeKzpwZ086m_Lbg2cFZ_bnuASmHn_NHlDpY6WO8piF5E3lS44F6v0Sp6k0VijKn3LDOWEowdgGxpgryei6a_Q2pCLVR5uhaeKAVMyEzX5D-UGMcpvuSXJ3v3oe8mrMHm-a6R4AuGSNEPGUD7YyggLobFO_IPN9hef7Z48OZfpxPfq_YW7S7IufqwC9hIjDBb61ZqypC8T7Q19cbMhul4ee3MDmuOtdU_w-6FcCu2usuNNQeeAEk0DuM7npCNStNdMtTmNRn0rpKD7igLfKZgQwZSK-u6YpgPR3zIwYMPHlRyuL2rDsQ0Qq-jf4hwcvE22zkTg8bKMqrH7HtvUCu7N8J5sPBqVPk_WEgucW8WsLJShytmrm9jhbh5zd9VOqi1co8Ty9LSxyg7h6Njl0sPcQ7_bpVmUIyhsQW1fismJ-Yz1fXqK9pWy-yoMRxmeP_nwoyDgZdFyVb396BQuMllfLULnZ1YDHfjmMjWBRgPh2oG49v3mvq8kROgQirMMIVHfRWeusaPM3eAraI91-CrDAmMmOwAiGGliThZQLy5PDTueMz4rBo17Z7VkFATFa8KF4aT_R7mWpebCIL3sKQqqXWqLZ-gFjYYCtDhls4zni60i971fAiCEU5HY--YdJgd9JSlyDdE3CN9FEPHBt_NamMApm_5hyScTiNF-mU5i-nE5kQREbafDo63u4pommpQJ8Eb7HY5SbXSbW9YjKr0AnykgIXzrvNwWGZUPrFK7uY7gPJz1qPIuDQwJcLPWoR8uuCA=w798-h491-no#https://w3llsquad.or.id/assets/img/icon/w.png" style="border:0; padding: 20px; width: 110px; height: 80px;" class="CToWUd">
    <img src="https://lh3.googleusercontent.com/pw/AM-JKLWsAA6nWBx6HAExhC6an2B85TXGIaoF1OKQHSnF43xVseL2z0dgG0g6W_yhK13kMvOdjmZ0KBWR8eXa_wjbhAAYjao4JtgUclakwVGHoI9I14bHJosQYjX-F0NVJvGunaGkFKuoUEq6q_gVVvifCO1a=s549-no#https://i.ibb.co/nnPjxkL/favicon.png" width="91" style="border:0; padding: 20px;" class="CToWUd">
    </span>
    </td>
    </tr>
    <tr>
    <td>
    <div style="padding:0 30px;background:#fff">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
    <td style="border-bottom:1px solid #e6e6e6;font-size:18px;padding:20px 0 5px">
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tbody>
    <tr>
    <td>Added Email</td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>

    <tr>
    <td style="font-size:14px;line-height:30px;padding:20px 0 0 0;color:#666">Dear user!<br>Your email '. $this->e($email) .'  for Myua account has been added on '. date("d-m-Y h:i a") .'</td>
    </tr>
    <tr>
    <td style="font-size:14px;line-height:10px;padding:5px 0 20px 0;color:#666">
    <strong><a href="'. $this->base_url() .'" style="text-decoration: none;">Login Now</a></strong>
    </td>
    </tr>
    <tr>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background:#f8f8f8;border:1px solid #d6d6d6">
    <tbody>
    <tr>
    <td width="120" align="right" valign="middle">
    <img src="https://ci6.googleusercontent.com/proxy/Kb7ALjSJ-RgMYlshoJUfVTfFg5xUxbjqY9POlGgv63k-VyruSMONG_04RuwYVOrYmEm-rgIWu2BgED6a_uXo1ahG-v98OUf3=s0-d-e1-ft#https://bc.schail.com/static/image/message/device.jpg" width="58" height="44" style="border:0" class="CToWUd">
    </td>
    <td style="line-height:26px;padding:20px 0">
    <table border="0" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
    <td align="right" width="120">Location</td>
    <td align="center" width="20">:</td>
    <td>'.$params['location'].'</td>
    </tr>
    <tr>
    <td align="right" width="120">IP Address</td>
    <td align="center" width="20">:</td>
    <td>'.$params['ipaddress'].'</td>
    </tr>
    <tr>
    <td align="right" width="120">Device</td>
    <td align="center" width="20">:</td>
    <td>'.$params['device'].'</td>
    </tr>
    <tr>
    <td align="right" width="120">Browser</td>
    <td align="center" width="20">:</td>
    <td>'.$params['browser'].'</td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    <tr>
    <td style="font-size:14px;line-height:30px;padding:5px 0;color:#666">If this was you, then you can safely ignore this email.</td>
    </tr>
    <tr>
    <td style="padding:30px 0 15px 0;font-size:12px;color:#999;line-height:20px">W3LL Squad Team<br>System Mail, please do not reply
    </td>
    </tr>
    </tbody>
    </table>
    </div>
    </td>
    </tr>
    <tr>
    <td align="center" style="font-size:12px;color:#999;padding:20px 0">#WeGrowTogether ©W3LL Squad '.date("Y").'<br>Official website: <a href="www.w3llsquad.or.id" style="color:#999;text-decoration: none;">www.w3llsquad.or.id</a>
    </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
    ';
  }
}