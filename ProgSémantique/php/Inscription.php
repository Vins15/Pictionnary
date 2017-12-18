<?php
require "header.php";
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
            <input type="email" name="email" id="email" autofocus= "autofocus" required= "required" />    
            <span class="form_hint">Format attendu "name@something.com"</span>  
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
            <label for="mdp2">Confirmez mot de passe :</label>  
            <input type="password" required= "required" id="mdp2"  onkeyup="validateMdp2()" placeholder  >
            <span class="form_hint">Les mots de passes doivent �tre �gaux.</span>  
            <script>  
                validateMdp2 = function(e) {  
                    var mdp1 = document.getElementById('mdp1');  
                    var mdp2 = document.getElementById('mdp2');  
                    if (mdp1.value.match("[a-zA-Z0-9]{6,8}") !== null && mdp1.value == mdp2.value) {  
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
						 document.getElementById("age").value =  dateNow.getFullYear() - birthdate.getFullYear()
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
            <label for="profilepicfile">Photo de profil:</label>  
            <input type="file" id="profilepicfile" onchange="loadProfilePic(this.readImage)"/>  
            <!-- l'input profilepic va contenir le chemin vers l'image sur l'ordinateur du client -->  
            <!-- on ne veut pas envoyer cette info avec le formulaire, donc il n'y a pas d'attribut name -->  
            <span class="form_hint">Choisissez une image.</span>  
            <input type="hidden" name="profilepic" id="profilepic"/>  
            <!-- l'input profilepic va contenir l'image redimensionn�e sous forme d'une data url -->   
            <!-- c'est cet input qui sera envoy� avec le formulaire, sous le nom profilepic -->  
            <canvas id="preview" width="0" height="0"></canvas>  
            <!-- le canvas (nouveaut� html5), c'est ici qu'on affichera une visualisation de l'image. -->  
            <!-- on pourrait afficher l'image dans un �l�ment img, mais le canvas va nous permettre �galement   
            de la redimensionner, et de l'enregistrer sous forme d'une data url-->  
            <script>  
                loadProfilePic = function (e) {  
                    // on r�cup�re le canvas o� on affichera l'image  
                    var canvas = document.getElementById("preview");  
                    var ctx = canvas.getContext("2d");
					var MAX_WIDTH = 96;
					var MAX_HEIGHT = 96;
                    

					function readImage(img) {
						if (img.files && img.files[0]) {
							var width = img.width;
							var height = img.width;

							var fr= new FileReader();
							fr.onload = (e) => {
								var img = new Image();
								img.addEventListener("load", () => {

								    	var h = 0;
									var w = 0;

									if(img.width>img.height){
										w = MAX_WIDTH;
										h = MAX_HEIGHT / img.width * img.height;
									} else {
										w = MAX_WIDTH / img.height * img.width;
										h = MAX_HEIGHT;
									}
									preview.width = w;
									preview.height = h;
									context.drawImage(img, 0, 0, w, h);
									setTimeout(function(){ctx.drawImage(img, 0, 0,  canvas.width, canvas.height); }, 3000);
								});
								img.src = e.target.result;
							};
							fr.readAsDataURL(img.files[0]);
						}
					}

                    // on r�initialise le canvas: on l'efface, et d�clare sa largeur et hauteur � 0  
                    ctx.fillRect(0,0,canvas.width,canvas.height);  
                    canvas.width=0;  
                    canvas.height=0;  
                    // on r�cup�rer le fichier: le premier (et seul dans ce cas l�) de la liste  
                    var file = document.getElementById("profilepicfile").files[0];  
                    // l'�l�ment img va servir � stocker l'image temporairement  
                    var img = document.createElement("img");  
                    // l'objet de type FileReader nous permet de lire les donn�es du fichier.  
                    var reader = new FileReader();  
                    // on pr�pare la fonction callback qui sera appel�e lorsque l'image sera charg�e  
                    reader.onload = function(e) {  
                        //on v�rifie qu'on a bien t�l�charg� une image, gr�ce au mime type  
                        if (!file.type.match(/image.*/)) {  
                            // le fichier choisi n'est pas une image: le champs profilepicfile est invalide, et on supprime sa valeur  
                            document.getElementById("profilepicfile").setCustomValidity("Il faut t�l�charger une image.");  
                            document.getElementById("profilepicfile").value = "";  
                        }  
                        else {  
                            // le callback sera appel� par la m�thode getAsDataURL, donc le param�tre de callback e est une url qui contient   
                            // les donn�es de l'image. On modifie donc la source de l'image pour qu'elle soit �gale � cette url  
                            // on aurait fait diff�remment si on appelait une autre m�thode que getAsDataURL.  
                            img.src = e.target.result;  
                            // le champs profilepicfile est valide  
                            document.getElementById("profilepicfile").setCustomValidity("");  
                            var MAX_WIDTH = 96;  
                            var MAX_HEIGHT = 96;  
                            var width = img.width;  
                            var height = img.height;  
  
                            // A FAIRE: si on garde les deux lignes suivantes, on r�tr�cit l'image mais elle sera d�form�e  
                            // Vous devez supprimer ces lignes, et modifier width et height pour:  
                            //    - garder les proportions,   
                            //    - et que le maximum de width et height soit �gal � 96  
                              
                            canvas.width = width;  
                            canvas.height = height;  
                            // on dessine l'image dans le canvas � la position 0,0 (en haut � gauche)  
                            // et avec une largeur de width et une hauteur de height  
                            ctx.drawImage(img, 0, 0, width, height);  
                            // on exporte le contenu du canvas (l'image redimensionn�e) sous la forme d'une data url  
                            var dataurl = canvas.toDataURL("image/png");  
                            // on donne finalement cette dataurl comme valeur au champs profilepic  
                            document.getElementById("profilepic").value = dataurl;  
                        };  
                    }  
                    // on charge l'image pour de vrai, lorsque ce sera termin� le callback loadProfilePic sera appel�.  
                    reader.readAsDataURL(file);  
                }  
            </script>  
        </li>

		<li>  
            <input type="submit" value="Soumettre Formulaire">  
        </li>		
    </ul>  
</form>  
</body>  
</html>  