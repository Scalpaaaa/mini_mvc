<div style="max-width: 500px; margin: 40px auto; padding: 20px;">
    <h2 style="margin-bottom: 20px;">Connexion</h2>

    <?php if (isset($error)): ?>
        <div style="padding: 10px; margin-bottom: 20px; border-radius: 4px;
                    background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
            ❌ <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/login" style="display: flex; flex-direction: column; gap: 15px;">
        <div>
            <label for="email" style="display: block; margin-bottom: 5px;">Email</label>
            <input type="email"
                   id="email"
                   name="email"
                   required
                   value="<?= isset($old_email) ? htmlspecialchars($old_email) : '' ?>"
                   style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
        </div>

        <div>
            <label for="password" style="display: block; margin-bottom: 5px;">Mot de passe</label>
            <input type="password"
                   id="password"
                   name="password"
                   required
                   style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
        </div>

        <button type="submit"
                style="padding: 10px 15px; background-color: #007bff; color: white;
                       border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
            🔑 Se connecter
        </button>
    </form>

    <p style="margin-top: 15px; font-size: 14px;">
        Pas encore de compte ?
        <a href="/register" style="color: #007bff; text-decoration: none;">Créer un compte</a>
    </p>
</div>


