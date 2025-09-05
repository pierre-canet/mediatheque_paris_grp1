<?php
class Media {
    public $type;
    public $data;
    public $image;

    public function __construct($type, $data, $image) {
        $this->type = $type;
        $this->data = $data;   // tableau des champs (auteur, isbn, etc.)
        $this->image = $image; // fichier image
    }

    // Validation et upload de l'image
    public function uploadImage() {
        $errors = [];
        $success = "";

        if (!$this->image || $this->image['error'] === UPLOAD_ERR_NO_FILE) return ["errors"=>$errors, "success"=>$success];

        $file = $this->image;

        if ($file['error'] !== UPLOAD_ERR_OK) $errors[] = "Erreur lors de l'upload de l'image.";

        if ($file['size'] > 2097152) $errors[] = "Le fichier est trop volumineux (max 2 Mo).";

        $allowedExt = ['jpg','jpeg','png','gif'];
        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        $dim = getimagesize($file['tmp_name']);
        if ($dim === false) $errors[] = "Le fichier n'est pas une image valide.";
        else {
            if ($dim[0] < 100 || $dim[1] < 100) $errors[] = "L'image doit avoir au minimum 100x100 pixels.";
            $mime = image_type_to_mime_type($dim[2]);
            if (!in_array($fileExt, $allowedExt) || !in_array($mime, ['image/jpeg','image/png','image/gif'])) {
                $errors[] = "Format non supporté. Formats acceptés : JPG, PNG, GIF.";
            }
        }

        if (empty($errors)) {
            $newName = uniqid("media_", true).".".$fileExt;
            $uploadDir = __DIR__ . "/../uploads/";
            if (!is_dir($uploadDir)) mkdir($uploadDir);
            if (move_uploaded_file($file['tmp_name'], $uploadDir.$newName)) $success = $newName;
            else $errors[] = "Impossible d'enregistrer l'image (espace disque ?).";
        }

        return ["errors"=>$errors, "success"=>$success];
    }
}
