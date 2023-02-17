
<?php
function load_dotenv() {
    $file_dir = "../.env";
    $env_file = file($file_dir) or die("Unable to open file!");
    foreach ($env_file as $var_assign) {
        if (!empty($var_assign)) {
            $value_assign = explode("=", $var_assign);
            print_r($value_assign);
            $key = $value_assign[0];
            if (count($value_assign) == 2) {
                $val = $value_assign[1];
            } else {
                $val = "";
            }
            $_ENV[$key] = $val;
        }
    }
}
