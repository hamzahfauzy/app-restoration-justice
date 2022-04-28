<?php

$table = 'case_agreements';
$conn = conn();
$db   = new Database($conn);

$data = $db->single($table,[
    'id' => $_GET['id']
]);

$db->delete($table,[
    'id' => $_GET['id']
]);

set_flash_msg(['success'=>'Persetujuan berhasil dihapus']);
header('location:'.routeTo('cases/view',['id'=>$data->case_id,'page'=>'agreements']));
die();