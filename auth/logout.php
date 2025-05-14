<?php
session_start();
session_unset();
session_destroy();

// header("Location: ../");
echo "<script>alert('Successfully logout!'); window.location.href='../';</script>";
exit;
?>