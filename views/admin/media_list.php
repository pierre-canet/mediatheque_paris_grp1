<h1>Liste des médias</h1>
<table border="1">
    <tr>
        <th>ID</th><th>Titre</th><th>Type</th><th>Disponible</th>
    </tr>
    <?php foreach ($medias as $media): ?>
    <tr>
        <td><?= $media['id'] ?></td>
        <td><?= $media['title'] ?></td>
        <td><?= $media['type'] ?></td>
        <td><?= $media['available'] ? 'Oui' : 'Non' ?></td>
    </tr>
    <?php endforeach; ?>
</table>
