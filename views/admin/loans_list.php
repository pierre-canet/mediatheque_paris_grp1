<h1>Liste des emprunts</h1>

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
            <th>Utilisateur</th>
            <th>Média</th>
            <th>Type</th> <!-- nouveau -->
            <th>Date emprunt</th>
            <th>Date retour prévue</th>
            <th>Rendu le</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($loans as $loan): ?>
            <tr>
                <td><?= $loan['id'] ?></td>
                <td><?= htmlspecialchars($loan['user_name']) ?></td>
                <td><?= htmlspecialchars($loan['media_title']) ?></td>
                <td><?= htmlspecialchars($loan['media_type']) ?></td> <!-- nouveau -->
                <td><?= $loan['loan_date'] ?></td>
                <td><?= $loan['return_date'] ?></td>
                <td><?= $loan['returned_at'] ?: 'En cours' ?></td>
                <td>
                    <?php if (!$loan['returned_at']): ?>
                        <a href="/admin/loans/return/<?= $loan['id'] ?>" 
                           onclick="return confirm('Confirmer le retour de ce média ?')">
                           Marquer comme rendu
                        </a>
                    <?php else: ?>
                        ✔️
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
