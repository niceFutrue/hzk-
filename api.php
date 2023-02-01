<?php
/**
 * 这个是例子，本人没测试过，但在thinkphp6_api.php 中仿写了该例子
 * @link  http://www.ugia.cn/?p=82
 */

$str = "你好世界";

$font_file_name   = "simsun12.fon"; 
$font_width       = 12;  
$font_height      = 12;  
$start_offset     = 0; 

$fp = fopen($font_file_name, "rb");
$offset_size = $font_width * $font_height / 8;
$string_size = $font_width * $font_height;
$dot_string  = "";

for ($i = 0; $i < strlen($str); $i ++){
    if (ord($str{$i}) > 160){
        $offset = ((ord($str{$i}) - 0xa1) * 94 + ord($str{$i + 1}) - 0xa1) * $offset_size;
        $i ++;
    } else{
        $offset = (ord($str{$i}) + 156 - 1) * $offset_size;        
    }
    fseek($fp, $start_offset + $offset, SEEK_SET);
    $bindot = fread($fp, $offset_size);
    for ($j = 0; $j < $offset_size; $j ++){
        $dot_string .= sprintf("%08b", ord($bindot{$j}));
    }
}
fclose($fp);
echo $dot_string;
?>
