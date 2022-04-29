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

$data->contacts = $db->all('case_contacts',[
    'case_id' => $data->id
]);

if(request() == 'POST')
{

    $data = $_POST[$table];
    $contact = $_POST['case_contacts'];

    if(get_role(auth()->user->id)->name == 'Admin')
    {
        $user_office = $db->single('user_office',[
            'user_id' => auth()->user->id
        ]);

        $data['office_id'] = $user_office->office_id;
    }

    Validation::run([
        'office_id' => ['required','exists:offices,id,'.$data['office_id']],
        'title' => ['required'],
        'date' => ['required'],
        'location' => ['required'],
        'reporter' => ['required'],
        'reported' => ['required'],
        'description' => ['required'],
        'loss' => ['required'],
        'wa_reporter' => ['required','number'],
        'wa_reported' => ['required','number'],
        'investigator_name' => ['required'],
        'investigator_phone' => ['required','number'],
    ], array_merge($data, [
        'wa_reporter' => $contact['reporter'],
        'wa_reported' => $contact['reported'],
        'investigator_name' => $contact['investigator']['name'],
        'investigator_phone' => $contact['investigator']['phone']
    ]));

    if(isset($_FILES['file_url']) && !empty($_FILES['file_url']['name']))
    {
        $ext  = pathinfo($_FILES['file_url']['name'], PATHINFO_EXTENSION);
        $name = strtotime('now').'.'.$ext;
        $file = 'uploads/documents/'.$name;
        copy($_FILES['file_url']['tmp_name'],$file);
        $data['file_url'] = $file;
    }

    $data['user_id'] = auth()->user->id;

    $edit = $db->update($table,$data,[
        'id' => $_GET['id']
    ]);

    $db->delete('case_contacts',[
        'case_id' => $edit->id
    ]);

    foreach($_POST['case_contacts'] as $key => $val)
    {
        $param = [];
        if($key == 'investigator')
        {
            $param = [
                'case_id' => $edit->id,
                'name' => $val['name'],
                'phone' => $val['phone'],
                'contact_as' => 'investigator',
            ];
        }
        else
        {
            $param = [
                'case_id' => $edit->id,
                'name' => $_POST[$table][$key],
                'phone' => $val,
                'contact_as' => $key,
            ];
        }

        // check user
        $user = $db->exists('users',[
            'username' => $param['phone']
        ]);

        if(!$user)
        {
            $db->insert('users',[
                'name' => $param['name'],
                'username' => $param['phone'],
                'password' => md5(strtotime('now')),
            ]);
        }

        $db->insert('case_contacts',$param);
    }

    set_flash_msg(['success'=>'Perkara berhasil diupdate']);
    header('location:'.routeTo('cases/index'));
}

Page::set_title('Edit Perkara | '.$data->title);

return [
    'data' => $data,
    'error_msg' => $error_msg,
    'old' => $old,
    'table' => $table
];