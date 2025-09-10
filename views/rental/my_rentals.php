<?php
// Affichage de la page des emprunts de l'utilisateur
// Utilisation de la fonction url() pour les liens
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title ?? 'Mes Emprunts'); ?></title>
    <link rel="stylesheet" href="<?php echo url('assets/css/style.css'); ?>">
</head>
<body>
    <section class="container">
        <section class="banner">
            <section class="hero-banner">
                <h1>Mes Emprunts</h1>
                <p class="hero-subtitle">Liste de vos médias empruntés</p>
            </section>
        </section>

        <!-- Affichage des messages flash (succès ou erreur) -->
        <?php if (has_flash_messages('success')): ?>
            <?php foreach (get_flash_messages('success') as $message): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (has_flash_messages('error')): ?>
            <?php foreach (get_flash_messages('error') as $message): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Affichage de la liste des emprunts -->
        <section class="rentals-list">
            <?php if (empty($rentals)): ?>
                <p>Vous n'avez aucun emprunt.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Type</th>
                            <th>Date d'Emprunt</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rentals as $rental): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($rental['title']); ?></td>
                                <td><?php echo htmlspecialchars($rental['type'] == 'book' ? 'Livre' : ($rental['type'] == 'film' ? 'Film' : 'Jeu Vidéo')); ?></td>
                                <td><?php echo htmlspecialchars($rental['rent_date']); ?></td>
                                <td>
                                    <?php if ($rental['status'] == 'loué'): ?>
                                        <a href="<?php echo url('rental/return/' . $rental['id']); ?>" class="btn btn-return">Retourner</a>
                                    <?php else: ?>
                                        <span>Retourné</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>
    </section>

    <script src="<?php echo url('assets/js/app.js'); ?>"></script>
</body>
</html>