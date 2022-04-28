<?php

$table = 'cases';
$conn = conn();
$db   = new Database($conn);
$error_msg = get_flash_msg('error');
$old = get_flash_msg('old');

if(get_role(auth()->user->id)->name == 'Admin')
{
    $user_office = $db->single('user_office',[
        'user_id' => auth()->user->id
    ]);

    Validation::run([
        'id' => ['required','exists:cases,id,'.$_GET['id'].',office_id,'.$user_office->office_id]
    ],[
        'id' => $_GET['id']
    ]);
}

$data = $db->single($table,[
    'id' => $_GET['id']
]);

if(request() == 'POST')
{

    $_POST[$table]['status'] = 'rejected';

    $edit = $db->update($table,$_POST[$table],[
        'id' => $_GET['id']
    ]);

    $contacts = $db->all('case_contacts',[
        'case_id' => $edit->id
    ]);

    $message = "Perkara dengan judul ".$edit->title." telah di tolak";
    foreach($contacts as $contact)
    {
        Fonnte::send($contact->phone, $message);
    }

    set_flash_msg(['success'=>'Perkara berhasil ditolak']);
    header('location:'.routeTo('cases/view',['id'=>$data->id]));
}

Page::set_title('Tolak Perkara | '.$data->title);

return [
    'data' => $data,
    'error_msg' => $error_msg,
    'old' => $old,
    'table' => $table
];