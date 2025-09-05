<?php
require_once __DIR__ . '/../models/Media.php';

class MediaController {
    public function showForm() {
        $type = $_POST['type'] ?? '';
        $errors = [];
        $success = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $type) {
            $data = $_POST;
            $image = $_FILES['image'] ?? null;

            $media = new Media($type, $data, $image);
            $result = $media->uploadImage();
            $errors = $result['errors'];
            $success = $result['success'];
        }

        // Inclure la vue
        require __DIR__ . '/../views/mediaForm.php';
    }
}
