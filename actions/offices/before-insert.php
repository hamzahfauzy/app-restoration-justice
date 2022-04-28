<?php

$data = $_POST['offices'];
Validation::run([
    'name' => ['required']
], $data);