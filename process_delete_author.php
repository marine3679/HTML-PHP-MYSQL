<?php
  $conn = mysqli_connect('localhost','root','','opentutorials');
  settype($_POST['id'],'integer');
  //block sql injection
  $filtered = array(
    'id'=>mysqli_real_escape_string($conn, $_POST['id'])
  );

  $sql = "
    DELETE FROM author
      WHERE id = {$filtered['id']}
    ";
  // die($sql);
  $result = mysqli_query($conn, $sql);
  if($result === false) {
    echo 'Problem.';
    error_log(mysqli_error($conn));
  } else {
    header("Location: author.php");
  }
?>
