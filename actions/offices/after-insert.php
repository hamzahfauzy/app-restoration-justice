<?php

set_flash_msg(['success'=>'Data Kantor berhasil ditambahkan']);
header('location:'.routeTo('offices/index'));
die();