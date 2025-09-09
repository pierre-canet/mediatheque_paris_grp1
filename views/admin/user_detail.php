<h1>Détails utilisateur</h1>

<?php if ($user): ?>
    <p>ID : <?= $user['id'] ?></p>
    <p>Nom : <?= htmlspecialchars($user['name']) ?> <?= htmlspecialchars($user['last_name']) ?></p>
    <p>Email : <?= htmlspecialchars($user['email']) ?></p>
    <p>Rôle : <?= htmlspecialchars($user['role'] ?? 'user') ?></p>
<?php else: ?>
    <p>Utilisateur introuvable</p>
<?php endif; ?>
