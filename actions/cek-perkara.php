<?php

$success_msg = get_flash_msg('success');
$error_msg = get_flash_msg('error');
$conn  = conn();
$db    = new Database($conn);

if(request() == 'POST')
{
    
    if(isset($_POST['get_otp']))
    {
        $user = $db->single('users',[
            'username' => $_POST['username']
        ]);
        
        if($user)
        {
            $token = $_POST['tiket'];
            $token = explode('-',$token);
            $id    = str_replace('C','',$token[0]);
            $time  = date('Y-m-d H:i:s', $token[1]);

            $case = $db->single('cases',[
                'id' => $id,
                'created_at' => $time
            ]);

            if($case)
            {
                $contact = $db->exists('case_contacts',[
                    'case_id' => $id,
                    'phone' => $user->username
                ]);

                if($contact)
                {
                    $otp = generateOTP();
                    $db->update('users',[
                        'password' => md5($otp),
                    ],[
                        'id' => $user->id
                    ]);

                    Fonnte::send($user->username, 'Kode OTP anda adalah '.$otp);
                    $_SESSION['otp']['username'] = $_POST['username'];
                    $_SESSION['otp']['case_id'] = $id;
                    header('location:'.routeTo('cek-perkara'));
                    die();
                }
            }

            set_flash_msg(['error'=>'Login Gagal! Nomor Tiket tidak ditemukan']);
            header('location:'.routeTo('cek-perkara'));
            die();
        }

        set_flash_msg(['error'=>'Login Gagal! Nomor WA tidak ditemukan']);
        header('location:'.routeTo('cek-perkara'));
        die();
    }

    if(isset($_POST['verify_otp']))
    {
        $user = $db->single('users',[
            'username' => $_SESSION['otp']['username'],
            'password' => md5($_POST['otp']),
        ]);

        if($user)
        {
            $db->update('users',[
                'password' => md5(strtotime('now')),
            ],[
                'id' => $user->id
            ]);

            $user->case_id = $_SESSION['otp']['case_id'];

            unset($_SESSION['otp']);
            $_SESSION['cek_perkara'] = $user;
            header('location:'.routeTo('cek-perkara'));
            die();
        }

        set_flash_msg(['error'=>'Login Gagal! OTP tidak valid']);
        header('location:'.routeTo('cek-perkara'));
        die();
    }
    
}

$auth = $_SESSION['cek_perkara']??false;
$cases = [];
if(isset($auth->id))
{
    $db->query = "SELECT * FROM cases WHERE id = $auth->case_id";

    $cases = $db->exec('all');

    $cases = array_map(function($case) use ($db, $auth){
        $case->contact = $db->single('case_contacts',[
            'case_id' => $case->id,
            'phone'   => $auth->username
        ]);
        $case->office = $db->single('offices',[
            'id' => $case->office_id
        ]);
        return $case;
    }, $cases);

}

return [
    'success_msg' => $success_msg,
    'error_msg' => $error_msg,
    'cases' => $cases,
];