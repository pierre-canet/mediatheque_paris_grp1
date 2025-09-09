<h1><?= $title ?></h1>
<?php if (empty($rentals)): ?>
    <p>Vous n'avez aucune location.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Type</th>
                <th>Date de Location</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rentals as $rental): ?>
            <tr>
                <td><?= htmlspecialchars($rental['title']) ?></td>
                <td><?= $rental['type'] ?></td>
                <td><?= $rental['rent_date'] ?></td>
                <td>
                    <form action="/rental/return/<?= $rental['id'] ?>" method="post">
                        <button type="submit" class="btn">Retourner</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>