<?php
   include "conectar.php";
   mysqli_close($conectar);
   setcookie("ufunc");
   setcookie("sfunc");
   header ("Location: index.html");
?>