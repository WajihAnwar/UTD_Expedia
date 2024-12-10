<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    file_put_contents('cart.json', json_encode($data));
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
