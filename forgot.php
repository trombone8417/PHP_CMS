<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require './vendor/autoload.php';
// require './classes/Config.php';
// composer dump-autoload -o
$mail = new PHPMailer();

if (!isset($_GET['forgot'])) {
    redirect('index.php');
}
if(ifItIsMethod('post')){
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));
        // 輸入email，若帳號存在的話，更新token
        if (email_exists($email)) {
            if ($stmt = mysqli_prepare($connection,"UPDATE users SET token='{$token}' WHERE user_email=?")) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                try{
                    // 驗證信箱
                    $mail->Charset='UTF-8';
                    $mail->isSMTP();
                    $mail->Host = Config::SMTP_HOST;
                    $mail->SMTPAuth = true;
                    // 寄件者帳號
                    $mail->Username = Config::SMTP_USERNAME;
                    // 寄件者帳號的密碼
                    $mail->Password = Config::SMTP_PASSWORD;
                    $mail->SMTPSecure= PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = Config::SMTP_PORT;
                    // 寄件者名稱
                    $mail->setFrom(Config::SMTP_USERNAME, 'PHP_CMS');
                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    // 標題亂碼處理方式
                    $mail->Subject =" =?utf-8?B?" . base64_encode("PHP_CMS 忘記密碼") . "?=";
                    // 信件內容
                    $mail->Body = '<p>請點選重置密碼<a href="http://127.0.0.1/PHP_CMS/reset.php?email='.$email.'&token='.$token.'">http://127.0.0.1/PHP_CMS/reset.php?email='.$email.'&token='.$token.'</a></p>';
                    if ($mail->send()) {
                        $emailSent = true;
                    }else{
                        $emailSent = false;
                    }
                   
                    
                 }
                 catch(Exception $e){
                    
                 }
            }
        }
    }
}

?>

<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                            <?php if(!isset($emailSent)): ?>
                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">




                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->
                            <?php else: ?>
                                <h2>Please check your email</h2>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

