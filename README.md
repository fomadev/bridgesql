# BridgeSQL

BridgeSQL est une bibliothèque PHP légère et moderne qui simplifie l'utilisation de PDO avec MySQL.

Cette version **1.0.0** est volontairement minimale et se concentre sur :
- ✅ Configuration simple et intuitive
- ✅ Requêtes préparées sécurisées
- ✅ Méthodes utilitaires pratiques (`fetch`, `fetchAll`, `execute`, transactions, etc.)
- ✅ Gestion d'erreurs robuste
- ✅ Code propre et bien documenté

## 📋 Structure du Projet

```
BridgeSQL/
├── src/                    # Code source de la bibliothèque
│   ├── BridgeSQL.php      # Classe principale
│   └── Exceptions/         # Exceptions personnalisées
│       └── BridgeSQLException.php
├── examples/               # Exemples d'utilisation
│   ├── config.php         # Configuration de base de données
│   ├── simple_example.php # Exemple basique
│   ├── commandes_list.php # Exemple avec affichage HTML
│   ├── ajouter_commande.php # Exemple de formulaire
│   └── transactions_example.php # Exemple de transactions
├── tests/                  # Tests unitaires
│   └── test_connection.php
├── config/                 # Fichiers de configuration d'exemple
│   └── database.example.php
├── vendor/                 # Dépendances Composer (généré)
├── composer.json           # Configuration Composer
├── .gitignore             # Fichiers à ignorer par Git
└── README.md              # Ce fichier
```

## 🚀 Installation

### Avec Composer

```bash
composer require fomadev/bridgesql
```

Ou si vous clonez ce dépôt :

```bash
composer install
```

### Configuration

1. Copiez le fichier `config/database.example.php` vers `examples/config.php`
2. Modifiez les valeurs selon votre environnement :

```php
return [
    'driver'   => 'mysql',
    'host'     => 'localhost',
    'dbname'   => 'votre_base_de_donnees',
    'username' => 'root',
    'password' => '',
    'charset'  => 'utf8mb4',
];
```

## 💡 Exemples d'utilisation

### Exemple basique

```php
<?php
require_once 'vendor/autoload.php';

use BridgeSQL\BridgeSQL;
use BridgeSQL\Exceptions\BridgeSQLException;

try {
    $db = new BridgeSQL([
        'driver'   => 'mysql',
        'host'     => 'localhost',
        'dbname'   => 'demo',
        'username' => 'root',
        'password' => '',
    ]);

    // Récupérer un utilisateur
    $user = $db->fetch("SELECT * FROM users WHERE id = :id", ['id' => 1]);
    
    // Récupérer tous les utilisateurs
    $users = $db->fetchAll("SELECT * FROM users");
    
    // Insérer un utilisateur
    $rows = $db->execute(
        "INSERT INTO users (name, email) VALUES (:name, :email)",
        ['name' => 'Fordi', 'email' => 'fordimalanda7@gmail.com']
    );
    
    echo "Lignes insérées : " . $rows . PHP_EOL;
    echo "Dernier ID : " . $db->lastInsertId() . PHP_EOL;

} catch (BridgeSQLException $e) {
    echo "Erreur BridgeSQL : " . $e->getMessage();
}
```

### Utilisation avec des transactions

```php
$db->beginTransaction();
try {
    $db->execute("UPDATE accounts SET balance = balance - :amount WHERE id = :id", [
        'amount' => 100,
        'id'     => 1,
    ]);

    $db->execute("UPDATE accounts SET balance = balance + :amount WHERE id = :id", [
        'amount' => 100,
        'id'     => 2,
    ]);

    $db->commit();
    echo "Transaction réussie !";
} catch (BridgeSQLException $e) {
    $db->rollBack();
    echo "Transaction annulée : " . $e->getMessage();
}
```

### Exemples complets

Consultez le dossier `examples/` pour des exemples plus complets :
- `simple_example.php` - Utilisation basique
- `commandes_list.php` - Affichage HTML avec liste de commandes
- `ajouter_commande.php` - Formulaire d'ajout avec validation
- `transactions_example.php` - Gestion des transactions

## 📚 API Référence

### Méthodes principales

#### `__construct(array $config)`
Crée une nouvelle instance de BridgeSQL avec la configuration fournie.

#### `getPdo(): PDO`
Retourne l'instance PDO brute pour des opérations avancées.

#### `query(string $sql, array $params = []): \PDOStatement`
Exécute une requête préparée et retourne le PDOStatement.

#### `fetch(string $sql, array $params = []): ?array`
Récupère une seule ligne (retourne `null` si aucune ligne trouvée).

#### `fetchAll(string $sql, array $params = []): array`
Récupère toutes les lignes.

#### `execute(string $sql, array $params = []): int`
Exécute une requête d'écriture (INSERT, UPDATE, DELETE) et retourne le nombre de lignes affectées.

#### `beginTransaction(): bool`
Démarre une transaction.

#### `commit(): bool`
Valide une transaction.

#### `rollBack(): bool`
Annule une transaction.

#### `lastInsertId(): string`
Retourne le dernier ID inséré.

### Voir <a href="docs/bridgesql_v1.pptx">La présentation PowerPoint</a>

## 🔒 Sécurité

- ✅ Toutes les requêtes utilisent des requêtes préparées
- ✅ Protection contre les injections SQL
- ✅ Gestion d'erreurs robuste
- ✅ Validation des paramètres

## 🛠️ Requirements

- PHP >= 8.0
- PDO MySQL extension
- Composer (pour l'autoloading)

## 📄 Licence

MIT License - Voir le fichier `LICENSE` pour plus de détails.

## 👨‍💻 Auteur

Développé par l'équipe **FomaDev** avec l'ambition de simplifier les connexions entre PHP et les bases de données 💡

## 🤝 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à ouvrir une issue ou une pull request.
