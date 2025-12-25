<div style="max-width: 500px; margin: 40px auto; padding: 20px;">
    <h2 style="margin-bottom: 20px;">Inscription</h2>

    <?php if (isset($error)): ?>
        <div style="padding: 10px; margin-bottom: 20px; border-radius: 4px;
                    background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
            ❌ <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/register" style="display: flex; flex-direction: column; gap: 15px;">
        <div>
            <label for="nom" style="display: block; margin-bottom: 5px;">Nom</label>
            <input type="text"
                   id="nom"
                   name="nom"
                   required
                   value="<?= isset($old_values['nom']) ? htmlspecialchars($old_values['nom']) : '' ?>"
                   style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
        </div>

        <div>
            <label for="email" style="display: block; margin-bottom: 5px;">Email</label>
            <input type="email"
                   id="email"
                   name="email"
                   required
                   value="<?= isset($old_values['email']) ? htmlspecialchars($old_values['email']) : '' ?>"
                   style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
        </div>

        <div>
            <label for="password" style="display: block; margin-bottom: 5px;">Mot de passe</label>
            <input type="password"
                   id="password"
                   name="password"
                   required
                   minlength="6"
                   style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
        </div>

        <div>
            <label for="password_confirm" style="display: block; margin-bottom: 5px;">Confirmation du mot de passe</label>
            <input type="password"
                   id="password_confirm"
                   name="password_confirm"
                   required
                   minlength="6"
                   style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
        </div>

        <div style="display: flex; align-items: center; gap: 8px; padding: 10px; background-color: #f8f9fa; border-radius: 4px;">
            <input type="checkbox"
                   id="is_admin"
                   name="is_admin"
                   value="1"
                   <?= isset($old_values['is_admin']) && $old_values['is_admin'] ? 'checked' : '' ?>
                   style="width: auto; cursor: pointer;">
            <label for="is_admin" style="margin: 0; cursor: pointer; font-weight: normal;">
                👑 Créer un compte administrateur
            </label>
        </div>

        <button type="submit"
                style="padding: 10px 15px; background-color: #28a745; color: white;
                       border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
            🧾 Créer mon compte
        </button>
    </form>

    <p style="margin-top: 15px; font-size: 14px;">
        Déjà inscrit ?
        <a href="/login" style="color: #007bff; text-decoration: none;">Se connecter</a>
    </p>
</div>


