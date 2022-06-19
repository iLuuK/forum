# Conception

## Commun

1. **FormHelper** Qui contient une varaible regex static que j'utilise sur plusieurs formulaires
2. **CreatedAtTrait** pour la date de création de mes entités
3. **IsDeletedTrait** pour le paramètre is_deleted de mes entités
4. **SlugTrait** pour le slug de mes entités
5. **UpdatedAtTrait** pour la date de mise à jour de mes entités
5. **RoleTrait** pour vérifier les roles dans mes controller
6. **DeleteTrait** pour centraliser les functions de suppression d'entité qui sont appelé à différents endroits.

## Authentification utilisateur

1. **AuthenticatorController** pour la partie route de connexion et de déconnexion
2. **RegistrationController** pour la partie route de l'inscription
3. **UserController** pour la partie route des modification sur un utilisateur
4. **UserFixtures** pour ajouter des données aléatoires d'utilisateurs
5. **User** class de l'utilisateur
6. **UserFormType** formulaire de l'utilisateur avec les contraintes sur les champs
7. **RegistrationFormType** formulaire inscription
8. **UserRepository** pour les requêtes en base de donnée
9. **UserAuthenticator** pour gérer l'authentification
10. **UserChecker** pour gérer les cas d'utilisateurs bannis ou supprimés

## Catégorie

1. **CategoryController** pour la partie route des catégories
2. **CategoryFixtures** pour ajouter des données aléatoires de catégories
3. **Category** class de catégorie
4. **CategoryFormType** formulaire d'ajout de catégorie avec les contraintes sur les champs
5. **CategoryRepository** pour faire les requêtes en base de donnée, ajout d'une function pour appeler les catégories sans parent.

## Ticket

1. **TicketController** pour la partie route des tickets
2. **TicketFixtures** pour générer des données
3. **Ticket** la classe
4. **TicketFormType** pour ajouter un ticket avec contraintes
5. **TicketRepository** pour les requêtes en base de donnée avec des functions comme "findLast" et "findByCategory"

## Commentaire

1. **TicketCommentController** pour la partie route des tickets
2. **TicketCommentFixtures** pour générer des données
3. **TicketComment** la class
4. **TicketCommentFormType** pour le formulaire de création de message avec contraintes
5. **TicketCommentRepository** pour les requêtes en base de donnée

## Réaction

1. **ReactionController** pour la partie route
2. **ReactionFixtures** pour générer des données
3. **Reaction** la class
4. **ReactionRepository** pour faire des requêtes en base de donné avec une fonction pour vérifier si une réaction n'a pas déjà était posté