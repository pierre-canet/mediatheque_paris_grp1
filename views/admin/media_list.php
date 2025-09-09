<h1>Liste des médias</h1>

<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Type</th>
            <th>Genre</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($medias as $media): ?>
        <tr>
            <td><?= htmlspecialchars($media['title']) ?></td>
            <td>
                <?php 
                    switch($media['media_type']) {
                        case 'book': echo 'Livre'; break;
                        case 'movie': echo 'Film'; break;
                        case 'video_game': echo 'Jeu vidéo'; break;
                        default: echo htmlspecialchars($media['media_type']);
                    }
                ?>
            </td>
            <td><?= htmlspecialchars($media['genre'] ?? '') ?></td>
            <td><?= ($media['stock'] ?? 0) > 0 ? $media['stock'] : 'Indisponible' ?></td>
            <td>
                <a href="/admin/media/edit/<?= $media['id'] ?>">Modifier</a> |
                <a href="/admin/media/delete/<?= $media['id'] ?>" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
