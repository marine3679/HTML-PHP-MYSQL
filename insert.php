<?php

$conn = mysqli_connect('localhost','root','','opentutorials');
$sql = "INSER INTO topic (title,description,created) VALUES ('MySQL','MySQL is ....',NOW())";
echo $sql;
$result = mysqli_query($conn, $sql);
if($result === false) {
  echo mysqli_error($conn);
}

?>
