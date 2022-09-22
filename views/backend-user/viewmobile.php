<?php

if($model !== null){
    $data = array(
        'id' => $model[0]['id'],
        'divisi' => $model[0]['divisi'],
        'nama' => $model[0]['nama'],
        'nama_divisi' => $model[0]['nama_divisi'],
    );
    $user = array(
        'user' => $data,
        'hasil' => 'success'
    );
}else{
    $data = [];
    $user = array(
        'user' => $data,
        'hasil' => 'gagal'
    );
}

echo json_encode($user);
?>
