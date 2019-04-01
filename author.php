<?php

  try {
    $dbh = new PDO('mysql:host=localhost;dbname=opentutorials', 'root', '');
    //persistent connection
    // $dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass, array(
    //     PDO::ATTR_PERSISTENT => true
    // ));
    $sql = "SELECT * FROM author LIMIT 1000";

    $list = "";
    $sth = $dbh->query($sql);
    foreach($sth as $row) {
      // block bad output data
      $escaped_id = htmlspecialchars($row['id']);
      $escaped_name = htmlspecialchars($row['name']);
      $escaped_profile = htmlspecialchars($row['profile']);
      $list = $list."<tr>
        <td>{$escaped_id}</td>
        <td>{$escaped_name}</td>
        <td>{$escaped_profile}</td>
        <td><a href=author.php?id={$escaped_id}>update</a></td>
        <td>
          <form action=\"process_delete_author.php\" method=\"POST\" onsubmit=\"\">
            <input type=\"hidden\" name=\"id\"value=\"{$escaped_id}\">
            <input type=\"submit\" value=\"delete\">
          </form>
        </td>
      </tr>";
    }
    $sth = null;
  } catch (PDOException $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
  }

  $form_action = "process_create_author.php";
  $escaped_name_update = '';
  $escaped_profile_update = '';
  $create_value_submit = "create author";
  $form_id = "";
  if(isset($_GET['id'])) {
    $filtered_id = $_GET['id'];
    $sql = "SELECT * FROM author WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $filtered_id);
    if ($stmt->execute()) {
      while ($row = $stmt->fetch()) {
        $escaped_id_update = htmlspecialchars($row['id']);
        $escaped_name_update = htmlspecialchars($row['name']);
        $escaped_profile_update = htmlspecialchars($row['profile']);
        $create_value_submit = "update author";
        $form_action = "process_update_author.php";
        $form_id = '<input type="hidden" name="id" value="'.$escaped_id_update.'">';
      }
    }
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
    <p><a href="index.php">topic！</a></p>
    <table border="1">
      <tr>
        <td>id</td><td>name</td><td>profile</td><td>update</td><td>delete</td>
      </tr>
      <?=$list?>
    </table>
    <form action="<?=$form_action?>" method="POST">
      <?=$form_id?>
      <p><input type="text" name="name" placeholder="name" value="<?=$escaped_name_update?>"></p>
      <p><textarea name="profile" placeholder="profile"><?=$escaped_profile_update?></textarea></p>
      <p><input type="submit" value="<?=$create_value_submit?>"></p>
    </form>
  </body>
</html>
