
<?php

if (isset($_POST['save'])) {
  $file = $_FILES['nice_file'];

  echo '<pre>';
  print_r($file);
  echo '</pre>';

  $filename = $file['name'];
  $fileTmpname = $file['tmp_name'];
  $fileSize = $file['size'];
  $fileError = $file['error'];
  $fileType = $file['type'];
  
  if ($fileError == UPLOAD_ERR_NO_FILE) {
    echo '<br>No file was uploaded';
  } else {
    $fileExt = explode('.', $filename);

    echo '<pre>';
    print_r($fileExt);
    echo '</pre>';

    $fileActualExt = strtolower(end($fileExt));

    echo '<br>$fileActualExt = ' . $fileActualExt;

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if (in_array($fileActualExt, $allowed)) {
      if($fileError === 0) {
        if ($fileSize < 1000000) {
          $filenameNew = str_replace('.', '_', uniqid('', true));
          $filenameNew .= '.'. $fileActualExt;
          $fileDestination = 'file_uploads/' . $filenameNew;

          $upload_status = move_uploaded_file($fileTmpname, $fileDestination);

          // success methods go here
          if (!$upload_status) {
            echo '<br>There was a server error uploading the file';
            die('<br>---------------------------------------');
          } else {
            echo '<br>FILE uploaded successfully!';
            echo '<br>LOCATION: ' . $fileDestination;
          }
        } else {
          echo '<br>Your file size is too large!!';
        }
      } else {
        echo '<br>There was an error uploading your file';
      }
    } else {
      echo '<br>You cannot upload files of this type';
    }
  }
}

?>
