<?php  
session_start();  
if(!isset($_SESSION['sid'])) 
{  
    header("Location: main.php");  
} 
else 
{  
 // ici, r�cup�rer la liste des commandes dans la table DRAWINGS avec l'identifiant $_GET['id']  
 // l'enregistrer dans la variable $commands  
	$dbh = new PDO('mysql:host=localhost;dbname=pictionnary', 'test', 'test');
	$sql = $dbh->prepare("SELECT commandes FROM drawings WHERE u_id= :uid AND id= :id");
	$sql->bindValue(":uid", $_SESSION['sid']);
	$sql->bindValue(":id", $_GET['id']);
	$sql->execute();
	if($sql->rowCount() < 1) 
	{
		header("Location: main.php");
	} 
	else 
	{
		$commands = $sql->fetch(PDO::FETCH_COLUMN);
	}
}  
  
?>  
<!DOCTYPE html>  
<html>  
<head>  
    <meta charset=utf-8 />  
    <title>Pictionnary</title>  
    <link rel="stylesheet" media="screen" href="css/styles.css" >  
    <script>  
        // la taille et la couleur du pinceau  
        var size, color;  
        // la derni�re position du stylo  
        var x0, y0;  
        // le tableau de commandes de dessin � envoyer au serveur lors de la validation du dessin  
        var drawingCommands = <?php echo $commands;?>;  
  
        window.onload = function() 
		{  
            var canvas = document.getElementById('myCanvas');  
            canvas.width = 400;  
            canvas.height= 400;  
            var context = canvas.getContext('2d');  
  
            var start = function(c) 
			{  
                // compl�tez
				size =  c.size;
				color = c.color;
				y0 = c.y;
				x0 = c.x;
				context.beginPath();
				context.fillStyle = color;
				context.arc(x0, y0, size / 2, 0, 2 * Math.PI);
				context.fill();
				context.closePath();
            }  
  
            var draw = function(c) 
			{  
                // compl�tez  
				y0 = c.y;
				x0 = c.x;
				context.beginPath();
				context.fillStyle = color;
				context.arc(x0, y0, size /2, 0, 2 * Math.PI);
				context.fill();
				context.closePath();
				
            }  
  
            var clear = function() 
			{  
                // compl�tez 
				context.clearRect(0, 0, canvas.width, canvas.height);
            }  
  
            // �tudiez ce bout de code  
            var i = 0;  
            var iterate = function() 
			{  
                if(i>=drawingCommands.length)  
				{
                    return;  
				}
                var c = drawingCommands[i];  
                switch(c.command) 
				{  
                    case "start":  
                        start(c);  
                        break;  
                    case "draw":  
                        draw(c);  
                        break;  
                    case "clear":  
                        clear();  
                        break;  
                    default:  
                        console.error("cette commande n'existe pas "+ c.command);  
                }  
                i++;  
                setTimeout(iterate,30);  
            };  
  
            iterate();  
  
        };  
  
    </script>  
</head>  
<body>  
<canvas id="myCanvas"></canvas>  
</body>  
</html>