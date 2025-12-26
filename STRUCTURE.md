# Structure du Projet BridgeSQL

Ce document décrit l'organisation et la structure du projet BridgeSQL.

## 📁 Arborescence

```
BridgeSQL/
│
├── src/                          # Code source de la bibliothèque
│   ├── BridgeSQL.php            # Classe principale
│   └── Exceptions/               # Exceptions personnalisées
│       └── BridgeSQLException.php
│
├── examples/                     # Exemples d'utilisation
│   ├── config.php                # Configuration de base de données (à modifier)
│   ├── simple_example.php        # Exemple basique
│   ├── commandes_list.php        # Exemple avec affichage HTML
│   ├── ajouter_commande.php      # Exemple de formulaire
│   ├── transactions_example.php  # Exemple de transactions
│   └── README.md                 # Documentation des exemples
│
├── tests/                        # Tests
│   ├── test_connection.php       # Test de connexion
│   └── README.md                 # Documentation des tests
│
├── config/                       # Fichiers de configuration d'exemple
│   └── database.example.php      # Template de configuration
│
├── vendor/                       # Dépendances Composer (généré automatiquement)
│
├── .gitignore                    # Fichiers à ignorer par Git
├── composer.json                 # Configuration Composer
├── LICENSE                       # Licence MIT
├── README.md                     # Documentation principale
├── CHANGELOG.md                  # Historique des versions
└── STRUCTURE.md                  # Ce fichier                

```

## 📂 Description des dossiers

### `src/`
Contient le code source principal de la bibliothèque. C'est ici que se trouve la classe `BridgeSQL` et ses exceptions.

**Fichiers :**
- `BridgeSQL.php` : Classe principale avec toutes les méthodes pour interagir avec la base de données
- `Exceptions/BridgeSQLException.php` : Exception personnalisée pour gérer les erreurs

### `examples/`
Contient des exemples pratiques d'utilisation de la bibliothèque. Ces fichiers servent de documentation et de référence.

**Fichiers :**
- `config.php` : **À modifier** avec vos propres paramètres de connexion
- `simple_example.php` : Exemple minimaliste
- `commandes_list.php` : Exemple complet avec interface HTML
- `ajouter_commande.php` : Exemple de formulaire avec traitement POST
- `transactions_example.php` : Exemple d'utilisation des transactions

### `tests/`
Contient les tests de la bibliothèque. Actuellement, il y a un test de connexion basique.

**Fichiers :**
- `test_connection.php` : Test de connexion à la base de données

### `config/`
Contient des fichiers de configuration d'exemple qui peuvent être copiés et modifiés.

**Fichiers :**
- `database.example.php` : Template de configuration de base de données

### `vendor/`
Dossier généré automatiquement par Composer. Contient les dépendances et l'autoloader.

⚠️ **Ne pas modifier manuellement** - Ce dossier est géré par Composer.

## 🔧 Fichiers de configuration

### `composer.json`
Configuration Composer pour l'autoloading PSR-4 et les métadonnées du package.

### `.gitignore`
Liste des fichiers et dossiers à exclure du contrôle de version Git :
- `vendor/` (dépendances)
- Fichiers IDE (`.idea/`, `.vscode/`)
- Fichiers système (`.DS_Store`, `Thumbs.db`)
- Fichiers de configuration locaux (`.env`)

## 📝 Fichiers de documentation

### `README.md`
Documentation principale du projet avec :
- Description de la bibliothèque
- Instructions d'installation
- Exemples d'utilisation
- Référence de l'API

### `CHANGELOG.md`
Historique des versions et changements du projet.

### `STRUCTURE.md`
Ce fichier - Description de l'organisation du projet.

## 🚀 Utilisation

### Pour les développeurs
1. Clonez ou téléchargez le projet
2. Exécutez `composer install` pour installer les dépendances
3. Consultez les exemples dans `examples/`
4. Utilisez la classe `BridgeSQL` dans vos projets

### Pour les contributeurs
1. Respectez la structure existante
2. Placez les nouveaux exemples dans `examples/`
3. Ajoutez les tests dans `tests/`
4. Documentez vos changements dans `CHANGELOG.md`

## 📋 Conventions

- **PSR-4** : Autoloading suivant les standards PSR-4
- **PSR-12** : Style de code suivant les standards PSR-12
- **PHPDoc** : Toutes les méthodes sont documentées avec PHPDoc
- **Namespaces** : Utilisation du namespace `BridgeSQL\`

## 🔄 Maintenance

### Ajout d'une nouvelle fonctionnalité
1. Ajoutez le code dans `src/BridgeSQL.php`
2. Documentez avec PHPDoc
3. Créez un exemple dans `examples/`
4. Ajoutez un test dans `tests/`
5. Mettez à jour `CHANGELOG.md`

### Modification de la structure
Si vous modifiez la structure, mettez à jour ce fichier (`STRUCTURE.md`) en conséquence.

