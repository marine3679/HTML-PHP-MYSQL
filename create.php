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

  $sql ="SELECT * FROM author";
  $result = mysqli_query($conn, $sql);
  $select_form = "<SELECT name=\"author_id\">";
  while($row = mysqli_fetch_array($result)) {
    // block bad output data
    $escaped_name = htmlspecialchars($row['name']);
    $select_form .= "<OPTION value=\"{$row['id']}\">{$escaped_name}</OPTION>";
  }
  $select_form .= "</SELECT>";

  $article = array(
    'title' => "welcome",
    'description' => "Welcome to the web"
  );

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
