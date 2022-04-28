<?php

$conn = conn();
$db   = new Database($conn);

$data = $db->single('case_contacts',[
    'id' => $_GET['id']
]);

$case = $db->single('cases',[
    'id' => $data->case_id
]);

$message = "Perkara dengan judul $case->title telah di buat dengan nomor tiket C".$case->id."-".strtotime($case->created_at).".";
$message .= " Silahkan lihat pembaharuan perkara di ".routeTo('cek-perkara');

Fonnte::send($data->phone, $message);
set_flash_msg(['success'=>'Notifikasi berhasil dikirim']);
header('location:'.routeTo('cases/view',['id'=>$case->id]));