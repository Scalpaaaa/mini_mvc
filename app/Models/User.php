<?php

// Ici je définit le namespace ou il y aura ma class
namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class User
{
    private $id;
    private $nom;
    private $email;
    // On suppose l'existence d'une colonne mot_de_passe (hash) dans la table `utilisateur`
    private $mot_de_passe;

    // =====================
    // Getters / Setters
    // =====================

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getnom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getMotDePasse()
    {
        return $this->mot_de_passe;
    }

    public function setMotDePasse($mot_de_passe)
    {
        $this->mot_de_passe = $mot_de_passe;
    }

    // =====================
    // Méthodes CRUD
    // =====================

    /**
     * Récupère tous les utilisateurs
     * @return array
     */
    public static function getAll()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->query("SELECT * FROM utilisateur ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un utilisateur par son ID
     * @param int $id
     * @return array|null
     */
    public static function findById($id)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un utilisateur par son email
     * @param string $email
     * @return array|null
     */
    public static function findByEmail($email)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crée un nouvel utilisateur
     * @return bool
     */
    public function save()
    {
        $pdo = Database::getPDO();
        // Méthode de base (sans mot de passe) conservée pour compatibilité
        // On renseigne aussi un rôle par défaut pour respecter la contrainte NOT NULL
        $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, email, role) VALUES (?, ?, ?)");
        return $stmt->execute([$this->nom, $this->email, 'client']);
    }

    /**
     * Crée un utilisateur avec un mot de passe hashé
     * Nécessite une colonne mot_de_passe dans la table `utilisateur`
     * @param string $passwordHash Le mot de passe hashé
     * @param string $role Le rôle de l'utilisateur (par défaut 'client')
     */
    public function saveWithPassword(string $passwordHash, string $role = 'client'): bool
    {
        $pdo = Database::getPDO();
        // Valide le rôle (seulement 'admin' ou 'client' pour la sécurité)
        $role = in_array($role, ['admin', 'client']) ? $role : 'client';
        $stmt = $pdo->prepare("INSERT INTO utilisateur (nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$this->nom, $this->email, $passwordHash, $role]);
    }

    /**
     * Met à jour les informations d’un utilisateur existant
     * @return bool
     */
    public function update()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("UPDATE utilisateur SET nom = ?, email = ? WHERE id = ?");
        return $stmt->execute([$this->nom, $this->email, $this->id]);
    }

    /**
     * Supprime un utilisateur
     * @return bool
     */
    public function delete()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("DELETE FROM utilisateur WHERE id = ?");
        return $stmt->execute([$this->id]);
    }
}
