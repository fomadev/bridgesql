<?php
/**
 * Exemple d'utilisation de la méthode count()
 * 
 * Cette méthode simplifiée permet de compter facilement les résultats
 * sans avoir à écrire manuellement "SELECT COUNT(*)"
 * 
 * Version 1.0.4
 */

require_once __DIR__ . '/../src/BridgeSQL.php';
require_once __DIR__ . '/../src/Exceptions/BridgeSQLException.php';
$config = require __DIR__ . '/config.php';

use BridgeSQL\BridgeSQL;

try {
    // Initialisation de la connexion
    $db = new BridgeSQL($config);

    echo "<h1>Exemple d'utilisation de count()</h1>\n";

    // Exemple 1 : Compter toutes les lignes d'une table
    echo "<h2>1. Compter tous les demandeurs</h2>\n";
    $totaldemandeurs = $db->count("SELECT COUNT(*) FROM demandeurs");
    echo "Nombre total de demandeurs : <strong>$totaldemandeurs</strong><br><br>\n";

    // Exemple 2 : Compter avec condition WHERE
    echo "<h2>2. Compter les commandes d'un demandeur spécifique</h2>\n";
    $demandeurId = 1;
    $commandesCount = $db->count(
        "SELECT COUNT(*) FROM commandes WHERE id_demandeur = :id_demandeur",
        ['id_demandeur' => $demandeurId]
    );
    echo "Nombre de commandes du demandeur $demandeurId : <strong>$commandesCount</strong><br><br>\n";

    // Exemple 3 : Compter avec condition complexe
    echo "<h2>3. Compter les commandes complétées</h2>\n";
    $completedCount = $db->count(
        "SELECT COUNT(*) FROM commandes WHERE status = :status",
        ['status' => 'completed']
    );
    echo "Nombre de commandes complétées : <strong>$completedCount</strong><br><br>\n";

    // Exemple 4 : Comparaison avec la méthode fetch()
    echo "<h2>4. Comparaison avec fetch() (méthode traditionnelle)</h2>\n";
    
    // Avec count() - plus simple et lisible
    $count1 = $db->count("SELECT COUNT(*) FROM demandeurs");
    echo "Avec count() : <strong>$count1</strong><br>\n";
    
    // Avec fetch() - plus verbeux
    $result = $db->fetch("SELECT COUNT(*) as total FROM demandeurs");
    $count2 = $result['total'] ?? 0;
    echo "Avec fetch() : <strong>$count2</strong><br><br>\n";

    echo "<p style='color: green; margin-top: 20px;'><strong>✅ Version 1.0.4</strong> - Méthode count() disponible</p>\n";

} catch (Exception $e) {
    echo "Erreur : " . htmlspecialchars($e->getMessage()) . "\n";
}
?>
