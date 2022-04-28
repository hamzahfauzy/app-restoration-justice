<?php

$table = 'cases';
Page::set_title('Tambah Perkara');
$error_msg = get_flash_msg('error');
$old = get_flash_msg('old');

if(request() == 'POST')
{
    $conn = conn();
    $db   = new Database($conn);

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

    $insert = $db->insert($table,$data);

    $message = "Perkara dengan judul $insert->title telah di buat dengan nomor tiket C".$insert->id."-".strtotime($insert->created_at);
    $message .= "Silahkan lihat pembaharuan perkara di ".routeTo('cek-perkara');

    foreach($_POST['case_contacts'] as $key => $val)
    {
        $param = [];
        if($key == 'investigator')
        {
            $param = [
                'case_id' => $insert->id,
                'name' => $val['name'],
                'phone' => $val['phone'],
                'contact_as' => 'investigator',
            ];
        }
        else
        {
            $param = [
                'case_id' => $insert->id,
                'name' => $data[$key],
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
        Fonnte::send($param['phone'], $message);
    }

    set_flash_msg(['success'=>'Perkara berhasil ditambahkan']);
    header('location:'.routeTo('cases/index'));
}

return compact('table','error_msg','old');