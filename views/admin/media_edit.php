<form action="<?= $media ? '/admin/media/save/' . $media['id'] : '/admin/media/save' ?>" method="post">
    <input type="text" name="title" value="<?= $media['title'] ?? '' ?>" placeholder="Titre" required>
    <select name="type" required>
        <option value="livre" <?= ($media['type'] ?? '') == 'livre' ? 'selected' : '' ?>>Livre</option>
        <option value="film" <?= ($media['type'] ?? '') == 'film' ? 'selected' : '' ?>>Film</option>
        <option value="jeu" <?= ($media['type'] ?? '') == 'jeu' ? 'selected' : '' ?>>Jeu vidéo</option>
    </select>
    <input type="text" name="genre" value="<?= $media['genre'] ?? '' ?>" placeholder="Genre" required>
    <input type="number" name="stock" value="<?= $media['stock'] ?? 1 ?>" min="1" required>
    <button type="submit">Enregistrer</button>
</form>
