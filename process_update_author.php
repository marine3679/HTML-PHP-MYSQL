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
    'name'=>$_POST['name'],
    'profile'=>$_POST['profile']
  );

  $sql = "
    UPDATE author
      SET
        name = :name,
        profile = :profile
      WHERE
        id = :id
    ";
  try {
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':profile', $profile);
    $stmt->bindParam(':id', $id);

    // insert one row
    $name = $filtered['name'];
    $profile = $filtered['profile'];
    $id = $filtered['id'];
    $stmt->execute();
    header("Location: author.php?id={$filtered['id']}");
  } catch(Exception $e) {
    error_log($e->getMessage());
    echo "Failed: " . $e->getMessage();
  }
?>
