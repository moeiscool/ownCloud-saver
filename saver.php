<?php
//This file should be where the owncloud server is hosted.

//config
$server='http://localhost';
$tempDir=__DIR__.'';
$url=$_GET['url'];
//check url
if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
    die('Not a valid URL');
}
//user
if(isset($_GET['user'])){
    $username=$_GET['user'];
}else{
    //set default username
    $username='';
}
//password
if(isset($_GET['pass'])){
    $password=$_GET['pass'];
}else{
    //set default password
    $password='';
}
////
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
//make temp dir
if (!file_exists($tempDir)) {
    mkdir($tempDir, 0777, true);
}
//get file
$file = file_get_contents($url);
//set file in temp dir
file_put_contents($tempDir.$filename,$file);
// upload it
echo exec('curl -u '.$username.':'.$password.' --upload-file "'.$tempDir.$filename.'" "'.$server.'/remote.php/webdav/'.$dir.$filename.'"');
//delete file
unlink($tempDir.$filename);
?>