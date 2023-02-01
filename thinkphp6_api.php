<?php
/**
 * Created by PhpStorm.
 * User: 571247942@qq.com
 * Date: 2023/1/28
 * Time: 17:41
 */

namespace app\controller;

use app\BaseController;

class Api extends BaseController
{
    // 文字点阵 16 * 16
    public function charToBin(){
        $fontStr = input("str");
        $str = iconv("utf-8","GB2312//IGNORE", $fontStr);
        $fontFile = app()->getRootPath()."/hzk16s"; // 点阵字库文件名
        $fontWidth = 16;  // 单字宽度
        $fontHeight = 16; // 单字高度
        $start_offset = 0; // 偏移
        $fp = fopen($fontFile, "rb");
        $offsetSize = $fontWidth * $fontHeight / 8;
        $dotString = "";
        for ($i = 0; $i < strlen($str); $i++) {
            if (ord($str{$i}) > 160) {
                // 汉字 先求区位码,然后再计算其在区位码二维表中的位置,进而得出此字符在文件中的偏移
                $offset = ((ord($str{$i}) - 0xa1) * 94 + ord($str{$i + 1}) - 0xa1) * $offsetSize;
                $i ++;
            } else {
                // 非汉字
                $offset = (ord($str{$i}) + 156 - 1) * $offsetSize;
            }
            fseek($fp,$start_offset + $offset,SEEK_SET);  // 读取其点阵数据
            $binDot = fread($fp,$offsetSize);
            for ($j = 0; $j < $offsetSize; $j ++) {
                $dotString .= sprintf("%08b",ord($binDot{$j})); // 将二进制点阵数据转化为字符串
            }
        }
        fclose($fp);
        return json(["code"=>"success","res"=>$dotString]);
    }

    // 文字点阵 24 * 24
    public function charToBin24(){
//        $fontStr = input("str");
        $fontStr = "暖曦";
        $str = iconv("utf-8", "GB2312//IGNORE", $fontStr);
        $fontFile = app()->getRootPath() . "/HZK24S"; // 点阵字库文件名
        $fontWidth = 24;  // 单字宽度
        $fontHeight = 24; // 单字高
        $fp = fopen($fontFile, "rb");
        $offsetSize = $fontWidth * $fontHeight/8;
        $dotString = "";
        for ($i = 0; $i < strlen($str); $i++) {
            if (ord($str{$i}) > 160) {
                // 先求区位码,然后再计算其在区位码二维表中的位置,进而得出此字符在文件中的偏移
                $offset = ((ord($str{$i}) - 0xa1) * 94 + ord($str{$i + 1}) - 0xa1) * $offsetSize;
                $i++;
//                echo strlen($str)."汉字".$i."<br>";
            } else {

                $offset = (ord($str{$i}) + 156 - 1) * $offsetSize;
//              echo strlen($str)." 非汉字".$i."<br>";
            }
            // 读取其点阵数据
            fseek($fp, $offset, SEEK_SET);
            $bindot = fread($fp, $offsetSize);
            for ($j = 0; $j < $offsetSize; $j++) {
                // 将二进制点阵数据转化为字符串
                $dotString .= sprintf("%08b", ord($bindot{$j}));
            }
        }
        fclose($fp);
        return json(["code" => "success", "res" => $dotString]);
    }


    // 文字转点阵 点阵 12 * 12
   public function charToBin12(){
//        $str = input("str");
       $str = "中a";
       $str = iconv("utf-8", "GB2312//IGNORE", $str);
       $fontFile = app()->getRootPath() . "/simsun12.fon"; // 点阵字库文件名
       $fontWidth = 12;  // 单字宽度
       $fontHeight = 12; // 单字高
       $fp = fopen($fontFile, "rb");
       $offsetSize = $fontWidth * $fontHeight/8;
       $dotString = "";
       for ($i = 0; $i < strlen($str); $i++) {
           if (ord($str{$i}) > 160) {
               // 先求区位码,然后再计算其在区位码二维表中的位置,进而得出此字符在文件中的偏移
//                $offsetSize = $fontWidth * $fontHeight/8;
               $offset = ((ord($str{$i}) - 0xa1) * 94 + ord($str{$i + 1}) - 0xa1) * $offsetSize;
               $i++;
//                echo strlen($str)."汉字".$i."<br>";
           } else {

               $offset = (ord($str{$i}) + 156 - 1) * $offsetSize;
//              echo strlen($str)." 非汉字".$i."<br>";
           }
           // 读取其点阵数据
           fseek($fp, $offset, SEEK_SET);
           $bindot = fread($fp, $offsetSize);
           for ($j = 0; $j < $offsetSize; $j++) {
               // 将二进制点阵数据转化为字符串
               $dotString .= sprintf("%08b", ord($bindot{$j}));
           }
       }
       fclose($fp);
       return json(["code" => "success", "res" => $dotString]);
   }
    
}
