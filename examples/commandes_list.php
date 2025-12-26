<?php
/**
 * Exemple : Liste des commandes avec affichage HTML
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BridgeSQL\BridgeSQL;
use BridgeSQL\Exceptions\BridgeSQLException;

$config = require __DIR__ . '/config.php';

try {
    $db = new BridgeSQL($config);
    
    // Récupérer tous les agents
    $agents = $db->fetchAll("SELECT * FROM agents");
    
    // Récupérer toutes les commandes avec leurs relations
    $commandes = $db->fetchAll("
        SELECT
            c.id_commande,
            CONCAT(d.prenom, ' ', d.nom, ' ', d.postnom) AS noms,
            p.nom as nom_produit, 
            p.prix as prix_produit,
            p.etat as etat_produit, 
            c.qte, 
            c.prix_paye, 
            c.date_paye,
            c.date_livre, 
            c.status, 
            c.num_facture, 
            c.created_at
        FROM commandes c
        JOIN demandeurs d ON d.id_demandeur = c.id_demandeur
        JOIN produits p ON p.id_produit = c.id_produit
        ORDER BY c.id_commande ASC
    ");
    
    // Compter le total des commandes
    $totalCommandes = $db->fetch("SELECT COUNT(*) AS total FROM commandes");
    $total = $totalCommandes ? (int)$totalCommandes['total'] : 0;
    
} catch (BridgeSQLException $e) {
    die("Erreur BridgeSQL : " . $e->getMessage());
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Commandes - BridgeSQL Demo</title>
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
            max-width: 1200px;
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
        
        .info-box {
            background: #e8f5e9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #4CAF50;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: 600;
        }
        
        td {
            background-color: #fff;
        }
        
        tr:nth-child(even) td {
            background-color: #f9f9f9;
        }
        
        tr:hover td {
            background-color: #f1f8e9;
        }
        
        tfoot th {
            background-color: #333;
            text-align: center;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: #45a049;
        }
        
        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .stat-box {
            background: #f0f0f0;
            padding: 15px;
            border-radius: 5px;
            flex: 1;
            margin: 0 10px;
            text-align: center;
        }
        
        .stat-box:first-child {
            margin-left: 0;
        }
        
        .stat-box:last-child {
            margin-right: 0;
        }
        
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📦 Liste des Commandes</h1>
        
        <div class="stats">
            <div class="stat-box">
                <div class="stat-number"><?= count($agents) ?></div>
                <div>Agents</div>
            </div>
            <div class="stat-box">
                <div class="stat-number"><?= $total ?></div>
                <div>Total Commandes</div>
            </div>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Noms</th>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix Payé</th>
                    <th>Date Payé</th>
                    <th>Date Livré</th>
                    <th>N° Facture</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($commandes)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 30px;">
                            Aucune commande trouvée.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($commandes as $commande): ?>
                        <tr>
                            <td><?= htmlspecialchars($commande['id_commande']) ?></td>
                            <td><?= htmlspecialchars($commande['noms']) ?></td>
                            <td><?= htmlspecialchars($commande['nom_produit']) ?></td>
                            <td><?= htmlspecialchars($commande['qte']) ?></td>
                            <td><?= number_format($commande['prix_paye'], 0, ',', ' ') ?> FC</td>
                            <td><?= htmlspecialchars($commande['date_paye'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($commande['date_livre'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($commande['num_facture'] ?? 'N/A') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="7">Total de commandes : <?= $total ?></th>
                    <th style="text-align: center;">
                        <a href="ajouter_commande.php" class="btn">➕ Ajouter</a>
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>

