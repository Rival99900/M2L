<?php
require "credentials.php";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$sql = "
SELECT 
    m.idMateriel,
    m.nom,
    m.annee,
    m.details,
    t.libelle AS type,
    p.nom AS parent
FROM MATERIEL m
JOIN TYPEE t ON m.idType = t.idType
LEFT JOIN MATERIEL p ON m.idParent = p.idMateriel
ORDER BY m.idMateriel;
";

$stmt = $pdo->query($sql);
$materiels = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <title>Parc matériel</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 20px; }
        table { border-collapse: collapse; width: 100%; background: white; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #333; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        h1 { margin-bottom: 20px; }
    </style>
</head>
<body>

<h1>Liste du parc matériel</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Année</th>
        <th>Détails</th>
        <th>Type</th>
        <th>Appartient à</th>
    </tr>

    <?php foreach ($materiels as $m): ?>
    <tr>
        <td><?= $m['idMateriel'] ?></td>
        <td><?= $m['nom'] ?></td>
        <td><?= $m['annee'] ?></td>
        <td><?= $m['details'] ?></td>
        <td><?= $m['type'] ?></td>
        <td><?= $m['parent'] ?? '—' ?></td>
    </tr>
    <?php endforeach; ?>

</table>

</body>

</html>
