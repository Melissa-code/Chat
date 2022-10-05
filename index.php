<?php

// Connexion à la DB 
$bdd = new PDO("mysql:host=localhost;dbname=chat;charset=utf8", "root", "root");

// Traitement du formulaire 
if(isset($_POST['pseudo']) AND isset($_POST['message']) AND !empty($_POST['pseudo']) AND !empty($_POST['message']))
{
    $pseudo = htmlspecialchars($_POST['pseudo']); // mettre variable pour praticité 
    $message = htmlspecialchars($_POST['message']); // htmlspecialchars() pour securiser inputs

    // on prepare la requete 
    $insertmsg = $bdd->prepare('INSERT INTO messagerie(pseudo, message) VALUES(?,?)');

    // on insert les données 
    $insertmsg->execute(array($pseudo, $message));

}


?>

<html>
    <head>
        <title>Créer un chat en PHP</title>
        <meta charset="utf-8">
    </head>

    <body>

        <!-- Formulaire pour poster les messages -->
        <form method="post" action="">
            <!-- Pour garder en memoire le pseudo --> 
            <input type="text" name="pseudo" placeholder="pseudo" value="<?php if(isset($pseudo)){ echo $pseudo; } ?>"><br/>
            <textarea type="text" name="message" placeholder="message"></textarea><br/>
            <input type="submit" value="Envoyer">
        </form>

        <!-- Endroit où afficher les messages du chat --> 
        <?php 

        // req sur bdd 
        $allmsg = $bdd->query('SELECT * FROM messagerie ORDER BY id DESC');

        while($msg = $allmsg->fetch())
        {
        ?>
    
        <b><?=$msg['pseudo']." : "; ?> </b><?=($msg['message']); ?> <br/>
        

        <?php
        }

        ?>

        
    </body>
</html>