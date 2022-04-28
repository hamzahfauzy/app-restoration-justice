<?php

if(request() == 'POST')
{
    $conn  = conn();
    $db    = new Database($conn);

    // save application installation
    $db->insert('application',$_POST['app']);

    // create user login
    $_POST['users']['name'] = "Admin ".$_POST['app']['name'];
    $_POST['users']['password'] = md5($_POST['users']['password']);
    $user = $db->insert('users',$_POST['users']);

    // create roles
    $role = $db->insert('roles',[
        'name' => 'administrator'
    ]);

    // assign role to user
    $db->insert('user_roles',[
        'user_id' => $user->id,
        'role_id' => $role->id
    ]);

    // create roles route
    $role = $db->insert('role_routes',[
        'role_id' => $role->id,
        'route_path' => '*'
    ]);

    $roles = [
        'Admin Pusat' => [
            'default/*',
            'offices/index',
            'cases/index',
            'cases/schedules/*',
            'cases/agreements/*',
        ],
        'Admin' => [
            'default/*',
            'cases/index',
            'cases/view',
            'cases/create',
            'cases/edit',
            'cases/delete',
        ],
        'Admin Khusus' => [
            'default/*',
            'cases/index',
            'cases/view',
            'cases/reject',
            'cases/accept',
        ]
    ];

    foreach($roles as $role => $routes)
    {
        // create roles
        $_role = $db->insert('roles',[
            'name' => $role
        ]);
    
        foreach($routes as $route)
        {
            // create roles route
            $db->insert('role_routes',[
                'role_id' => $_role->id,
                'route_path' => $route
            ]);
        }
    }

    set_flash_msg(['success'=>'Instalasi Berhasil']);
    header('location:'.routeTo('auth/login'));
    die();

}