<h1>Liste des utilisateurs</h1>
<table border="1">
    <tr>
        <th>ID</th><th>Nom</th><th>Email</th><th>Rôle</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= $user['id'] ?></td>
        <td><?= $user['username'] ?></td>
        <td><?= $user['email'] ?></td>
        <td><?= $user['role'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
