<!-- 註冊頁面 -->
<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require './vendor/autoload.php';
require './classes/Config.php';
$mail = new PHPMailer();
if (isset($_POST['submit'])) {

    $to = $_POST['email'];
    $subject = wordwrap($_POST['subject'],70);
    $body = $_POST['body'];

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
        $mail->addAddress(Config::SMTP_USERNAME);
        $mail->isHTML(true);
        // 標題亂碼處理方式
        $mail->Subject =" =?utf-8?B?" . base64_encode($subject) . "?=";
        // 信件內容
        $mail->Body = '<h3>'.$to.'</h3><br><p>'.$body.'</p>';
        if ($mail->send()) {
            echo "IT WAS SENT";
        }else{
            echo "NOT SENT";
        }
       
        
     }
     catch(Exception $e){
        
     }
}

?>


<!-- Navigation -->

<?php include "includes/navigation.php"; ?>


<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>聯絡我們</h1>
                        <form role="form" action="" method="post" id="login-form" autocomplete="off">


                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div>
                            <div class="form-group">
                                <label for="subject" class="sr-only">標題</label>
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="輸入標題">
                            </div>
                            <div class="form-group">

                                <textarea class="form-control" name="body" id="body" cols="30" rows="10" placeholder="輸入內容"></textarea>
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="送出">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php"; ?>