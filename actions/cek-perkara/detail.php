<?php

$table = 'cases';

$conn = conn();
$db   = new Database($conn);
$success_msg = get_flash_msg('success');
$error_msg = get_flash_msg('error');
$old = get_flash_msg('old');

$data = $db->single($table,[
    'id' => $_GET['id']
]);

$data->office = $db->single('offices',[
    'id' => $data->office_id
]);

$data->contacts = $db->all('case_contacts',[
    'case_id' => $data->id
]);

$data->schedules = $db->all('case_schedules',[
    'case_id' => $data->id
]);

$data->agreements = $db->all('case_agreements',[
    'case_id' => $data->id
]);

Page::set_title('Detail Perkara | '.$data->title);

return [
    'data' => $data,
    'success_msg' => $success_msg,
    'error_msg' => $error_msg,
    'old' => $old,
    'table' => $table
];