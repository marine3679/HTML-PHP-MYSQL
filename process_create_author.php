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
  //block sql injection
  $filtered = array(
    'name'=>$_POST['name'],
    'profile'=>$_POST['profile']
  );

  $sql = "
    INSERT INTO author (name,profile)
    VALUES (:name,:profile)
    ";

  try {
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':profile', $profile);

    // insert one row
    $name = $filtered['name'];
    $profile = $filtered['profile'];
    $stmt->execute();
    header("Location: author.php");
  } catch(Exception $e) {
    error_log($e->getMessage());
    echo "Failed: " . $e->getMessage();
  }
?>
