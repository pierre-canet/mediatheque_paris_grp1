<h1>Détails utilisateur</h1>
<?php if ($user): ?>
    <p>ID : <?= $user['id'] ?></p>
    <p>Nom : <?= $user['username'] ?></p>
    <p>Email : <?= $user['email'] ?></p>
    <p>Rôle : <?= $user['role'] ?></p>
<?php else: ?>
    <p>Utilisateur introuvable</p>
<?php endif; ?>
