<?php

function emptyStringToNull($value) {
  // change empty string value to null if necessary
  return ($value === '' ? 'NULL' : ('\'' . $value . '\''));
}

function emptyNumberToNull($value) {
  // change empty number to null if necessary
  return ($value === '' ? 'NULL' : $value);
}

function getFirstName($value) {
  // objective: extract firstname
  $value = trim($value);

  // list of all names
  $values = explode(' ', $value);

  $first_names = emptyStringToNull($values[0]);

  $last_name = emptyStringToNull(end($values));

  if ($first_names === $last_name) {
    return 'NULL';
  } else {
    $first_names = '';
    for ($i = 0; $i < count($values) - 1; $i++) {
      $first_names .= $values[$i] . ' ';
    }

    return emptyStringToNull(trim($first_names));
  }
}

function getSurname($value) {
  // extract surname
  $value = trim($value);
  $values = explode(' ', $value);

  $value = emptyStringToNull(end($values));

  return $value;
}

function addOrdinalNumberSuffix($num) {
  if (!in_array(($num % 100),array(11,12,13))){
    switch ($num % 10) {
      // Handle 1st, 2nd, 3rd
      case 1:  return $num.'st';
      case 2:  return $num.'nd';
      case 3:  return $num.'rd';
    }
  }
  return $num.'th';
}

function uploadDocument($file_ref, $loc) {
  // upload docouments
  $file = $_FILES[$file_ref];

  $filename = $file['name'];
  $fileTmpname = $file['tmp_name'];
  $fileSize = $file['size'];
  $fileError = $file['error'];
  $fileType = $file['type'];

  if ($fileError === UPLOAD_ERR_NO_FILE) {
    $value = 'NULL';
  } else {
    $fileExt = explode('.', $filename);

    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if (in_array($fileActualExt, $allowed)) {
      if($fileError === UPLOAD_ERR_OK) {
        $maxFileSize = 26214400;

        if ($fileSize <= $maxFileSize) {
          $filenameNew = str_replace('.', '_', uniqid('', true));
          $filenameNew .= '.'. $fileActualExt;
          $fileDestination = '\'' . $loc . '/' . $filenameNew . '\'';

          $upload_status = move_uploaded_file($fileTmpname, $fileDestination);

          // success methods go here
          if (!$upload_status) {
            $value = 'I/O FILE ERROR: server error occured while uploading file';
          } else {
            $value = $fileDestination;
          }
        } else {
          $value = 'FILE ERROR: File size is too large';
        }
      } else {
        $value = 'I/O FILE ERROR: system error occured while uploading file';
      }
    } else {
      $value = 'FILE ERROR: Invalid File Type.You cannot upload files of this type';
    }
  }

  return $value;
}
