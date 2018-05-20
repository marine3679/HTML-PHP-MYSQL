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
  //block sql injection
  $filtered = array(
    'id'=>$_POST['id'],
    'title'=>$_POST['title'],
    'description'=>$_POST['description']
  );

  $sql = "
    UPDATE topic
      SET
        title = :title,
        description = :description
      WHERE
        id = :id
    ";

  try {
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':id', $id);

    // insert one row
    $title = $filtered['title'];
    $description = $filtered['description'];
    $id = $filtered['id'];
    $stmt->execute();
    echo '성공했습니다. <a href="index.php">돌아가기</a>';
  } catch(Exception $e) {
    error_log($e->getMessage());
    echo "Failed: " . $e->getMessage();
  }
?>
