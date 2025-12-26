# Exemples d'utilisation de BridgeSQL

Ce dossier contient des exemples pratiques d'utilisation de la bibliothèque BridgeSQL.

## 📁 Fichiers disponibles

### `config.php`
Fichier de configuration de base de données. **Modifiez ce fichier** avec vos propres paramètres de connexion.

### `simple_example.php`
Exemple basique montrant comment :
- Se connecter à une base de données
- Récupérer une seule ligne avec `fetch()`

**Exécution :**
```bash
php examples/simple_example.php
```

### `commandes_list.php`
Exemple complet avec affichage HTML montrant :
- Récupération de plusieurs tables avec `fetchAll()`
- Jointures SQL complexes
- Affichage dans un tableau HTML stylisé
- Comptage de résultats

**Accès :** Ouvrez dans votre navigateur ou servez avec un serveur PHP local.

### `ajouter_commande.php`
Exemple de formulaire d'ajout montrant :
- Traitement de formulaire POST
- Insertion de données avec `execute()`
- Récupération du dernier ID avec `lastInsertId()`
- Validation des données
- Interface utilisateur moderne

**Accès :** Ouvrez dans votre navigateur ou servez avec un serveur PHP local.

### `transactions_example.php`
Exemple d'utilisation des transactions montrant :
- Démarrage d'une transaction avec `beginTransaction()`
- Exécution de plusieurs requêtes
- Validation avec `commit()`
- Annulation avec `rollBack()` en cas d'erreur

**Exécution :**
```bash
php examples/transactions_example.php
```

## 🚀 Démarrage rapide

1. **Configurez votre base de données :**
   ```php
   // Modifiez examples/config.php
   return [
       'driver'   => 'mysql',
       'host'     => 'localhost',
       'dbname'   => 'votre_base',
       'username' => 'root',
       'password' => '',
   ];
   ```

2. **Testez la connexion :**
   ```bash
   php examples/simple_example.php
   ```

3. **Explorez les autres exemples :**
   - Pour les exemples web, utilisez un serveur PHP local :
     ```bash
     php -S localhost:8000
     ```
   - Puis ouvrez `http://localhost:8000/examples/commandes_list.php`

## ⚠️ Note importante

Les exemples utilisent des tables spécifiques (`agents`, `commandes`, `demandeurs`, `produits`). 
Adaptez les requêtes SQL selon votre propre schéma de base de données.

