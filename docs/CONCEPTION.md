CONCEPTION.md : Réponses aux Questions de Réflexion

## Pourquoi stocker le prix unitaire dans la table des lignes de commande plutôt que d'utiliser directement le prix du produit ? 
C'est indispensable pour figer le contrat de vente. 
Comme le prix d'un produit dans le catalogue peut changer n'importe quand (promo, augmentation), 
il faut absolument garder une trace du prix réel payé par le client au moment de sa commande. 
Si on se basait juste sur le prix actuel du produit, notre historique de ventes et notre comptabilité deviendraient faux à chaque changement de tarif.

## Quelle stratégie avez-vous choisie pour gérer les suppressions ? Justifiez vos choix pour chaque relation. 
J'ai utilisé une approche mixte pour protéger les données :

Pour les éléments importants comme les produits ou les utilisateurs, j'utilise ON DELETE RESTRICT. Ça empêche de supprimer par erreur un client ou un article qui est lié à une commande existante, ce qui va casser l'historique.

Et pour les liens internes comme les lignes de commande, j'utilise ON DELETE CASCADE. Si on supprime une commande, ses détails n'ont plus lieu d'être et doivent disparaître avec elle pour ne pas laisser de "déchets" dans la base.

## Comment gérez-vous les stocks ? Que se passe-t-il si un client commande un produit en rupture de stock ? Quand le stock est-il décrémenté ? 
C'est le code PHP qui gère cette logique. J'ai décidé de décrémenter le stock uniquement au moment de la validation du paiement, 
et non lors de l'ajout au panier. Cela évite de bloquer des produits inutilement si l'utilisateur abandonne son panier. 
Tout se passe dans une transaction SQL : on vérifie le stock et on valide la commande en même temps. Si le produit n'est plus dispo à cet instant précis, la commande est bloquée et l'utilisateur est prévenu.

## Avez-vous prévu des index ? Lesquels et pourquoi ? 
Oui, pour que le site reste rapide. 
J'ai mis des index sur toutes les clés étrangères pour accélérer les liens entre les tables (les jointures). 
J'en ai aussi ajouté sur les champs qu'on utilise souvent pour filtrer, comme le nom du produit (pour la recherche) ou le statut de la commande, 
histoire que le back-office ne soit pas lent quand il y aura beaucoup de données.

## Comment assurez-vous l'unicité du numéro de commande ? 
Pour être sûr, je me repose sur la base de données en utilisant la contrainte UNIQUE sur la colonne du numéro de commande. 
C'est une sécurité "en dur" : même si mon code PHP a un bug, la base de données rejettera automatiquement toute tentative de créer un doublon.

## Quelles sont les extensions possibles de votre modèle ? 
Le modèle est conçu pour être évolutif. Sans tout casser, on pourrait facilement ajouter une table pour gérer plusieurs adresses par client (livraison et facturation), un système d'avis et notes, ou encore une table pour gérer plusieurs images par produit. 
La structure actuelle est une base saine pour ces futurs ajouts.