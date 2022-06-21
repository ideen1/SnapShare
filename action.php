<?php
require("initialize.php");

if(checkLogin()){

   
} elseif($_GET['command'] == 'login' || $_GET['command'] == 'signup'){

} else{
    echo "<script>pageLogin();</script>";
    die();
}

switch($_GET['command']){

    case "new":

        if (empty($_POST['name'])){
            header("Location: index.php?spt=new");
        }
        

            //CASE FOR CREATING NEW EVENT
            $sql_string;
            $sql2_string;
            $sql3_string;


            $name = $_POST['name'];

            $invites = substr($_POST['people'], 1);
            $people = explode("-", $invites);

            foreach($people as $value){
                $sql_string = $sql_string . "Email = '$value' OR ";
            }
            $sql_string = substr($sql_string,0,-4);
            


            $sql = "SELECT * FROM Users Where $sql_string";

            $result = $conn->query($sql);




            $sql3_string = $sql3_string = "INSERT INTO InvitationToken (UserID, EventID, Token, Email) Values ";
            while($row = $result->fetch_assoc()){
                $sql2_string = $sql2_string . "-" . $row['UserID'];

                $token = generateID("TOKEN");

                $sql3_string = $sql3_string . "('$row[UserID]', '%s', '$token', '$row[Email]'),";

            $mail['email'] = $row['Email'];
            $mail['event'] = $_POST['name'];
            $mail['token'] = $token;
            $mail['creator'] = getName($userid);
            $mail['type'] = "invite";

            require("mail/sendmail.php");

            }

            $sql3_string = substr($sql3_string, 0, -1);
            
            

            $id = generateID("EVENT");

            $sql = "INSERT INTO Events (Name, EventID,  CreatingID, SharedID) Values('$name', '$id', '$userid', '$sql2_string' )";
            $result = $conn->query($sql);

            //$result = $conn->query(sprintf($sql3_string, $id));
            $result = $conn->query(str_replace("%s", $id, $sql3_string));

            mkdir("cdn/$id/");
            mkdir("cdn/$id-thumb/");


            



            echo "<script>pageEvent('$id')</script>";
        
        break;

    case "user":
        $id = generateID("USER");
        $sql = "INSERT INTO Users (Email, UserID) VALUES('$_GET[email]', '$id')";
        $result = $conn->query($sql);
       
    break;


    case "upload":
        
            //$files = array_filter($_FILES['upload']['name']); //something like that to be used before processing files.

            // Count # of uploaded files in array
            $total = count($_FILES['images']['name']);

            function make_thumb($src, $dest, $desired_width) {

                /* read the source image */
                $source_image = imagecreatefromjpeg($src);
                $width = imagesx($source_image);
                $height = imagesy($source_image);
                
                /* find the "desired height" of this thumbnail, relative to the desired width  */
                $desired_height = floor($height * ($desired_width / $width));
                
                /* create a new, "virtual" image */
                $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
                
                /* copy source image at a resized size */
                imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                
                /* create the physical thumbnail image to its destination */
                imagejpeg($virtual_image, $dest);
            }


            // Loop through each file
            for( $i=0 ; $i < $total ; $i++ ) {

                $filename = $_FILES['images']['name'][$i];

                $id = generateID("IMAGE");
                $username = getName($userid);

                $sql = "INSERT INTO Images (ImageID, URL, ThumbURL, UserID, EventID, ALT) 
                VALUES ('$id', 'cdn/$_POST[EventID]/$id-$filename', 'cdn/$_POST[EventID]-thumb/$id-$filename', 1, '$_POST[EventID]', '$filename-$username')";

                $result = $conn->query($sql);
                echo $conn->error;

            //Get the temp file path
            $tmpFilePath = $_FILES['images']['tmp_name'][$i];

            
            make_thumb($tmpFilePath, "cdn/$_POST[EventID]-thumb/$id-" . $filename, 300);



            //Make sure we have a file path
            if ($tmpFilePath != ""){
                //Setup our new file path
                $newFilePath = "cdn/$_POST[EventID]/$id-" . $filename;

                //Upload the file into the temp dir
                if(move_uploaded_file($tmpFilePath, $newFilePath)) {

                //Handle other code here

                }
            }
            }

            

            header("Location: index.php?spt=event&sptid=$_POST[EventID]");

    break;

    case "download":


        $sql = "SELECT * FROM Events WHERE EventID = '$_GET[ID]' AND (CreatingID = '$userid' OR concat('-',SharedID,'-') LIKE '%-$userid-%')";
        $result=$conn->query($sql);

        if($result->num_rows == 1){
            
            $row=$result->fetch_assoc();


        $dir = 'cdn/' . $row['EventID'] . "/";
        $zip_file = $row['Name'] . '.zip';
        
        // Get real path for our folder
        $rootPath = realpath($dir);
        
        // Initialize archive object
        $zip = new ZipArchive();
        $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        
        // Create recursive directory iterator
        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
        
        foreach ($files as $name => $file)
        {
            // Skip directories (they would be added automatically)
            if (!$file->isDir())
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);
        
                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }
        
        // Zip archive will be created only after closing object
        $zip->close();
        
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($zip_file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($zip_file));


        set_time_limit(0);
$file = @fopen($zip_file,"rb");
while(!feof($file))
{
	print(@fread($file, 1024*8));
	ob_flush();
	flush();
}
        



        } else{ echo "Unauthorized"; }
    break;

    case "login":
        $token = generateID("TOKEN");
        
    $sql = "SELECT * FROM Users WHERE Email = '$_POST[email]' AND Password = '$_POST[password]' AND Status = 1";
    $result=$conn->query($sql);

        if($result->num_rows == 1){

            $row=$result->fetch_assoc();

            $sql = "INSERT INTO Auth (TOKEN, UserID) Values('$token', '$row[UserID]')";

            $result=$conn->query($sql);

                
                    setcookie("activeSession", $token, time()+31556926);

                    if(!empty($_POST['forward'])){
                        header("Location: $_POST[forward]");

                    } else{
                        header("Location: index.php?spt=events&alert=LoggedIn");
                    }
                    
                
            
        } else{
            //Incorrect Login

            $sql = "SELECT * FROM Users WHERE Email = '$_POST[email]'";
            $result=$conn->query($sql);
            if($result->num_rows == 1){
                $row=$result->fetch_assoc();
                 if($row['Status'] == 0){
                     //Account not yet created
                     
                     header("Location: index.php?spt=signup&alert=NoAccount&invite=$_POST[token]");
                 } else{
                     //Invalid credentials
                     
                     header("Location: index.php?spt=login&alert=InvalidLogin");
                     
                 };

            }
            

        }
    
    break;

    case "signup":
        $token = generateID("TOKEN");
        
        $sql_check = "SELECT * FROM Users WHERE Email = '$_POST[email]'";
        $result=$conn->query($sql_check);
        if($result->num_rows == 1){

            $row=$result->fetch_assoc();
            if($row['Status'] == 0){

                $sql = "UPDATE Users SET Password = '$_POST[password]', FirstName = '$_POST[name]', Status = 1 WHERE Email = '$_POST[email]' AND Status = 0";
                        $result=$conn->query($sql);
                        
                        $sql = "SELECT * FROM Users WHERE Email = '$_POST[email]' AND Password = '$_POST[password]' ";
                        $result=$conn->query($sql);

                            if($result->num_rows == 1){

                                $row=$result->fetch_assoc();

                                $sql = "INSERT INTO Auth (TOKEN, UserID) Values('$token', '$row[UserID]')";

                                $result=$conn->query($sql);
                                
                                    
                                        setcookie("activeSession", $token, time()+31556926);

                                        if(!empty($_POST['forward'])){
                                            header("Location: $_POST[forward]");

                                        } else{
                                            header("Location: index.php?stp=events&alert=Signed");                     
                                        }
   
                            }

            } else{
                header("Location: index.php?spt=login&alert=AccountAlready&invite=$_POST[token]");
            }
        
        }


    
    
    break;

    
}