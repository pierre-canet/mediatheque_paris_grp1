<h1>Liste des utilisateurs</h1>

<?php if (isset($_SESSION['flash'])): ?>
    <div class="flash <?= $_SESSION['flash']['type'] ?>">
        <?= $_SESSION['flash']['message'] ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Inscription</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['last_name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role'] ?? 'user') ?></td>
                <td><?= $user['created_at'] ?></td>
                <td>
                    <a href="/admin/user/<?= $user['id'] ?>">Voir</a>
                    <!-- Plus tard: bouton éditer ou supprimer -->
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
