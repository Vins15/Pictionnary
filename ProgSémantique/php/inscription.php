<?php
?>
<!DOCTYPE html>  
<html>  
<head>  
    <meta charset='utf-8' >
	<link rel="stylesheet" media="screen" href="../css/styles.css" >
    <title>Pictionnary - Inscription</title>  
</head>  
<body>  
  
<h2>Inscrivez-vous</h2>  

<form class="inscription" action="req_inscription.php" method="post" name="inscription">  

    <span class="required_notification">Les champs obligatoires sont indiqu�s par *</span>  
    <ul>  
	
        <li>  
            <label for="email">E-mail :</label>  
            <input type="email" name="email" id="email" autofocus= "autofocus" required= "required" placeholder="email"/>    
            <span class="form_hint">Format attendu "name@something.com"</span>  
        </li>  
		<li>
			<label for="nom">nom :</label>
			<input type="text" name="nom" id="nom" />
		</li>
        <li>  
            <label for="prenom">Prenom :</label>  
            <input type="text" name="prenom" id="prenom" placeholder="prenom" required= "required" />  
        </li>  

			<li>  
            <label for="mdp1">Mot de passe :</label>  
            <input type="password" name="password" id="mdp1" pattern="[A-Za-z0-9]{6,8}" onkeyup="validateMdp2()" title = "Le mot de passe doit contenir de 6 � 8 caract�res alphanum�riques.">   
            <span class="form_hint">De 6 � 8 caract�res alphanum�riques.</span>  
        </li>  
        <li>  
            <label for="mdp2">Confirmez mot de passe:</label>  
            <input type="password" required= "required" id="mdp2"  onkeyup="validateMdp2()" placeholder  >
            <span class="form_hint">Les mots de passes doivent �tre �gaux.</span>  
            <script>  
                validateMdp2 = function(e) {  
                    var mdp1 = document.getElementById('mdp1');  
                    var mdp2 = document.getElementById('mdp2'); 
                    if ( mdp1.value == mdp2.value) {  
                        // ici on supprime le message d'erreur personnalis�, et du coup mdp2 devient valide.  
                        document.getElementById('mdp2').setCustomValidity('');  
                    } else {  
                        // ici on ajoute un message d'erreur personnalis�, et du coup mdp2 devient invalide.  
                        document.getElementById('mdp2').setCustomValidity('Les mots de passes doivent �tre �gaux.');  
                    }  
					mdp1.onchange = validateMdp2;
					mdp2.onkeyup = validateMdp2;
                }  
            </script>
		</li>
		
		    <li>  
                <label for="birthdate">Date de naissance:</label>  
                <input type="date" name="birthdate" id="birthdate" placeholder="JJ/MM/AAAA" required onchange="computeAge()"/>  
                <script>  
                    computeAge = function(e) {  
                        try{   
                        console.log(document.getElementById("birthdate"));  
                        console.log(new Date(document.getElementById("birthdate").valueAsDate));  
                        console.log(Date.parse(document.getElementById("birthdate").valueAsDate));  
                        console.log(new Date(0).getYear());  
                        console.log(new Date(65572346585).getYear());
						 
						 var dateNow = new Date();
						 var birthdate = new Date(document.getElementById("birthdate").value);
						 document.getElementById("age").value =  dateNow.getFullYear() - birthdate.getFullYear();
                    } catch(e) {  
						 document.getElementById("age").value = "";
                    }  
                }  
                </script>  
                <span class="form_hint">Format attendu "JJ/MM/AAAA"</span>  
            </li>  
            <li>  
                <label for="age">Age:</label>  
                <input type="number" name="age" id="age" disabled/>  
                <!-- � quoi sert l'attribut disabled ? -->  
            </li>
			
			<li>
				<label for="tel">tel:</label>
				<input type="tel" name="tel" id="tel"/>
			</li>
			
			<li>
				<label for="ville">ville:</label>
				<input type="text" name="ville" id="ville"/>
			</li>
			
			<li>
				<label for="website">website:</label>
				<input type="text" name="website" id="website"/>
			</li>
			
			<li>  
            <label for="profilepicfile">Photo de profil:</label>  
            <input type="file" id="profilepicfile" onchange="loadProfilePic(this.readImage)"/>  
            <!-- l'input profilepic va contenir le chemin vers l'image sur l'ordinateur du client -->  
            <!-- on ne veut pas envoyer cette info avec le formulaire, donc il n'y a pas d'attribut name -->  
            <span class="form_hint">Choisissez une image.</span>  
            <input type="hidden" name="profilepic" id="profilepic"/> 
			<canvas id="preview" width="96" height="96" style="border: solid"></canvas>			
            <!-- l'input profilepic va contenir l'image redimensionn�e sous forme d'une data url -->   
            <!-- c'est cet input qui sera envoy� avec le formulaire, sous le nom profilepic -->  
            <canvas id="preview" width="0" height="0"></canvas>  
            <!-- le canvas (nouveaut� html5), c'est ici qu'on affichera une visualisation de l'image. -->  
            <!-- on pourrait afficher l'image dans un �l�ment img, mais le canvas va nous permettre �galement   
            de la redimensionner, et de l'enregistrer sous forme d'une data url-->  
            <script>  
                loadProfilePic = function (e) {
                    // on récupère le canvas où on affichera l'image
                    var canvas = document.getElementById("preview");
                    var ctx = canvas.getContext("2d");
                    // on réinitialise le canvas: on l'efface, et déclare sa largeur et hauteur à 0
                    ctx.fillStyle="#FFF";
                    /* setFillColor*/
                    ctx.fillRect(0,0,canvas.width,canvas.height);
                    canvas.width=0;
                    canvas.height=0;
                    // on récupérer le fichier: le premier (et seul dans ce cas là) de la liste
                    var file = document.getElementById("profilepicfile").files[0];
                    // l'élément img va servir à stocker l'image temporairement
                    var img = document.createElement("img");
                    // l'objet de type FileReader nous permet de lire les données du fichier.
                    var reader = new FileReader();
                    // on prépare la fonction callback qui sera appelée lorsque l'image sera chargée
                    reader.onload = function(e) {
                        //on vérifie qu'on a bien téléchargé une image, grâce au mime type
                        if (!file.type.match(/image.*/)) {
                            // le fichier choisi n'est pas une image: le champs profilepicfile est invalide, et on supprime sa valeur
                            document.getElementById("profilepicfile").setCustomValidity("Il faut télécharger une image.");
                            document.getElementById("profilepicfile").value = "";
                        }
                        else {
                            // le callback sera appelé par la méthode getAsDataURL, donc le paramètre de callback e est une url qui contient
                            // les données de l'image. On modifie donc la source de l'image pour qu'elle soit égale à cette url
                            // on aurait fait différemment si on appelait une autre méthode que getAsDataURL.
                            img.src = e.target.result;
                            // le champs profilepicfile est valide
                            document.getElementById("profilepicfile").setCustomValidity("");
                            var MAX_WIDTH = 96;
                            var MAX_HEIGHT = 96;
                            var width = img.width;
                            var height = img.height;
                            // A FAIRE: si on garde les deux lignes suivantes, on rétrécit l'image mais elle sera déformée
                            // Vous devez supprimer ces lignes, et modifier width et height pour:
                            //    - garder les proportions,
                            //    - et que le maximum de width et height soit égal à 96
                            if (width > height) {
                                if (width > MAX_WIDTH) {
                                    height *= MAX_WIDTH / width;
                                    width = MAX_WIDTH;
                                }
                            }
                            else {
                                if (height > MAX_HEIGHT) {
                                    width *= MAX_HEIGHT / height;
                                    height = MAX_HEIGHT;
                                }
                            }
                            canvas.width = width;
                            canvas.height = height;
                            // on dessine l'image dans le canvas à la position 0,0 (en haut à gauche)
                            // et avec une largeur de width et une hauteur de height
                            ctx.drawImage(img, 0, 0, width, height);
                            // on exporte le contenu du canvas (l'image redimensionnée) sous la forme d'une data url
                            var dataurl = canvas.toDataURL("image/png");
                            // on donne finalement cette dataurl comme valeur au champs profilepic
                            document.getElementById("profilepic").value = dataurl;
                        };
                    }
                    // on charge l'image pour de vrai, lorsque ce sera terminé le callback loadProfilePic sera appelé.
                    reader.readAsDataURL(file);
                }
            </script>  
        </li>
		
		<li>
		<label for="sexe">Sexe:</label> 
			<input type="radio" name="gender" value="male" > Male<br>
			<input type="radio" name="gender" value="female"> Female<br>
		
		</li>
		<li>
		<label for="taille">Taille : <span id="afficheTaille">1</span> m</label>
				<input type="range" name="taille" id="taille" min="0" max="2.5" value="1" step="0.01" oninput="document.getElementById('afficheTaille').textContent=value"
			value="<?php if(!empty($_GET['taille'])) { echo htmlspecialchars($_GET['taille']); } ?>"/>
		</li>
		
		<li>
                    <label for="couleur">Couleur préférée :</label>
                    <input type="color" name="couleur" id="couleur" class="form-control"
                           value="<?php if(!empty($_GET['couleur'])) { echo htmlspecialchars($_GET['couleur']); } ?>"/>
		</li>

		<li>  
            <input type="submit" value="Soumettre Formulaire">  
        </li>		
    </ul>  
</form>  
</body>  
</html>  