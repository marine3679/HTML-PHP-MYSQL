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
    'id'=>$_POST['id']
  );

  $sql = "
    DELETE FROM author
      WHERE id = :id
    ";
  //insert first
  try {
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id);

    // insert one row
    $id = $filtered['id'];
    $stmt->execute();
    header("Location: author.php");
  } catch(Exception $e) {
    error_log($e->getMessage());
    echo "Failed: " . $e->getMessage();
  }
?>
