<?php
define("UPLOAD_DIR", "/var/www/fileuploder/files/tmp/");
//print_r($_POST);exit;
if(!empty($_FILES)) {
	if($_FILES['file']['name'])
	{
		$valid_file = TRUE;	
		if(!$_FILES['file']['error'])
		{
			$new_file_name = strtolower($_FILES['file']['tmp_name']); 
			if($_FILES['file']['size'] > (10024000)) 
			{
				$valid_file = false;
				$message = 'Oops!  Your file\'s size is to large.';
			}
		
			if($valid_file)
			{ 
				move_uploaded_file($_FILES['file']['tmp_name'], UPLOAD_DIR . $_FILES['file']['name']);
				$message = 'Congratulations!  Your file was accepted.';
			}
		}
		else
		{
			$message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
		}
	}
}

$servicetype = $_POST['servicetype'];
$message ="";
switch ($servicetype) {
	case 'facebook':
		$filename = $_POST['drivefileInfo'];
		$filepath = $_POST['drivefilepath'];
		//file_put_contents("files/tmp/facebook".$filename, fopen($filepath, 'r'));
		copy($filepath,"files/tmp/facebook".$filename);
		chmod("files/tmp/facebook".$filename	, 0777);  
		$message = 'Congratulations!  Your file was accepted.';
	 break;
		
	case 'dropbox':
		$filename = $_POST['drivefileInfo'];
		$filepath = $_POST['drivefilepath'];
		$filedata = file_get_contents($filepath);
		$doc = new DOMDocument();
		@$doc->loadHTML($filedata);
		$images = $doc->getElementsByTagName('a');
		$i =  0;	
      	foreach ($images as $image) {
        if ($image->getAttribute('id') == "default_content_download_button") { 
            $image_data = $image->getAttribute('href');
			file_put_contents("files/dropbox/".$filename, fopen($image_data, 'r'));
			chmod("files/dropbox/".$filename	, 0777);  
        }
      }
		$message = 'Congratulations!  Your file was accepted.';
	 break;

	case 'picasa':
		$filename = $_POST['drivefileInfo'];
		$filepath = $_POST['drivefilepath'];
		//file_put_contents("files/tmp/facebook".$filename, fopen($filepath, 'r'));
		copy($filepath,"files/picasa/".$filename);
		chmod("files/picasa/".$filename	, 0777);  
		$message = 'Congratulations!  Your file was accepted.';
	 break;

	case 'drive':
		$filename = $_POST['drivefileInfo'];
		$filepath = $_POST['drivefilepath'];
		$url ="https://docs.google.com/uc?id=".$filepath."&export=download";
		$file = $url;
		file_put_contents("files/drive/".$_POST['drivefileInfo'], fopen($file, 'r'));
		chmod("files/drive/".$filename	, 0777);  
		$message = 'Congratulations!  Your file was accepted.';
	 break;

	case 'box':
		$filename = $_POST['drivefileInfo'];
		$filepath = $_POST['drivefilepath'];
		copy($filepath,"files/boxdrive/".$filename);
		chmod("files/boxdrive/".$filename	, 0777);  
		$message = 'Congratulations!  Your file was accepted.';
	 break;

	case 'url':
		$filename = "test.pdf";
		$host = $_POST['drivefileInfo'];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $host);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, false);
		// curl_setopt($ch, CURLOPT_REFERER, "http://www.articnckalip.com/");
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$result = curl_exec($ch);
		curl_close($ch);
		$fp = fopen("files/url/".$filename, 'w');
		fwrite($fp, $result);
		fclose($fp);
		chmod("files/url/".$filename	, 0777);  
		$message = 'Congratulations!  Your file was accepted.';
	 break;

	case 'googleimage':
		$filename = $_POST['drivefileInfo'];
		$filepath = $_POST['drivefilepath'];
		copy($filepath,"files/googleimage/".$filename);
		chmod("files/googleimage/".$filename	, 0777);  
		$message = 'Congratulations!  Your file was accepted.';
	 break;

	case 'flickr':
		$filename = $_POST['drivefileInfo'];
		$filepath = $_POST['drivefilepath'];
		copy($filepath,"files/flickr/".$filename);
		chmod("files/flickr/".$filename	, 0777);  
		$message = 'Congratulations!  Your file was accepted.';
	 break;
}

echo $message;
print_r("Thanks For Your Submission");exit;
?>
