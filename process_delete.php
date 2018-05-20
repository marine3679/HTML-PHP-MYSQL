<?php
  try {
    $dbh = new PDO('mysql:host=localhost;dbname=opentutorials', 'root', '');
    //persistent connection
    // $dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass, array(
    //     PDO::ATTR_PERSISTENT => true
    // ));
  } catch (Exception $e) {
      die("Unable to connect: " . $e->getMessage());
  }
  settype($_POST['id'],'integer');

  $filtered = array(
    'id'=> $_POST['id']
  );

  $sql = "
    DELETE FROM topic
      WHERE id = :id
    ";
  //insert first
  try {
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id);

    // insert one row
    $id = $filtered['id'];
    $stmt->execute();
    echo '성공했습니다. <a href="index.php">돌아가기</a>';
  } catch(Exception $e) {
    error_log($e->getMessage());
    echo "Failed: " . $e->getMessage();
  }
?>
