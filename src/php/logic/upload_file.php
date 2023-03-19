<?php

function is_image_type($file_type) {
    return $file_type == 'image';
}

function is_valid_extension($extension, $valid_extensions_arr) {
    return in_array($extension, $valid_extensions_arr);
}

function is_valid_image($file_info, $valid_extensions_arr) {
    $info_tuple = explode('/', strval($file_info), 2);
    $file_type = $info_tuple[0];
    $file_extension = $info_tuple[1];
    return is_image_type($file_type) && is_valid_extension($file_extension, $valid_extensions_arr);
}

function content_is_too_large() {
    return isset($_SERVER['CONTENT_LENGTH'])
            && (int) $_SERVER['CONTENT_LENGTH'] > 1024*1024*(3000000);
}

function upload_file($file_name) {
    $max_image_size = $_ENV['MAX_FILE_SIZE_BYTES'];

    $valid_extensions = "jpeg jpg png gif";
    $valid_file_exts = explode(' ', $valid_extensions);
    $upload_dir = '../../../' . $_ENV['USER_POST_IMAGE_DIR'] . '/';
    $type = $_FILES['attachment']['type'];  // e.g. "image/jpeg"
    $extension = explode('/', $type, 2)[1];  // e.g. "jpeg"
    // $uploaded_file = $upload_dir . basename($_FILES['attachment']['tmp_name']) . "." . $extension;
    $uploaded_file = $upload_dir . htmlspecialchars($file_name);

    echo '<pre>';
    if (!content_is_too_large()
        && is_valid_image($type, $valid_file_exts)
        && move_uploaded_file($_FILES['attachment']['tmp_name'], $uploaded_file)) {
        return $file_name;
    } else {
        return null;
    }
}

function upload_post_image() {
    $original_name = htmlspecialchars(basename($_FILES['attachment']['name']));
    return upload_file(strval(microtime(true)) . '-' . $original_name);
}
