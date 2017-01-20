<?php
//This file should be where the owncloud server is hosted.

//config
$username='';
$password='';
$url=$_GET['url'];

$server='http://localhost';
$tempDir=__DIR__.'/tmp/';
//filename
if(isset($_GET['name'])){
    $filename=$_GET['name'];
}else{
    $path=explode('/',explode('?',$url)[0]);
    $filename=$path[count($path)-1];
}
//filename
if(isset($_GET['dir'])){
    $dir=$_GET['dir'];
    //check to see if custom dir has trailing slash
    if(substr($dir,-1)!=='/'){
        $dir=$dir.'/';
    }
}else{
    $dir='';
}
//check url
if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
    die('Not a valid URL');
}
//make temp dir
if (!file_exists($tempDir)) {
    mkdir($tempDir, 0777, true);
}
//get file
$file = file_get_contents($url);
//set file in temp dir
file_put_contents($tempDir.$filename,$file);
// upload it
exec('curl -u '.$username.':'.$password.' --upload-file "'.$tempDir.$filename.'" "'.$server.'/remote.php/webdav/'.$dir.$filename.'"');
//delete file
unlink($tempDir.$filename);
?>