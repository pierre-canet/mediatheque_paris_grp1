<div class="hero">
    <div class="hero-content">
        <h1><?php e($message); ?></h1>
        <p class="hero-subtitle">Un starter kit PHP avec architecture MVC procédurale</p>
        <?php if (!is_logged_in()): ?>
            <div class="hero-buttons">
                <a href="<?php echo url('auth/register'); ?>" class="btn btn-primary">Commencer</a>
                <a href="<?php echo url('auth/login'); ?>" class="btn btn-secondary">Se connecter</a>
            </div>
        <?php else: ?>
            <p class="welcome-message">
                <i class="fas fa-user"></i> 
                Bienvenue, <?php e($_SESSION['user_name']); ?> !
            </p>
        <?php endif; ?>
    </div>
</div>

<section class="features">
    <div class="container">
        <h2>Fonctionnalités incluses</h2>
        <div class="features-grid">
            <?php foreach ($features as $feature): ?>
                <div class="feature-card">
                    <i class="fas fa-check-circle"></i>
                    <h3><?php e($feature); ?></h3>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="getting-started">
    <div class="container">
        <h2>Commencer rapidement</h2>
        <div class="steps">
            <div class="step">
                <div class="step-number">1</div>
                <h3>Configuration</h3>
                <p>Configurez votre base de données dans <code>config/database.php</code></p>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <h3>Développement</h3>
                <p>Créez vos contrôleurs, modèles et vues dans leurs dossiers respectifs</p>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <h3>Déploiement</h3>
                <p>Uploadez votre application sur votre serveur web</p>
            </div>
        </div>
    </div>
</section> 