<?php
/**
 * Exemple : Formulaire d'ajout de commande
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BridgeSQL\BridgeSQL;
use BridgeSQL\Exceptions\BridgeSQLException;

$config = require __DIR__ . '/config.php';

$message = '';
$error = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new BridgeSQL($config);
        
        // Validation des données (exemple basique)
        $id_demandeur = $_POST['id_demandeur'] ?? null;
        $id_produit = $_POST['id_produit'] ?? null;
        $qte = $_POST['qte'] ?? null;
        $prix_paye = $_POST['prix_paye'] ?? null;
        
        if (!$id_demandeur || !$id_produit || !$qte || !$prix_paye) {
            throw new Exception("Tous les champs sont requis.");
        }
        
        // Insertion de la commande
        $sql = "INSERT INTO commandes (id_demandeur, id_produit, qte, prix_paye, date_paye, num_facture) 
                VALUES (:id_demandeur, :id_produit, :qte, :prix_paye, NOW(), :num_facture)";
        
        $num_facture = 'FAC-' . date('Ymd') . '-' . rand(1000, 9999);
        
        $rows = $db->execute($sql, [
            'id_demandeur' => $id_demandeur,
            'id_produit' => $id_produit,
            'qte' => $qte,
            'prix_paye' => $prix_paye,
            'num_facture' => $num_facture
        ]);
        
        if ($rows > 0) {
            $message = "Commande ajoutée avec succès ! ID : " . $db->lastInsertId();
        } else {
            $error = "Erreur lors de l'ajout de la commande.";
        }
        
    } catch (BridgeSQLException $e) {
        $error = "Erreur BridgeSQL : " . $e->getMessage();
    } catch (Exception $e) {
        $error = "Erreur : " . $e->getMessage();
    }
}

// Récupération des données pour les listes déroulantes
try {
    $db = new BridgeSQL($config);
    $demandeurs = $db->fetchAll("SELECT id_demandeur, CONCAT(prenom, ' ', nom, ' ', postnom) AS nom_complet FROM demandeurs ORDER BY nom");
    $produits = $db->fetchAll("SELECT id_produit, nom, prix FROM produits ORDER BY nom");
} catch (BridgeSQLException $e) {
    $error = "Erreur lors du chargement des données : " . $e->getMessage();
    $demandeurs = [];
    $produits = [];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Commande - BridgeSQL Demo</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #4CAF50;
        }
        
        .message {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 500;
        }
        
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        
        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            outline: none;
            border-color: #4CAF50;
        }
        
        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        
        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-primary {
            background-color: #4CAF50;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #45a049;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        
        .help-text {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>➕ Ajouter une Commande</h1>
        
        <?php if ($message): ?>
            <div class="message success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="message error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="id_demandeur">Demandeur *</label>
                <select name="id_demandeur" id="id_demandeur" required>
                    <option value="">-- Sélectionner un demandeur --</option>
                    <?php foreach ($demandeurs as $demandeur): ?>
                        <option value="<?= htmlspecialchars($demandeur['id_demandeur']) ?>">
                            <?= htmlspecialchars($demandeur['nom_complet']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="id_produit">Produit *</label>
                <select name="id_produit" id="id_produit" required>
                    <option value="">-- Sélectionner un produit --</option>
                    <?php foreach ($produits as $produit): ?>
                        <option value="<?= htmlspecialchars($produit['id_produit']) ?>" 
                                data-prix="<?= htmlspecialchars($produit['prix']) ?>">
                            <?= htmlspecialchars($produit['nom']) ?> - <?= number_format($produit['prix'], 0, ',', ' ') ?> FC
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="qte">Quantité *</label>
                <input type="number" name="qte" id="qte" min="1" required>
            </div>
            
            <div class="form-group">
                <label for="prix_paye">Prix Payé (FC) *</label>
                <input type="number" name="prix_paye" id="prix_paye" min="0" step="0.01" required>
                <div class="help-text">Le montant payé pour cette commande</div>
            </div>
            
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="commandes_list.php" class="btn btn-secondary">Retour à la liste</a>
            </div>
        </form>
    </div>
    
    <script>
        // Calcul automatique du prix total basé sur la quantité et le prix du produit
        document.getElementById('id_produit').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const prixUnitaire = selectedOption.dataset.prix || 0;
            const qteInput = document.getElementById('qte');
            
            if (qteInput.value) {
                document.getElementById('prix_paye').value = (prixUnitaire * qteInput.value).toFixed(2);
            }
        });
        
        document.getElementById('qte').addEventListener('input', function() {
            const produitSelect = document.getElementById('id_produit');
            const selectedOption = produitSelect.options[produitSelect.selectedIndex];
            const prixUnitaire = selectedOption.dataset.prix || 0;
            
            if (this.value && prixUnitaire) {
                document.getElementById('prix_paye').value = (prixUnitaire * this.value).toFixed(2);
            }
        });
    </script>
</body>
</html>

