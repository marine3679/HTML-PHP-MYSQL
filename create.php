<?php

  try {
    $dbh = new PDO('mysql:host=localhost;dbname=opentutorials', 'root', '');
    //persistent connection
    // $dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass, array(
    //     PDO::ATTR_PERSISTENT => true
    // ));
    $sql = "SELECT * FROM topic LIMIT 1000";

    $list = "";
    $sth = $dbh->query($sql);
    foreach($sth as $row) {
        $escaped_title = htmlspecialchars($row['title']);
        $list = $list."<li><a href=\"index.php?id={$row['id']}\">{$escaped_title}</a></li>";
    }
    $sth = null;
  } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
  }

  $sql ="SELECT * FROM author";
  // $stmt = $dbh->prepare("SELECT * FROM REGISTRY where name = ?");
  // if ($stmt->execute(array($_GET['name']))) {
  //   while ($row = $stmt->fetch()) {
  //     print_r($row);
  //   }
  // }
  $select_form = "<SELECT name=\"author_id\">";
  $stmt = $dbh->prepare($sql);
  if ($stmt->execute(array())) {
    while ($row = $stmt->fetch()) {
      $escaped_name = htmlspecialchars($row['name']);
      $select_form .= "<OPTION value=\"{$row['id']}\">{$escaped_name}</OPTION>";
    }
  }
  $select_form .= "</SELECT>";

?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>WEB</title>
  </head>
  <body>
    <h1><a href = "index.php">WEB</a></h1>
    <ol>
      <?=$list?>
    </ol>
      <form action="process_create.php" method="POST">
        <p><input type="text" name="title" placeholder="title"></p>
        <p><textarea name="description" placeholder="description"></textarea></p>
        <?=$select_form?>
        <p><input type="submit" value="create"></p>
      </form>
    </body>
</html>
