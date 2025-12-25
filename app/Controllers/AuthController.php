<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\User;

final class AuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion
     */
    public function showLoginForm(): void
    {
        $this->render('auth/login', [
            'title' => 'Connexion'
        ]);
    }

    /**
     * Traite la connexion
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            return;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $this->render('auth/login', [
                'title' => 'Connexion',
                'error' => 'Email et mot de passe sont obligatoires.',
                'old_email' => $email,
            ]);
            return;
        }

        $user = User::findByEmail($email);

        // On suppose une colonne mot_de_passe (hash) dans la table `utilisateur`
        if (!$user || empty($user['mot_de_passe']) || !password_verify($password, $user['mot_de_passe'])) {
            $this->render('auth/login', [
                'title' => 'Connexion',
                'error' => 'Identifiants invalides.',
                'old_email' => $email,
            ]);
            return;
        }

        // Connexion réussie : on stocke l'utilisateur en session
        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['user_nom'] = $user['nom'] ?? '';
        $_SESSION['user_email'] = $user['email'] ?? '';
        $_SESSION['user_role'] = $user['role'] ?? 'client';

        header('Location: /');
    }

    /**
     * Affiche le formulaire d'inscription
     */
    public function showRegisterForm(): void
    {
        $this->render('auth/register', [
            'title' => 'Inscription'
        ]);
    }

    /**
     * Traite l'inscription
     */
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /register');
            return;
        }

        $nom = trim($_POST['nom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';
        $isAdmin = isset($_POST['is_admin']) && $_POST['is_admin'] === '1';
        $role = $isAdmin ? 'admin' : 'client';

        $oldValues = [
            'nom' => $nom,
            'email' => $email,
            'is_admin' => $isAdmin,
        ];

        if ($nom === '' || $email === '' || $password === '' || $password_confirm === '') {
            $this->render('auth/register', [
                'title' => 'Inscription',
                'error' => 'Tous les champs sont obligatoires.',
                'old_values' => $oldValues,
            ]);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->render('auth/register', [
                'title' => 'Inscription',
                'error' => 'Email invalide.',
                'old_values' => $oldValues,
            ]);
            return;
        }

        if ($password !== $password_confirm) {
            $this->render('auth/register', [
                'title' => 'Inscription',
                'error' => 'Les mots de passe ne correspondent pas.',
                'old_values' => $oldValues,
            ]);
            return;
        }

        if (User::findByEmail($email)) {
            $this->render('auth/register', [
                'title' => 'Inscription',
                'error' => 'Un compte existe déjà avec cet email.',
                'old_values' => $oldValues,
            ]);
            return;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $user = new User();
        $user->setNom($nom);
        $user->setEmail($email);

        if ($user->saveWithPassword($hash, $role)) {
            // On log automatiquement l'utilisateur
            $created = User::findByEmail($email);
            if ($created) {
                $_SESSION['user_id'] = (int)$created['id'];
                $_SESSION['user_nom'] = $created['nom'] ?? '';
                $_SESSION['user_email'] = $created['email'] ?? '';
                $_SESSION['user_role'] = $created['role'] ?? 'client';
            }
            header('Location: /');
        } else {
            $this->render('auth/register', [
                'title' => 'Inscription',
                'error' => 'Erreur lors de la création du compte.',
                'old_values' => $oldValues,
            ]);
        }
    }

    /**
     * Déconnexion
     */
    public function logout(): void
    {
        // Supprime uniquement les infos d'auth pour ne pas casser d'autres données de session éventuelles
        unset($_SESSION['user_id'], $_SESSION['user_nom'], $_SESSION['user_email'], $_SESSION['user_role']);
        header('Location: /');
    }
}


