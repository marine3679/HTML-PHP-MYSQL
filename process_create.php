<?php
  $conn = mysqli_connect('localhost','root','','opentutorials');
  //block sql injection
  $filtered = array(
    'title'=>mysqli_real_escape_string($conn, $_POST['title']),
    'description'=>mysqli_real_escape_string($conn, $_POST['description']),
    'author_id'=>mysqli_real_escape_string($conn, $_POST['author_id'])
  );

  $sql = "
    INSERT INTO topic (title,description,created,author_id)
    VALUES ('{$filtered['title']}','{$filtered['description']}',NOW(), {$filtered['author_id']})
    ";

    // die($sql);
  $result = mysqli_query($conn, $sql);
  if($result === false) {
    echo 'Problem.';
    error_log(mysqli_error($conn));
  } else {
    echo '성공했습니다. <a href="index.php">돌아가기</a>';
  }
?>
