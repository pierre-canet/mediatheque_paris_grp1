<h1>Éditer un média</h1>

<?php if ($media): ?>
    <p>ID : <?= $media['id'] ?></p>
    <p>Titre : <?= $media['title'] ?></p>
<?php else: ?>
    <p>Nouveau média</p>
<?php endif; ?>
