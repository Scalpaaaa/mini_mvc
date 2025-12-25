# Liste des cours
- [Installation du projet](./docs/README_START.md)
- [Active Record](./docs/active-record.md)

# Mini MVC - Guide d'installation et d'utilisation

## 🔧 Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- **PHP 8.x** ou supérieur (`php -v` pour vérifier)
- **Composer** (`composer -V` pour vérifier)
- **MySQL/MariaDB** (via XAMPP, MAMP, ou installation native)
- **Git** (optionnel, pour cloner le projet)

---

## 💾 Installation de la base de données

### Étape 1 : Créer la base de données

Ouvrez votre client MySQL (phpMyAdmin, MySQL Workbench, ou ligne de commande) et exécutez :

```sql
CREATE DATABASE IF NOT EXISTS mini_mvc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Étape 2 : Importer le schéma

Exécutez le fichier SQL suivant dans votre base de données `mini_mvc` :

**Via phpMyAdmin**
1. Sélectionnez la base de données `mini_mvc`
2. Cliquez sur l'onglet "SQL"
3. Copiez-collez le contenu du fichier `docs/schema.sql`
4. Cliquez sur "Exécuter"

### Étape 3 : Vérifier les tables créées

Vous devriez avoir les tables suivantes :
- `utilisateur`
- `categorie`
- `produit`
- `commande`
- `order_item`
- `panier`

---

## ⚙️ Configuration

### Configuration de la base de données

Modifiez le fichier `app/config.ini` selon votre environnement :

```ini
DB_NAME = "mini_mvc"
DB_HOST = "127.0.0.1:8889"    ; Pour MAMP (Mac) : 127.0.0.1:8889
                                ; Pour XAMPP (Windows) : 127.0.0.1:3306
                                ; Pour installation native : 127.0.0.1:3306
DB_USERNAME = "root"
DB_PASSWORD = "root"            ; Adaptez selon votre configuration
```
---

## 🚀 Lancement du projet

### Serveur PHP intégré

1. **Installer les dépendances Composer** (si ce n'est pas déjà fait) :
```bash
composer install
```

2. **Lancer le serveur PHP** :
```bash
php -S 127.0.0.1:2000 -t public
```

3. **Ouvrir dans le navigateur** :
```
http://127.0.0.1:2000
```

---

## 👤 Identifiants de test

### Identifiants de connexion

#### Compte Administrateur
- **Email** : `admin@gmail.com`
- **Mot de passe** : `admin1`
- **Rôle** : Admin (accès à l'ajout de produits)

#### Compte Client
- **Email** : `samsam@gmail.com`
- **Mot de passe** : `azertyop`
- **Rôle** : Client (accès standard)

---

## 🎯 Fonctionnalités

### Pour tous les utilisateurs
- ✅ Inscription et connexion
- ✅ Consultation des produits
- ✅ Ajout de produits au panier
- ✅ Passer commande
- ✅ Voir ses commandes

### Pour les administrateurs uniquement
- ✅ Ajouter de nouveaux produits
- ✅ Gérer les catégories

---



