<?php

$conn = conn();
$db   = new Database($conn);
$success_msg = get_flash_msg('success');
$error_msg = get_flash_msg('error');
$old = get_flash_msg('old');

$data = $db->single('offices',[
    'id' => $_GET['id']
]);

$user_office = $db->all('user_office',[
    'office_id' => $data->id
]);

$user_office = array_map(function($d) use ($db) {
    $d->user = $db->single('users',[
        'id' => $d->user_id
    ]);
    return $d;
}, $user_office);

$data->users = $user_office;

$db->query = "SELECT *
FROM   users
WHERE  NOT EXISTS
  (SELECT *
   FROM   user_office
   WHERE  user_office.user_id = users.id)";

$users = $db->exec('all');

Page::set_title('Data Pengguna Kantor '.$data->name);

if(request() == 'POST')
{
    $db->insert('user_office',$_POST['user_office']);
    
    set_flash_msg(['success'=>'Data berhasil disimpan']);
    header('location:'.routeTo('offices/view',$_GET));
}

return [
    'data' => $data,
    'users' => $users,
    'success_msg' => $success_msg,
    'error_msg' => $error_msg,
    'old' => $old
];