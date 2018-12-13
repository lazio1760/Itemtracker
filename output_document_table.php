<?php

$document = 'exportFile/document_list.csv';

$size = filesize($document);
$handle = fopen($document, 'rb');
$document_contents = fread($handle, $size);
fclose($handle);

//$document_contents_encoded = base64_encode($document_contents);

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=document_list.csv');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: $size');

/*
ob_start();
echo base64_decode($document_contents_encoded);
ob_flush();
*/

ob_start();
echo $document_contents;
ob_flush();


?>
