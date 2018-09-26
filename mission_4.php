<!DOCTYPE html>
<html>
 <html lang="ja">
 <head>
  <meta charset="utf-8">
  <title>mission4</title>
 </head>
 <body>
  <h1>簡易掲示板</h1>
  <h2>投稿</h2>
  <?php echo "ここから投稿ができます。"."<br>"."パスワードは編集、削除に使います。忘れないようにしてください。"."<br>"; ?>
  <form method="POST" action="mission_4.php"><!-投稿フォーム->
   <input type="text" name="name" placeholder="名前"></br>
   <input type="text" name="comment" placeholder="コメント"></br>
   <input type="text" name="pass" placeholder="パスワード">
   <input type="submit" value="送信"></br>
  </form>
  <h2>削除</h2>
  <?php echo "ここから削除ができます。"."<br>"."削除したい投稿の投稿番号とパスワードを入力してください。"."<br>"; ?>
  <form method="POST" action="mission_4.php"><!-削除フォーム->
   <input type="text" name="del_no" placeholder="削除対象番号"></br>
   <input type="text" name="del_pass" placeholder="パスワード">
   <input type="submit" value="削除"></br>
  </form>
  <h2>編集</h2>
  <?php echo "ここから編集ができます。"."<br>"."編集したい投稿の投稿番号とパスワード、そして編集内容を入力して下さい。"."<br>"; ?>
  <form method="POST" action="mission_4.php"><!-編集フォーム->
   <input type="text" name="edit_no" placeholder="編集対象番号"></br>
   <input type="text" name="edit_pass" placeholder="パスワード"></br>
   <input type="text" name="edit_name" placeholder="名前"></br>
   <input type="text" name="edit_comment" placeholder="コメント">
   <input type="submit" value="編集"></br>
  </form>
<?php
 $name = $_POST['name'];
 $comment = $_POST['comment'];
 $pass = $_POST['pass'];
 try{
 	//MySQL起動
	 $dsn = 'データベース名';
	 $user = 'ユーザー名';
	 $password = 'パスワード';
	 $pdo = new PDO($dsn,$user,$password);
	 echo "<hr>";
 }catch(Exception $ex){
		echo "Exceptionをキャッチ:{$ex->getMessage()}"."<br>";
		echo "<hr>";
 }catch(Error $er){
		echo "Errorをキャッチ:{$er->getMessage()}"."<br>";
		echo "<hr>";
 }
 //投稿
 if(!empty($name) and !empty($comment) and !empty($pass)){
 	try{
		 //データ入力
		 $sql = $pdo -> prepare("INSERT INTO testtable(name,comment,date,pass) VALUES(:name,:comment,now(),:pass)");
		 $sql -> bindParam(':name',$name,PDO::PARAM_STR);
		 $sql -> bindParam(':comment',$comment,PDO::PARAM_STR);
		 $sql -> bindParam(':pass',$pass,PDO::PARAM_STR);
		 $sql -> execute();
 	}catch(Exception $ex){
		echo "Exceptionをキャッチ:{$ex->getMessage()}"."<br>";
		echo "<hr>";
	}catch(Error $er){
		echo "Errorをキャッチ:{$er->getMessage()}"."<br>";
		echo "<hr>";
	}
 }
 //削除
 $del_no = $_POST['del_no'];
 $del_pass = $_POST['del_pass'];
 if(!empty($del_no) and !empty($del_pass)){
 	//データ削除
 	try{
		$sql = $pdo -> prepare("delete from testtable where id = :id and pass = :pass");
 		$sql -> bindParam(':id',$del_no,PDO::PARAM_INT);
 		$sql -> bindParam(':pass',$del_pass,PDO::PARAM_STR);
 		$sql -> execute();
	}catch(Exception $ex){
		echo "Exceptionをキャッチ:{$ex->getMessage()}"."<br>";
		echo "<hr>";
	}catch(Error $er){
		echo "Errorをキャッチ:{$er->getMessage()}"."<br>";
		echo "<hr>";
	}
 }
 //編集
 $edit_no = $_POST["edit_no"];
 $edit_pass = $_POST["edit_pass"];
 $edit_name = $_POST["edit_name"];
 $edit_comment = $_POST["edit_comment"];
 if(!empty($edit_no) and !empty($edit_pass) and !empty($edit_name) and !empty($edit_comment)){
	try{
	 	$sql = $pdo -> prepare("update testtable set name = :name ,comment = :comment ,date = now() where id = :id and pass = :pass");
	 	$sql -> bindParam(':id',$edit_no,PDO::PARAM_INT);
	 	$sql -> bindParam(':pass',$edit_pass,PDO::PARAM_STR);
	 	$sql -> bindParam(':name',$edit_name,PDO::PARAM_STR);
	 	$sql -> bindParam(':comment',$edit_comment,PDO::PARAM_STR);
	 	$sql -> execute();
	}catch(Exception $ex){
		echo "Exceptionをキャッチ:{$ex->getMessage()}"."<br>";
		echo "<hr>";
	}catch(Error $er){
		echo "Errorをキャッチ:{$er->getMessage()}"."<br>";
		echo "<hr>";
	}
 }
 //データ表示
 echo "【削除・編集しても変化がない場合はパスワードが間違っている可能性があります。】"."<br>";
 try{
	 $sql = "SELECT*FROM testtable ORDER BY id";
	 $results = $pdo -> query($sql);
	 foreach($results as $row){
		 $text = $row['id']." ".$row['name']." ".$row['comment']." ".$row['date']." ".$row['pass'];
	 	 $security_text = htmlspecialchars($text,ENT_QUOTES,'UTF-8');
	 	 echo $security_text."<br>";
	 }
 }catch(Exception $ex){
		echo "Exceptionをキャッチ:{$ex->getMessage()}"."<br>";
		echo "<hr>";
 }catch(Error $er){
		echo "Errorをキャッチ:{$er->getMessage()}"."<br>";
		echo "<hr>";
 }
?>
</body>
</html>