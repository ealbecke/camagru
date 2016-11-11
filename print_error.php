<?php
echo $_SESSION['flash']['mail_token'];
echo $_SESSION['flash']['validate'];
echo $_SESSION['flash']['inscription'];
echo $_SESSION['flash']['pb'];
echo $_SESSION['flash']['new_pwd'];

$_SESSION['flash']['validate'] = NULL;
$_SESSION['flash']['mail_token'] = NULL;
$_SESSION['flash']['inscription'] = NULL;
$_SESSION['flash']['pb'] = NULL;
$_SESSION['flash']['new_pwd'] = NULL;
?>