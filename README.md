# ownCloud-saver
Saver button for OwnCloud

Set the config details in `saver.php`. The defaults for the `server address` and `temporary directory` for downloaded files are as follows. It is set to `localhost` because you should put this file on the server that has owncloud installed to minimize upload time.

```
$server='http://localhost';
$tempDir=__DIR__.'/';
$username='';
$password='';
```

then in your browser set `url` as the file URL you want to upload to your server.
```
http://yoursite/saver.php?url=http://somesite.com/file.mp4
```

To change the name on upload add the variable `name`.
```
http://yoursite/saver.php?url=http://somesite.com/file.mp4&name=customname.mp4
```

To change the save directory add `dir`.
```
http://yoursite/saver.php?url=http://somesite.com/file.mp4&name=customname.mp4&dir=somefolder/here/andhere/
```

To use a different `user` and `pass`.
```
http://yoursite/saver.php?url=http://somesite.com/file.mp4&name=customname.mp4&dir=somefolder/here/andhere/&user=moeiscool&pass=ilikecookies
```