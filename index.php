<?php
  $conn = mysqli_connect('localhost','root','','opentutorials');
  $sql = "SELECT * FROM topic LIMIT 1000";
  $result = mysqli_query($conn, $sql);
  $list = "";
  while($row = mysqli_fetch_array($result)) {
    // block bad output data
    $escaped_title = htmlspecialchars($row['title']);
    $list = $list."<li><a href=\"index.php?id={$row['id']}\">{$escaped_title}</a></li>";
  }
  $article = array(
    'title' => "welcome",
    'description' => "Welcome to the web",
    'name' => ""
  );
  $update_link = '';
  $delete_link = '';
  if(isset($_GET['id'])) {
    //block sql injection
    $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM topic LEFT JOIN author on topic.author_id=author.id
      WHERE topic.id = {$filtered_id}";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $article['title'] = htmlspecialchars($row['title']);
    $article['description'] = htmlspecialchars($row['description']);
    $article['name'] = "by ".htmlspecialchars($row['name']);
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
