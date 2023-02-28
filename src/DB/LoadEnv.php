
<?php
function load_dotenv() {
    $file_dir = "../.env";
    $env_file = file($file_dir) or die("Unable to open file!");
    foreach ($env_file as $line) {
        $line = trim($line);
        if (empty($line) || substr($line, 0, 1) === '#') {
            continue;
        }
        $comment_parts = explode("#", $line);
        $firstPart = (count($comment_parts) > 1) ? $comment_parts[0] : $line;
        $value_assign = explode("=", $firstPart, 2);
        # trim whitespace off of key
        $key = trim($value_assign[0]);
        if (count($value_assign) == 2) {
            # trim whitespace and quotes off of value
            $val = trim($value_assign[1], " \t\n\r\0\x0B\"\'");
        } else {
            $val = "";
        }
        $_ENV[$key] = $val;
    }
}
