<?php
$erreurs = [];   // Tableau qui va contenir les messages d'erreurs
$message = "";   // Message de succès si tout est bon

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $type = $_POST["type"];  // Récupère le type choisi (livre, film ou jeu)

    // ----------- VALIDATION SELON LE TYPE CHOISI -----------
    switch ($type) {
        case "livre":
            // Auteur obligatoire entre 2 et 100 caractères
            if (strlen($_POST["auteur"]) < 2 || strlen($_POST["auteur"]) > 100)
                $erreurs[] = "Auteur : 2-100 caractères.";
            
            // ISBN doit contenir 10 ou 13 chiffres
            if (!preg_match("/^\d{10}(\d{3})?$/", $_POST["isbn"]))
                $erreurs[] = "ISBN doit avoir 10 ou 13 chiffres.";
            
            // Pages entre 1 et 9999
            if ($_POST["pages"] < 1 || $_POST["pages"] > 9999)
                $erreurs[] = "Pages : 1-9999.";
            
            // Année entre 1900 et année actuelle
            if ($_POST["annee"] < 1900 || $_POST["annee"] > date("Y"))
                $erreurs[] = "Année invalide.";
            break;

        case "film":
            // Réalisateur obligatoire entre 2 et 100 caractères
            if (strlen($_POST["realisateur"]) < 2 || strlen($_POST["realisateur"]) > 100)
                $erreurs[] = "Réalisateur : 2-100 caractères.";
            
            // Durée entre 1 et 999 minutes
            if ($_POST["duree"] < 1 || $_POST["duree"] > 999)
                $erreurs[] = "Durée : 1-999 minutes.";
            
            // Année entre 1900 et année actuelle
            if ($_POST["annee"] < 1900 || $_POST["annee"] > date("Y"))
                $erreurs[] = "Année invalide.";
            
            // Classification obligatoire
            if (!in_array($_POST["classification"], ["Tous publics", "-12", "-16", "-18"]))
                $erreurs[] = "Classification obligatoire.";
            break;

        case "jeu":
            // Éditeur obligatoire entre 2 et 100 caractères
            if (strlen($_POST["editeur"]) < 2 || strlen($_POST["editeur"]) > 100)
                $erreurs[] = "Éditeur : 2-100 caractères.";
            
            // Plateforme obligatoire parmi les choix
            if (!in_array($_POST["plateforme"], ["PC", "PlayStation", "Xbox", "Nintendo", "Mobile"]))
                $erreurs[] = "Plateforme invalide.";
            
            // Âge minimum obligatoire parmi les choix
            if (!in_array($_POST["age"], ["3", "7", "12", "16", "18"]))
                $erreurs[] = "Âge minimum invalide.";
            break;
    }

    // Si aucune erreur → message de succès
    if (empty($erreurs)) {
        $message = "  Données valides et prêtes à être enregistrées.";
    }
}
?>

<!-- ===== FORMULAIRE ===== -->
<form method="POST">
    <!-- Liste déroulante pour choisir le type de média -->
    <label>Type :</label>
    <select name="type" onchange="this.form.submit()">
        <option value="">-- Choisir --</option>
        <option value="livre" <?= (@$_POST["type"]=="livre"?"selected":"") ?>>Livre</option>
        <option value="film" <?= (@$_POST["type"]=="film"?"selected":"") ?>>Film</option>
        <option value="jeu" <?= (@$_POST["type"]=="jeu"?"selected":"") ?>>Jeu vidéo</option>
    </select>
    <br><br>

    <!-- Champs spécifiques affichés selon le type choisi -->
    <?php if(@$_POST["type"]=="livre"): ?>
        Auteur : <input name="auteur"><br>
        ISBN : <input name="isbn"><br>
        Pages : <input type="number" name="pages"><br>
        Année : <input type="number" name="annee"><br>
    <?php elseif(@$_POST["type"]=="film"): ?>
        Réalisateur : <input name="realisateur"><br>
        Durée : <input type="number" name="duree"><br>
        Année : <input type="number" name="annee"><br>
        Classification :
        <select name="classification">
            <option value="">-- Choisir --</option>
            <option>Tous publics</option><option>-12</option><option>-16</option><option>-18</option>
        </select><br>
    <?php elseif(@$_POST["type"]=="jeu"): ?>
        Éditeur : <input name="editeur"><br>
        Plateforme :
        <select name="plateforme">
            <option>PC</option><option>PlayStation</option><option>Xbox</option><option>Nintendo</option><option>Mobile</option>
        </select><br>
        Âge minimum :
        <select name="age">
            <option>3</option><option>7</option><option>12</option><option>16</option><option>18</option>
        </select><br>
    <?php endif; ?>

    <!-- Bouton valider affiché seulement si un type est choisi -->
    <?php if(!empty($_POST["type"])): ?>
        <br><button type="submit">Valider</button>
    <?php endif; ?>
</form>

<!-- ===== AFFICHAGE DES ERREURS OU MESSAGE ===== -->
<?php
// Si erreurs → afficher en rouge
if ($erreurs) {
    echo "<ul style='color:red;'>";
    foreach ($erreurs as $err) echo "<li>$err</li>";
    echo "</ul>";
}
// Si tout est bon → afficher en vert
if ($message) echo "<p style='color:green;'>$message</p>";
?>
