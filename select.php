<?php

  $conn = mysqli_connect('localhost','root','','opentutorials');
  $sql = "SELECT * FROM topic LIMIT 1000";
  $result = mysqli_query($conn, $sql);

?>
