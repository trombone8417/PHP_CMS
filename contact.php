<!-- 註冊頁面 -->
<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php

if (isset($_POST['submit'])) {

//     $to = "kuei@gm.ttu.edu.tw";
//     $subject = wordwrap($_POST['subject'],70);
//     $body = $_POST['body'];
    
//     $headers =  'MIME-Version: 1.0' . "\r\n"; 
// $headers .= 'From: kuei@gm.ttu.edu.tw' . "\r\n";
// $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
 
// // send email
// mail($to,$subject,$body,$headers);

// the message
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("kuei@gm.ttu.edu.tw","My subject",$msg);
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
    
    <textarea class="form-control" name="body" id="body"  cols="30" rows="10" placeholder="輸入內容"></textarea>
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