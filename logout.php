<?php //Remove all session data and redirect home
  session_start();
  session_unset();
  session_destroy();
  header("Location: index.php");
  exit();