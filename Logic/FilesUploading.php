<?php

function UploadFile($default) {
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/media/";
    $currentDate = date('Y-m-d-H-i-s');
    $ext = pathinfo(basename($_FILES["fileuploader"]["name"]), PATHINFO_EXTENSION);
    $fileName = $currentDate . '.' . $ext;
    $target_file = $target_dir . $fileName;
    if (move_uploaded_file($_FILES["fileuploader"]["tmp_name"], $target_file)) {
        return '/media/' . $fileName;
    } else {
        return $default;
    }
}

function UploadFile3($default) {
    echo $_FILES["fileuploader"];
    if (count($_FILES["fileuploader"]) > 0) {
        foreach ($_FILES["fileuploader"]["name"] as $key => $tmp_name) {
            $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/media/";
            $file_name = $_FILES["files"]["name"][$key];
            $file_tmp = $_FILES["files"]["tmp_name"][$key];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $currentDate = date('Y-m-d_H-i-s');

            if (!file_exists("media/" . $file_name)) {
                $newFileName = $file_name;
                move_uploaded_file($file_tmp = $_FILES["files"]["tmp_name"][$key], "media/" . $newFileName);
                return $base . $newFileName;
            } else {
                $filename = basename($file_name, $ext);
                $newFileName = $file_name;
                move_uploaded_file($file_tmp = $_FILES["files"]["tmp_name"][$key], "media/" . $newFileName);
                return $base . $newFileName;
            }
        }
    } else {
        return $default;
    }
}

function ConvertBase64ToImage($base64_string) {
    $target_dir = $_SERVER['DOCUMENT_ROOT'];
    $currentDate = date('Y-m-d_H-i-s');
    $fileName = "/Media/" . $currentDate;
    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>

    if (strpos($base64_string, 'data:image') === 0) {
        $data = explode(',', $base64_string);
        $ext = explode(';', $data[0]);
        $ext = explode('/', $ext[0]);
        $data = $data[1];
        $fileName = $fileName . '.' . $ext[1];
    } else {
        $data = $base64_string;
        $fileName = $fileName . '.png';
    }
    $target_dir = $target_dir . $fileName;
    // open the output file for writing
    $ifp = fopen($target_dir, 'wb');



    // we could add validation here with ensuring count( $data ) > 1
    fwrite($ifp, base64_decode($data));

    // clean up the file resource
    fclose($ifp);

    return $fileName;
}

?>