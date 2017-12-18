
<?php

$email=stripslashes($_POST['email']);
$password=stripslashes($_POST['password']);
$nom=stripslashes($_POST['nom']);
$prenom=stripslashes($_POST['prenom']);
$tel=stripslashes($_POST['tel']);
$website=stripslashes($_POST['website']);
$sexe='';
if (array_key_exists('sexe',$_POST)) {
    $sexe=stripslashes($_POST['sexe']);
}
$birthdate=stripslashes($_POST['birthdate']);
$ville=stripslashes($_POST['ville']);
$taille=stripslashes($_POST['taille']);
$couleur=stripslashes($_POST['couleur']);
$profilepic=stripslashes($_POST['profilepic']);

try {
    // Connect to server and select database.
    $dbh = new PDO('mysql:host=localhost;dbname=pictionnary', 'test', 'test');

    // Vérifier si un utilisateur avec cette adresse email existe dans la table.
    $sql = $dbh->query("SELECT * FROM `users` WHERE `email` = '".$email."'");
    // En SQL: sélectionner tous les tuples de la table USERS tels que l'email est égal à $email.
    $sql = $dbh->query("la requète SQL ici");
    if ($sql->fetchColumn() >= 1) {
        header("Location: ../inscription.php?erreur&email=".$email."&nom=".$nom."&prenom=".$prenom."&tel=".$tel."&date=".$birthdate."&age=".$age."");

    }
    else {
        // Tenter d'inscrire l'utilisateur dans la base
        $sql = $dbh->prepare("INSERT INTO users (email, password, nom, prenom, tel, website, sexe, birthdate, ville, taille, couleur, profilepic) "
            . "VALUES (:email, :password, :nom, :prenom, :tel, :website, :sexe, :birthdate, :ville, :taille, :couleur, :profilepic)");
        $sql->bindValue(":email", $email);
        $sql->bindValue("password", $password);
        $sql->bindValue("nom", $nom);
        $sql->bindValue("prenom", $prenom);
        $sql->bindValue("tel", $tel);
        $sql->bindValue("website", $website);
        if (array_key_exists('sexe',$_POST)) {
            $sexe = ucfirst(stripslashes($_POST['sexe']));
        }

        $sql->bindValue("birthdate", $birthdate);
        $sql->bindValue("ville", $ville);
        $sql->bindValue("taille", $taille);
        $sql->bindValue("couleur", $couleur);
        $sql->bindValue("profil", $profil);

        // on tente d'exécuter la requête SQL, si la méthode renvoie faux alors une erreur a été rencontrée.
        if (!$sql->execute()) {
            echo "PDO::errorInfo():<br/>";
            $err = $sql->errorInfo();
            print_r($err);
        } else {

            // ici démarrer une session
            session_start();
            // ensuite on requête à nouveau la base pour l'utilisateur qui vient d'être inscrit, et 
            $sql = $dbh->query("SELECT u.id, u.email, u.nom, u.prenom, u.couleur, u.profilepic FROM USERS u WHERE u.email='".$email."'");
            if ($sql->fetchCount()<1) {
                header("Location: main.php?erreur=".urlencode("un problème est survenu"));
            }
            else {
                $sql = $dbh->query($requete);
                // on récupère la ligne qui nous intéresse avec $sql->fetch(),
                while ($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                $_SESSION["id"] = $data["id"];
                $_SESSION["email"] = $data["email"];
                $_SESSION["password"] = $password;
                $_SESSION["nom"] = $data["nom"];
                $_SESSION["prenom"] = $data["prenom"];
                $_SESSION["tel"] = $data["tel"];
                $_SESSION["birthdate"] = $data["birthdate"];
                $_SESSION["couleur"] = "#".$data["couleur"];
                $_SESSION["profilepic"] = $data["profilepic"];
            }

                // et on enregistre les données dans la session avec $_SESSION["..."]=...
            }


            // ici,  rediriger vers la page main.php
            header("Location: ../main.php");
        }
        $dbh = null;
    }
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage () . "<br/>";
    $dbh = null;
    die();
}
?>

