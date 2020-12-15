<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php 

echo loggedInUserId();
if (userLikedThisPost(40)) {
    echo "USER LIKED IT";
}
else{
    echo "DID NOT LIKED IT ";
}
?>