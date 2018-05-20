<?php
  // $conn = mysqli_connect('localhost','root','','opentutorials');

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
    $dbh = null;
  } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
  }

  $article = array(
    'title' => "welcome",
    'description' => "Welcome to the web",
    'name' => ""
  );
  $update_link = '';
  $delete_link = '';
  if(isset($_GET['id'])) {
    $dbh = new PDO('mysql:host=localhost;dbname=opentutorials', 'root', '');
    $sql = "SELECT * FROM topic LEFT JOIN author on topic.author_id=author.id WHERE topic.id = ? ";
    // die($sql);
    $stmt = $dbh->prepare($sql);
    if ($stmt->execute(array($_GET['id']))) {
      while ($row = $stmt->fetch()) {
        $article['title'] = htmlspecialchars($row['title']);
        $article['description'] = htmlspecialchars($row['description']);
        $article['name'] = "by ".htmlspecialchars($row['name']);
      }
    }
    $stmt = null;
    $dbh = null;
    $update_link = '<a href="update.php?id='.$_GET['id'].'">update</a>';
    $delete_link = "
      <form action=\"process_delete.php\" method=\"POST\">
        <input type=\"hidden\" name=\"id\"value=\"{$_GET['id']}\">
        <input type=\"submit\" value=\"delete\">
      </form>
    ";
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
    <a href="author.php">author</a>
    <ol>
      <?=$list?>
    </ol>
    <p><a href="create.php">create</a></p>
    <?=$update_link?>
    <?=$delete_link?>
    <h2><?=$article['title'] ?></h2>
    <?=$article['description'] ?>
    <p><?=$article['name'] ?></p>
  </body>
</html>
