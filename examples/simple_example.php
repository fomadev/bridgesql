<?php
/**
 * Exemple simple d'utilisation de BridgeSQL
 */

require_once __DIR__ . '/../vendor/autoload.php';

use BridgeSQL\BridgeSQL;
use BridgeSQL\Exceptions\BridgeSQLException;

$config = require __DIR__ . '/config.php';

try {
    $db = new BridgeSQL($config);

    // Récupérer un utilisateur
    $user = $db->fetch("SELECT * FROM agents WHERE id = :id", ['id' => 2]);
    
    if ($user) {
        echo "Utilisateur trouvé : " . $user['prenom'] . " " . $user['nom'] . "\n";
    } else {
        echo "Aucun utilisateur trouvé.\n";
    }

} catch (BridgeSQLException $e) {
    echo "Erreur BridgeSQL : " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}

