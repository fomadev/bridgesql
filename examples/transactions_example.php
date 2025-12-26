<?php
/**
 * Exemple : Utilisation des transactions avec BridgeSQL
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BridgeSQL\BridgeSQL;
use BridgeSQL\Exceptions\BridgeSQLException;

$config = require __DIR__ . '/config.php';

try {
    $db = new BridgeSQL($config);
    
    echo "=== Exemple de Transactions avec BridgeSQL ===\n\n";
    
    // Démarrage d'une transaction
    $db->beginTransaction();
    echo "✓ Transaction démarrée\n";
    
    try {
        // Exemple : Transfert d'argent entre deux comptes
        // (Remplacez par vos propres tables si nécessaire)
        
        echo "Exécution des opérations...\n";
        
        // Opération 1 : Débiter le compte source
        // $db->execute("UPDATE accounts SET balance = balance - :amount WHERE id = :id", [
        //     'amount' => 100,
        //     'id'     => 1,
        // ]);
        // echo "✓ Compte 1 débité de 100\n";
        
        // Opération 2 : Créditer le compte destination
        // $db->execute("UPDATE accounts SET balance = balance + :amount WHERE id = :id", [
        //     'amount' => 100,
        //     'id'     => 2,
        // ]);
        // echo "✓ Compte 2 crédité de 100\n";
        
        // Validation de la transaction
        $db->commit();
        echo "✓ Transaction validée (commit)\n";
        
    } catch (BridgeSQLException $e) {
        // En cas d'erreur, annulation de la transaction
        $db->rollBack();
        echo "✗ Transaction annulée (rollback) : " . $e->getMessage() . "\n";
        throw $e;
    }
    
    echo "\n=== Transaction terminée avec succès ===\n";
    
} catch (BridgeSQLException $e) {
    echo "Erreur BridgeSQL : " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}

