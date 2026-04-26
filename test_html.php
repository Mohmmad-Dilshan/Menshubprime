<?php
$html = file_get_contents('http://localhost/Menshubprime/checkout?id=3');
if (strpos($html, '<footer') !== false) {
    file_put_contents('output_raw.txt', "FOOTER_FOUND\n" . substr($html, strpos($html, '<footer'), 500));
} else {
    file_put_contents('output_raw.txt', "NO_FOOTER_FOUND\n" . substr($html, -1000));
}
?>
