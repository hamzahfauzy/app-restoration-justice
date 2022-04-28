<?php

$conn = conn();
$db   = new Database($conn);

$data = $db->single('case_agreements',[
    'id' => $_GET['id']
]);

$case = $db->single('cases',[
    'id' => $data->case_id
]);

$message = "Anda telah terdaftar sebagai pihak luar untuk membantu mediasi secara kekeluargaan";
$message .= "Silahkan klik link ini untuk memverifikasi ".routeTo('verifikasi',['token'=>$data->token]);
Fonnte::send($data->phone,$message);

set_flash_msg(['success'=>'Notifikasi berhasil dikirim']);
header('location:'.routeTo('cases/view',['id'=>$case->id]));