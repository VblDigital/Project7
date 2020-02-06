# *BileMo API*

## BileMo est une entreprise offrant toute une sélection de téléphones mobiles haut de gamme

Nous proposons de fournir à toutes les plateformes qui le souhaitent l’accès au catalogue via une API. Notre créneau est la vente exclusivement en B2B

### Contrat client First
#### Quels sont vos besoins
*   consulter la liste des produits BileMo ;
*   consulter les détails d’un produit BileMo ;
*   consulter la liste des utilisateurs inscrits liés à un client sur le site web ;
*   consulter le détail d’un utilisateur inscrit lié à un client ;
*   ajouter un nouvel utilisateur lié à un client ;
*   supprimer un utilisateur ajouté par un client.

#### Quels sont vos contraintes
*   seuls les utilisateurs référencés peuvent accéder à l'API
*   nous devons respecter les niveaux 1, 2 et 3 du modèle de Richardson
*   les données doivent être transmises en JSON.
*   les réponses devront être mises en cache

#### La documentation
Elle sera disponible ici : votre_domaine/doc

#### L'installation
*   cloner ou télécharger le projet pour installer son contenu : <br>
```cd project7/```<br>
```git clone https://github.com/vbopenclass/Project7.git```

*   créer un fichier .env dans le même répertoire que l'index.php et insérer y vos identifiants de base de données
*   utiliser Composer pour installer les dépendances :<br>
```composer install```

*   créer la base de données :<br>
```php bin/console do:da:cr```

    et les tables<br>
```php bin/console do:sc:up --force```

*   utiliser les fixtures pour insérer des données :<br>
```php bin/console do:fi:lo --append```

*   lancer le serveur :<br>
```php bin/console se:ru```

*   créér un répertoire jwt/ dans le répertoire config et y insérer vos clés privée et publique

Cette API a été développée avec :
*   Symfony 4.4
*   WampServer - Version Version 3.1.9 - 64bit 
*   PhpStorm - 2019.1.1
*   Postman Version 7.17.0

Pour le versionning, les fichiers ont été placés dans un repository sur GitHub.
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/3d25db7847a741f09ad24670adf796ad)](https://www.codacy.com/manual/vbopenclass/Project7?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=vbopenclass/Project7&amp;utm_campaign=Badge_Grade)

Valérie Bleser - vbopenclass<br>