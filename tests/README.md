# Tests

Ce dossier contient les tests pour la bibliothèque BridgeSQL.

## Fichiers de test

### `test_connection.php`
Test simple de connexion à la base de données.

**Exécution :**
```bash
php tests/test_connection.php
```

## Configuration

Assurez-vous que votre base de données est configurée avant d'exécuter les tests. 
Modifiez les paramètres de connexion dans le fichier de test selon votre environnement.

## Tests futurs

Des tests unitaires plus complets seront ajoutés dans les prochaines versions :
- Tests des méthodes `fetch()` et `fetchAll()`
- Tests des transactions
- Tests des requêtes préparées
- Tests de gestion d'erreurs

