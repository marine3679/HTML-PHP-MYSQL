<?php
  $conn = mysqli_connect('localhost','root','','opentutorials');
  settype($_POST['id'],'integer');
  //block sql injection
  $filtered = array(
    'id'=>mysqli_real_escape_string($conn, $_POST['id']),
    'title'=>mysqli_real_escape_string($conn, $_POST['title']),
    'description'=>mysqli_real_escape_string($conn, $_POST['description'])
  );

  $sql = "
    UPDATE topic
      SET
        title = '{$filtered['title']}',
        description = '{$filtered['description']}'
      WHERE
        id = {$filtered['id']}
    ";
  $result = mysqli_query($conn, $sql);
  if($result === false) {
    echo 'Problem.';
    error_log(mysqli_error($conn));
  } else {
    echo '성공했습니다. <a href="index.php">돌아가기</a>';
  }
?>
