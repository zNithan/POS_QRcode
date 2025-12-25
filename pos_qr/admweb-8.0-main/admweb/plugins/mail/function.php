<?php
require PATH_PLUGIN . '/mail/PHPMailerAutoload.php';
/*
 * $title
 * $aMail['emailfrom']
 * $aMail['emailto']
 * $aMail['ฺBCC']
 * $aMail['emailname']
 * $aMail['content']
 */

function Plugin_sendMail($title, $aMail, $isShow = false)
{
    date_default_timezone_set('Asia/Bangkok');
    $mail = new PHPMailer;
    if ($isShow == true) {
        $mail->SMTPDebug = 3;
    } else {
        $mail->SMTPDebug = 0;
    }
    $isSmtp = GlobalConfig_get('isSmtp');
    $sender     = GlobalConfig_get('smtp_sender');
    $sendername = GlobalConfig_get('smtp_sendername');
    if ($isSmtp == 1) {
        $mail->isSMTP();
        $host = GlobalConfig_get('smtp_host');
        $port = GlobalConfig_get('smtp_port');
        $Username = GlobalConfig_get('smtp_user');
        $Password = GlobalConfig_get('smtp_pass');
        $SMTPSecure = GlobalConfig_get('SMTPSecure');
        $mail->SMTPAuth = true;
        $mail->Host = $host;
        $mail->SMTPSecure = $SMTPSecure;
        $mail->Username = $Username;
        $mail->Password = $Password;
        $mail->Port = $port;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
    } else {
        $mail->isMail();
    }
    $mail->isHTML(true);
    $mail->setFrom($sender, $sendername);
    $mail->addAddress($aMail['emailto'], $sendername);
    $mail->addReplyTo($sender, $sendername);
    $mail->From     = $sender;
    $mail->FromName = $sendername;
    $mail->CharSet = 'UTF-8';
    $mail->Priority = 0;
    $mail->WordWrap = 50;
    $mail->Subject  = $title;
    $mail->Body     =  $aMail['content'];
    $mail->AltBody  =  $aMail['content'];
    if ($aMail['BCC'] != '') {
        if (is_array($aMail['BCC'])) {
            foreach ($aMail['BCC'] as $k => $v) {
                $mail->addBCC($v);
            }
        }
    }
    $res = (!$mail->Send()) ? 'error' : 'ok';
    $log = base64_encode(json_encode($aMail));
    $header = array();
    $header['Subject'] = $mail->Subject;
    $header['Port'] = $mail->Port;
    $header['Host'] = $mail->Host;
    $header['From'] = $mail->From;
    $header['Username'] = $mail->Username;
    $header['Password'] = '*****';
    $header['FromName'] = $mail->FromName;
    $header['To'] = $aMail['emailto'];
    $header['ReplyTo'] = $sender;
    $header['setFrom'] = $sender . '(' . $sendername . ')';
    return array('res' => $res, 'logs' => $log, 'header' => $header);
}
