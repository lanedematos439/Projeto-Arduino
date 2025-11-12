<?php
header("Access-Control-Allow-Origin: *"); // permite que o Arduino acesse

$d1 = $_GET['d1'] ?? null;
$d2 = $_GET['d2'] ?? null;

if ($d1 !== null && $d2 !== null) {
    $data = [
        "hora" => date("H:i:s"),
        "d1" => (int)$d1,
        "d2" => (int)$d2
    ];

    // Lê os dados anteriores
    $file = 'dados.json';
    $jsonData = [];
    if (file_exists($file)) {
        $jsonData = json_decode(file_get_contents($file), true);
    }

    // Mantém no máximo 30 registros para não pesar
    $jsonData[] = $data;
    if (count($jsonData) > 30) array_shift($jsonData);

    // Salva novamente
    file_put_contents($file, json_encode($jsonData, JSON_PRETTY_PRINT));
    echo "OK";
} else {
    echo "Erro: parâmetros inválidos.";
}
?>
