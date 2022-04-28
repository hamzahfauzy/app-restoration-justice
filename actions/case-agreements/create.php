<?php

$table = 'case_agreements';
Page::set_title('Tambah '.ucwords($table));
$error_msg = get_flash_msg('error');
$old = get_flash_msg('old');

if(request() == 'POST')
{
    $conn = conn();
    $db   = new Database($conn);

    $_POST['case_agreements']['case_id'] = $_GET['case_id'];
    $_POST['case_agreements']['token']   = md5(strtotime('now').rand(1,10));

    Validation::run([
        'name' => ['required'],
        'phone' => ['required'],
        'agreement_as' => ['required']
    ],$_POST['case_agreements']);

    $insert = $db->insert($table,$_POST[$table]);

    $message = "Anda telah terdaftar sebagai pihak luar untuk membantu mediasi secara kekeluargaan";
    $message .= "Silahkan klik link ini untuk memverifikasi ".routeTo('verifikasi',['token'=>$_POST['case_agreements']['token']]);
    Fonnte::send($_POST['case_agreements']['phone'],$message);

    set_flash_msg(['success'=>'Persetujuan berhasil ditambahkan']);
    header('location:'.routeTo('cases/view',['id' => $insert->case_id,'page'=>'agreements']));
    die();
}

return compact('table','error_msg','old');