<?php
return array(
    'library'     => 'imagick',
    'upload_dir'  => 'uploads',
    'upload_path' => public_path() . '/uploads/',
    'quality'     => 85,
	
	'dimensions' => array(200,200,true,200),
        'thumb'  => array(100, 100, true,  80),
        'medium' => array(600, 400, false, 90),
);
?>