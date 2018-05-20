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
  $article = array(
    'title' => "welcome",
    'description' => "Welcome to the web"
  );
  $update_link = '';
  if(isset($_GET['id'])) {
    //block sql injection
    $sql = "SELECT * FROM topic WHERE id = {$_GET['id']}";
    $stmt = $dbh->prepare($sql);
    if ($stmt->execute(array($_GET['id']))) {
      while ($row = $stmt->fetch()) {
        $article['title'] = htmlspecialchars($row['title']);
        $article['description'] = htmlspecialchars($row['description']);
      }
    }

    $update_link = '<a href="update.php?id='.$_GET['id'].'">update</a>';
  }

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
    <form action="process_update.php" method="POST">
      <input type="hidden" name="id" value="<?=$_GET['id']?>">
      <p><input type="text" name="title" placeholder="title" value=<?=$article['title']?>></p>
      <p><textarea name="description" placeholder="description"><?=$article['description']?></textarea></p>
      <p><input type="submit"></p>
    </form>
    </body>
</html>
