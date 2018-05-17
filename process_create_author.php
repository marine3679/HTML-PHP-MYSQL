<?php
  $conn = mysqli_connect('localhost','root','','opentutorials');
  //block sql injection
  $filtered = array(
    'name'=>mysqli_real_escape_string($conn, $_POST['name']),
    'profile'=>mysqli_real_escape_string($conn, $_POST['profile'])
  );

  $sql = "
    INSERT INTO author (name,profile)
    VALUES ('{$filtered['name']}','{$filtered['profile']}')
    ";

  $result = mysqli_query($conn, $sql);
  if($result === false) {
    echo 'Problem.';
    error_log(mysqli_error($conn));
  } else {
    header("Location: author.php");
  }
?>
