<?php

$table = 'case_schedules';
Page::set_title('Edit Jadwal');
$conn = conn();
$db   = new Database($conn);
$error_msg = get_flash_msg('error');
$old = get_flash_msg('old');

$data = $db->single($table,[
    'id' => $_GET['id']
]);

if(request() == 'POST')
{
    $edit = $db->update($table,$_POST[$table],[
        'id' => $_GET['id']
    ]);

    set_flash_msg(['success'=>'Jadwal berhasil diupdate']);
    header('location:'.routeTo('cases/view',['id'=>$edit->case_id]));
}

return [
    'data' => $data,
    'error_msg' => $error_msg,
    'old' => $old,
    'table' => $table
];