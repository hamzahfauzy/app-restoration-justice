<?php

$table = 'case_schedules';
Page::set_title('Selesaikan Jadwal');
$conn = conn();
$db   = new Database($conn);
$error_msg = get_flash_msg('error');
$old = get_flash_msg('old');

$data = $db->single($table,[
    'id' => $_GET['id']
]);

if(request() == 'POST')
{
    if(isset($_FILES['file_url']) && !empty($_FILES['file_url']['name']))
    {
        $ext  = pathinfo($_FILES['file_url']['name'], PATHINFO_EXTENSION);
        $name = strtotime('now').'.'.$ext;
        $file = 'uploads/documents/'.$name;
        copy($_FILES['file_url']['tmp_name'],$file);
        $_POST[$table]['file_url'] = $file;
    }

    $edit = $db->update($table,$_POST[$table],[
        'id' => $_GET['id']
    ]);

    $contacts = $db->all('case_contacts',[
        'case_id' => $edit->case_id
    ]);

    $status = $_POST[$table]['status'] == 'accepted' ? 'di terima' : 'di tolak';

    $message = "Perkara dengan judul ".$edit->title." telah di selesaikan dan ".$status;
    foreach($contacts as $contact)
    {
        Fonnte::send($contact->phone, $message);
    }

    set_flash_msg(['success'=>'Jadwal berhasil diselesaikan']);
    header('location:'.routeTo('cases/view',['id'=>$edit->case_id]));
}

return [
    'data' => $data,
    'error_msg' => $error_msg,
    'old' => $old,
    'table' => $table
];