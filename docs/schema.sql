CREATE TABLE utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    adresse VARCHAR(255),
    role VARCHAR(50) NOT NULL
);

CREATE TABLE categorie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    description TEXT
);

CREATE TABLE produit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    description TEXT,
    prix DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    categorie_id INT NOT NULL,

    CONSTRAINT fk_produit_categorie
        FOREIGN KEY (categorie_id)
        REFERENCES categorie(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE INDEX idx_produit_categorie ON produit(categorie_id);

CREATE TABLE commande (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATETIME NOT NULL,
    statut VARCHAR(50) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    utilisateur_id INT NOT NULL,

    CONSTRAINT fk_commande_utilisateur
        FOREIGN KEY (utilisateur_id)
        REFERENCES utilisateur(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE INDEX idx_commande_utilisateur ON commande(utilisateur_id);

CREATE TABLE order_item (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quantite INT NOT NULL,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    commande_id INT NOT NULL,
    produit_id INT NOT NULL,

    CONSTRAINT fk_orderitem_commande
        FOREIGN KEY (commande_id)
        REFERENCES commande(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_orderitem_produit
        FOREIGN KEY (produit_id)
        REFERENCES produit(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE INDEX idx_orderitem_commande ON order_item(commande_id);
CREATE INDEX idx_orderitem_produit ON order_item(produit_id); 

CREATE TABLE IF NOT EXISTS panier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantite INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_panier_utilisateur 
        FOREIGN KEY (user_id) 
        REFERENCES utilisateur(id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    CONSTRAINT fk_panier_produit 
        FOREIGN KEY (product_id) 
        REFERENCES produit(id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE,
    UNIQUE KEY unique_user_product (user_id, product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
