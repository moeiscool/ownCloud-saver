<?php
//This file should be where the owncloud server is hosted.
//config
$server='http://localhost';
$tempDir=__DIR__.'/';
$url=$_GET['url'];
//check url
if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
    die('Not a valid URL');
}
if(substr($server,-1)=='/'){
    $server=trim($server, "/");
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
// upload it with curl
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$server.'/remote.php/webdav/'.$dir.$filename);
curl_setopt($ch, CURLOPT_USERPWD,$username.':'.$password);
curl_setopt($ch, CURLOPT_PUT, 1);

$fh_res = fopen($tempDir.$filename, 'r');

curl_setopt($ch, CURLOPT_INFILE, $fh_res);
curl_setopt($ch, CURLOPT_INFILESIZE, filesize($tempDir.$filename));
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE); // --data-binary

$curl_response_res = curl_exec ($ch);
fclose($fh_res);
echo $curl_response_res;
//delete file
unlink($tempDir.$filename);
?>