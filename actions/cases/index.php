<?php

$table = 'cases';
Page::set_title('Data Perkara');
$conn = conn();
$db   = new Database($conn);
$success_msg = get_flash_msg('success');

$user = auth()->user;

if(in_array(get_role($user->id)->name,['administrator','Admin Pusat']))
{
    $data = $db->all($table);
}

if(in_array(get_role($user->id)->name,['Admin','Admin Khusus']))
{
    $user_office = $db->single('user_office',[
        'user_id' => $user->id
    ]);

    $data = $db->all($table,[
        'office_id' => $user_office->office_id
    ]);
}

return [
    'datas' => $data,
    'table' => $table,
    'success_msg' => $success_msg
];