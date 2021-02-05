<?php

$targetFolder = $_SERVER['DOCUMENT_ROOT'].'/../soundclover/storage/app/public';
$linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage';

symlink($targetFolder, $linkFolder) or die("Error creating link");
echo "Symlink process successfully completed";
