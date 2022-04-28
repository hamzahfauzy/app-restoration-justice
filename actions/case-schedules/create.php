<?php

$table = 'case_schedules';
Page::set_title('Tambah '.ucwords($table));
$error_msg = get_flash_msg('error');
$old = get_flash_msg('old');

if(request() == 'POST')
{
    $conn = conn();
    $db   = new Database($conn);

    $_POST['case_schedules']['case_id'] = $_GET['case_id'];

    Validation::run([
        'case_id' => ['required','exists:cases,id,'.$_GET['case_id']],
        'date' => ['required'],
        'place' => ['required']
    ],$_POST['case_schedules']);

    $insert = $db->insert($table,$_POST[$table]);

    set_flash_msg(['success'=>'Jadwal berhasil ditambahkan']);
    header('location:'.routeTo('cases/view',['id' => $insert->case_id]));
    die();
}

return compact('table','error_msg','old');