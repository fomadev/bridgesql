# Changelog

Tous les changements notables de ce projet seront documentés dans ce fichier.

## [1.0.0] - 2025

### Ajouté
- Classe principale `BridgeSQL` pour simplifier l'utilisation de PDO
- Support MySQL avec requêtes préparées
- Méthodes utilitaires : `fetch()`, `fetchAll()`, `execute()`
- Support des transactions : `beginTransaction()`, `commit()`, `rollBack()`
- Méthode `lastInsertId()` pour récupérer le dernier ID inséré
- Exception personnalisée `BridgeSQLException`
- Documentation complète dans le README
- Exemples d'utilisation dans le dossier `examples/`
- Fichier `.gitignore` pour exclure les fichiers non nécessaires
- Structure de projet organisée et professionnelle

### Amélioré
- Gestion améliorée des types de paramètres dans les requêtes préparées
- Documentation PHPDoc complète pour toutes les méthodes
- Exemples de code améliorés avec meilleure séparation PHP/HTML
- Interface utilisateur moderne pour les exemples web

### Structure
- Organisation claire des fichiers (src/, examples/, config/, tests/)
- Séparation des exemples de la bibliothèque principale
- Configuration centralisée dans `examples/config.php`

