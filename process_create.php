<?php
  // $conn = mysqli_connect('localhost','root','','opentutorials');
  try {
    $dbh = new PDO('mysql:host=localhost;dbname=opentutorials', 'root', '');
    //persistent connection
    // $dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass, array(
    //     PDO::ATTR_PERSISTENT => true
    // ));
  } catch (Exception $e) {
      die("Unable to connect: " . $e->getMessage());
  }

  $filtered = array(
    'author_id'=> $_POST['author_id'],
    'title'=>$_POST['title'],
    'description'=>$_POST['description']
  );

  // $sql = "
  //   INSERT INTO topic (title,description,created,author_id)
  //   VALUES ('{$filtered['title']}','{$filtered['description']}',NOW(), {$filtered['author_id']})
  //   ";
  //insert first
  // try {
  //   $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //
  //   $dbh->beginTransaction();
  //   $dbh->exec($sql);
  //   $dbh->commit();
  //   echo '성공했습니다. <a href="index.php">돌아가기</a>';
  //
  // } catch (Exception $e) {
  //   $dbh->rollBack();
  //   error_log($e->getMessage());
  //   echo "Failed: " . $e->getMessage();
  // }

  //insert second
  $sql = "
    INSERT INTO topic (title,description,created,author_id)
    VALUES (:title, :description, NOW(), :author_id)
    ";
  try {
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':author_id', $author_id);

    // insert one row
    $title = $filtered['title'];
    $description = $filtered['description'];
    $author_id = $filtered['author_id'];
    $stmt->execute();
    echo '성공했습니다. <a href="index.php">돌아가기</a>';
  } catch(Exception $e) {
    error_log($e->getMessage());
    echo "Failed: " . $e->getMessage();
  }


  //insert third
  // $sql = "
  //   INSERT INTO topic (title,description,created,author_id)
  //   VALUES (?, ?, NOW(), ?)
  //   ";
  //
  // $stmt = $dbh->prepare($sql);
  // $stmt->bindParam(1, $title);
  // $stmt->bindParam(2, $description);
  // $stmt->bindParam(3, $author_id);
  //
  // // insert one row
  // $title = $filtered['title'];
  // $description = $filtered['description'];
  // $author_id = $filtered['author_id'];
  // $stmt->execute();
?>
