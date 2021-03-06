# FORUM
 
Dépôt GITHUB d'un projet en symfony pour le cours de **David PATIASHVILI**.

## [Process.md](https://github.com/iLuuK/forum/blob/develop/process.md)

## Les prérequis

1. Avoir un php 8.1 et une base de donnée : [Installer XAMPP qui s'occupera d'installer PHP 8.1 et une base de donnée MariaDB](https://www.apachefriends.org/fr/index.html )
2. Installer composer
    1. Télécharger l'exécutable [depuis ce lien](https://getcomposer.org/download/)
    2. Vérifier si la variable d'environnement s'est bien ajoutée
3. Installer Symfony CLI avec l'un des choix disponible [ici](https://symfony.com/download)
    1. Vérifier si la variable d'environnement s'est bien ajoutée
4. Vérifier si l'installation est bonne avec cette commande `symfony check:requirements`
5. Si une erreur apparaît suivez les instructions pour la corriger
6. Pour plus de détails consultez la document technique de Symfony [ici](https://symfony.com/doc/current/setup.html)

## Lancer le projet

1. Télécharger les fichiers
2. Lancer XAMPP
3. A la raçine du dossier il existe un fichier ".env", recopiez le en le renommant "env.local" pour configurer votre base de donnée locale.
4. Modifier la ligne lié aux informations de votre base de donnée avec vos données disponible sur le PHPMyAdmin lancé avec XAMPP
5. En ouvrant un terminal à la raçine du projet exécutez cette commande `composer install` pour installer les packages nécessaires.
6. Puis de la même façon cette commande `php bin/console doctrine:database:create` pour créer la base de donnée que vous avez configuré précédemment.
7. Continuez avec cette commande `php bin/console doctrine:migrations:migrate` pour lancer les migrations des entités.
    1. Répondez "yes" à la question
8. Puis `php bin/console doctrine:fixtures:load` pour ajouter à votre base de donnée des informations générées aléatoirement
9. Enfin vous pouvez avec cette commande lancer le projet `symfony server:start`
    1. Des informations vont s'afficher dans le terminal, et un lien s'affichera sur fond vert.
    
## Cas de test

### Utilisateur

1. Cliquez sur "Se connecter" en haut à droite
    1. Information de connexion : pseudo -> **lambda** et mot de passe -> **lambda**
    2. Cliquez sur "Connecter
2. Cliquez sur "Mon compte" en haut à droite
    1. Modifez les informations nécessaires, sur certain champs comme le pseudo il existe un nombre maximum de 100 caractères et un pattern alpha numérique à respecter.
    2. Cliquez sur "Mettre à jour"
3. Cliquez sur "Tickets" en haut à gauche pour voir les tickets les plus récents
    1. Dans la liste le début correspond au nom de la catégorie, et la suite en **gras** au nom du ticket après vient une pastille qui indique le nombre de commentaire.
    2. Cliquez sur un ticket
    3. En haut se trouve le nom du ticket
    4. Puis le nom de l'autheur en *italique* cliquable
    5. En dessous se trouve le nom de la catégorie
    6. Et le long texte correspond au contenu du ticket
    7. Deux bouttons permettent de voir le nombre de like et dislike mais aussi d'y ajouter sa réaction
        1. Vous ne pourrez pas changer votre réaction
    8. La liste des commentaires s'affiche avec en bas à droite le nom de l'autheur cliquable
    9. Un champ de saisie est disponible pour ajouter un commentaire
        1. Ajouter du texte et cliquez sur "Ajouter"
        2. La page s'est rafraîchit avec votre commentaire
4. Cliquez sur "Catégories" en haut à gauche pour voir la liste des catégories
    1. Dans la liste le début de la ligne correspond au parent d'une catégorie et la suite en **gras** correspond au nom de la catégorie puis une pastille indique le nombre de ticket dans la catégorie.
    2. Cliquez sur une catégorie
    3. Une liste s'affiche avec la liste de tous les tickets qui sont dans la catégorie choisie.
    4. Vous pouvez réeffectuer les actions du point "3."
5. Cliquez sur "Ajouter un ticket" en haut à gauche pour ajouter un nouveau ticket
    1. Remplissez le titre et le contenu et choisissez une catégorie
    2. Cliquez sur "Ajoutez"
    3. Vous êtes redirigé vers votre nouveau ticket.
    4. Vous avez en haut un nouveau bouton qui vous permets de clôturer le ticket
        1. Une fois cliquez ce ticket sera toujours visible
        2. Plus personne ne pourra y donner une réaction
        3. Plus personne ne pourras y ajouter un commentaire
6. Cliquez sur "Mes intéractions" en haut à droite pour voir vos actions
    1. Vous avez accès à la liste de vos commentaires
        1. En cliquant sur "Voir le ticket" vous serez redirigé vers le ticket
        2. En cliquant sur un élement de la liste de vos intéractions vous serez redirigé vers le ticket.
7. Cliquez sur Cliquez sur "Mon compte" en haut à droite
    1. Cliquez sur "Supprimer mon compte"
        1. Si vous tentez de vous reconnecter un message vous indiquera que votre compte est clôturé.


### Administrateur

1. Cliquez sur "Se connecter" en haut à droite
    1. Information de connexion : pseudo -> **admin** et mot de passe -> **admin**
    2. Cliquez sur "Connecter
2. Les mêmes actions qu'un utilisateur sont disponibles
3. Cliquez sur "Liste utilisateurs" en haut à gauche
    1. Les informations de chaque utilisateur y sont affichées
    2. En fonctions des états des utilisateurs 3 boutons sont disponibles
        1. "Voir détail" pour afficher la page avec les intéractions d'un utilisateur
        2. "Clôturer" pour fermer définitvement le compte d'un utilisateur
            1. A sa connexion un message apparaitra
        3. "Bannir"/"Débannir" pour bloqué temporairement un utilisateur
            1. A sa connexion un message apparaitra
        4. Ces boutons ne fonctionnent pas sur l'administrateur connecté
4. Cliquez sur "Catégories" en haut à gauche pour afficher les catégories
    1. Cliquez sur "Ajouter" pour ajouter une catégorie
        1. Comme pour tous les formulaires des contraintes existent
    2. Cliquez sur "Modifier" pour modifier une catégorie
        1. Comme pour tous les formulaires des contraintes existent
        2. Dans la liste des parents disponible la catégorie qui est modifé n'est pas affiché pour pas avoir de relation entre elle même.
    2. Cliquez sur "Supprimer" pour supprimer une catégorie.
        1. Seulement celles sans enfant ou celles avec enfants supprimés peuvent l'être
5. Allez sur un ticket avec des commentaires
    1. Il est possible de supprimer un ticket
        1. Plus personne ne verra le ticket et les commentaires associés
    2. Il est possible de clôturer un ticket
        Une fois cliquez ce ticket sera toujours visible
        Plus personne ne pourra y donner une réaction
        Plus personne ne pourra y ajouter un commentaire
    3. Il est possible de supprimer un commentaire
        1. Plus personne ne pourra le voir

## Pense-bête

1. Pour vérifier si symfony est bien installé : `symfony check:requirements`
2. Pour installer les packages du projet : `composer install`
3. Pour créér la base de donnée : `php bin/console doctrine:database:create`
4. Pour faire la migration : `php bin/console doctrine:migrations:migrate`
5. Pour générer des données aléatoires : `php bin/console doctrine:fixtures:load`
6. Pour lancer le projet `symfony server:start`
