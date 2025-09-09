<form action="<?= $media ? '/admin/media/save/' . $media['id'] : '/admin/media/save' ?>" method="post">
    <input type="text" name="title" value="<?= $media['title'] ?? '' ?>" placeholder="Titre" required>

    <select name="type" required>
        <option value="book" <?= ($media['media_type'] ?? '') == 'book' ? 'selected' : '' ?>>Livre</option>
        <option value="movie" <?= ($media['media_type'] ?? '') == 'movie' ? 'selected' : '' ?>>Film</option>
        <option value="video_game" <?= ($media['media_type'] ?? '') == 'video_game' ? 'selected' : '' ?>>Jeu vidéo</option>
    </select>

    <input type="text" name="genre" value="<?= $media['genre'] ?? '' ?>" placeholder="Genre" required>
    <input type="number" name="stock" value="<?= $media['stock'] ?? 1 ?>" min="1" required>
    <button type="submit">Enregistrer</button>
</form>
