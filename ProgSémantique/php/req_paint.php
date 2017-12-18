<?php
session_start();
if(!isset($_SESSION['email'])) 
{
    header("Location: main.php");
}
$drawingCommands=stripslashes($_POST['drawingCommands']);
$picture=stripslashes($_POST['picture']);
$userId = $_SESSION['id'];
try 
{
    $dbh = new PDO('mysql:host=localhost;dbname=pictionnary', 'test', 'test');
    $sql = $dbh->prepare("INSERT INTO drawings(command, dessin, idUser) VALUES (:command, :dessin, :idUser	);");
	$sql->bindValue(':command', $drawingCommands);
	$sql->bindValue(':dessin', $picture);
	$sql->bindValue(':idUser', $userId);
	if (!$sql->execute()) 
	{
		echo "PDO::errorInfo():<br/>";
		$err = $sql->errorInfo();
		print_r($err);
	} 
	else 
	{
		header('Location: main.php');
	}
	$dbh = null;
} 
catch (PDOException $e) 
{
    print "Erreur !: " . $e->getMessage() . "<br/>";
    $dbh = null;
    die();
}
?>