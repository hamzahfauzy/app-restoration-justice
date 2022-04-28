<?php

$table = 'cases';
$conn = conn();
$db   = new Database($conn);

$db->delete($table,[
    'id' => $_GET['id']
]);

set_flash_msg(['success'=>'Perkara berhasil dihapus']);
header('location:'.routeTo('cases/index'));
die();