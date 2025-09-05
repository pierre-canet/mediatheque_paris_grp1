<?php
$type = $_POST['type'] ?? ''; 
$errors = [];   // tableau pour stocker les erreurs
$success = "";  // message si tout fonctionne

if ($_SERVER["REQUEST_METHOD"] === "POST" && $type) {
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {

        $file = $_FILES['image'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "Erreur lors de l'upload de l'image.";
        } else {
            // Taille max : 2 Mo
            if ($file['size'] > 2097152) { 
                $errors[] = "Le fichier est trop volumineux (max 2 Mo).";
            }

            // Vérifier extension
            $allowedExt = ['jpg','jpeg','png','gif'];
            $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            // Récupérer infos de l’image
            $dim = getimagesize($file['tmp_name']); 
            if ($dim === false) {
                $errors[] = "Le fichier n'est pas une image valide.";
            } else {
                // Vérifier dimensions minimales
                if ($dim[0] < 100 || $dim[1] < 100) {
                    $errors[] = "L'image doit avoir au minimum 100x100 pixels.";
                }

                // Vérifier le type MIME via image_type_to_mime_type()
                $mime = image_type_to_mime_type($dim[2]);
                if (!in_array($fileExt, $allowedExt) || !in_array($mime, ['image/jpeg','image/png','image/gif'])) {
                    $errors[] = "Format non supporté. Formats acceptés : JPG, PNG, GIF.";
                }
            }

            // Si aucune erreur -> on sauvegarde
            if (empty($errors)) {
                $newName = uniqid("media_", true).".".$fileExt;
                $uploadDir = __DIR__ . "/uploads/";

                if (!is_dir($uploadDir)) mkdir($uploadDir);

                if (move_uploaded_file($file['tmp_name'], $uploadDir.$newName)) {
                    $success = "Image uploadée avec succès : ".$newName;
                } else {
                    $errors[] = "Impossible d'enregistrer l'image (espace disque ?).";
                }
            }
        }
    }
}
?>

<!-- Formulaire -->
<form method="POST" enctype="multipart/form-data">
  <label>Type de média :</label>
  <select name="type" onchange="this.form.submit()">
    <option value="">-- Choisir --</option>
    <option value="livre" <?= ($type==='livre'?'selected':'') ?>>Livre</option>
    <option value="film"  <?= ($type==='film'?'selected':'')  ?>>Film</option>
    <option value="jeu"   <?= ($type==='jeu'?'selected':'')   ?>>Jeu vidéo</option>
  </select>
  <br><br>

  <?php if ($type==='livre'): ?>
    Auteur : <input name="auteur" value="<?= htmlspecialchars($_POST['auteur']??'') ?>"><br>
    ISBN : <input name="isbn" value="<?= htmlspecialchars($_POST['isbn']??'') ?>"><br>
    Pages : <input type="number" name="pages" value="<?= htmlspecialchars($_POST['pages']??'') ?>"><br>
    Année : <input type="number" name="annee" value="<?= htmlspecialchars($_POST['annee']??'') ?>"><br>
  <?php elseif ($type==='film'): ?>
    Réalisateur : <input name="realisateur" value="<?= htmlspecialchars($_POST['realisateur']??'') ?>"><br>
    Durée (min) : <input type="number" name="duree" value="<?= htmlspecialchars($_POST['duree']??'') ?>"><br>
    Année : <input type="number" name="annee" value="<?= htmlspecialchars($_POST['annee']??'') ?>"><br>
    Classification :
    <select name="classification">
      <?php
        $classes = ["","Tous publics","-12","-16","-18"];
        $sel = $_POST['classification'] ?? '';
        foreach ($classes as $c) {
          $lab = $c ?: '-- Choisir --';
          echo "<option value=\"".htmlspecialchars($c)."\" ".($sel===$c?'selected':'').">$lab</option>";
        }
      ?>
    </select><br>
  <?php elseif ($type==='jeu'): ?>
    Éditeur : <input name="editeur" value="<?= htmlspecialchars($_POST['editeur']??'') ?>"><br>
    Plateforme :
    <select name="plateforme">
      <?php
        $plats = ["PC","PlayStation","Xbox","Nintendo","Mobile"];
        $sel = $_POST['plateforme'] ?? '';
        foreach ($plats as $p) {
          echo "<option ".($sel===$p?'selected':'').">$p</option>";
        }
      ?>
    </select><br>
    Âge minimum :
    <select name="age">
      <?php
        $ages = ["3","7","12","16","18"];
        $sel = $_POST['age'] ?? '';
        foreach ($ages as $a) {
          echo "<option ".($sel===$a?'selected':'').">$a</option>";
        }
      ?>
    </select><br>
  <?php endif; ?>

  <?php if ($type): ?>
    <br>Image : <input type="file" name="image"><br><br>
    <button type="submit">Valider</button>
  <?php endif; ?>
</form>

<?php
// Affichage des erreurs
if (!empty($errors)) {
    echo "<ul style='color:red;'>";
    foreach ($errors as $e) echo "<li>$e</li>";
    echo "</ul>";
}
// Affichage du succès
if ($success) {
    echo "<p style='color:green;'>$success</p>";
}
?>
 

