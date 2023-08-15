<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class TemplateController
{
    /* we bring the main view of the controller */
    public function index()
    {

        include 'views/template.php';
    }

    /* Route Principal Or Domine from site */
    static public function path()
    {
        return "http://bersani.com/";
    }

    /* Controller save */
    static public function SavePrice($price, $offer, $type)
    {
        if ($type == "Discount") {
            $save = ($price * $offer) / 100;
            return  number_format($save, 2);
        } else if ($type == "Fixed") {
            $save = $price - $offer;
            return number_format($save, 2);
        }
    }

    /* Controller offer */
    static public function offerPrice($price, $offer, $type)
    {
        if ($type == "Discount") {
            $offerPrice = $price - ($price * $offer) / 100;
            return  round($offerPrice, 2);
        } else if ($type == "Fixed") {
            return round($offer, 2);
        }
    }

    /* Controller calificatio */
    static public function calificationStars($reviews)
    {

        if ($reviews != null) {
            $suma = 0;
            foreach ($reviews as $key => $value) {
                $suma += $value["review"];
            }
            $count = count($reviews);
            return round($suma / $count);
        } else {
            return 0;
        }
    }

    /* Controller offer */
    static public function percentOffer($price, $offer, $type)
    {
        if ($type == "Discount") {
            return $offer;
        } else if ($type == "Fixed") {
            return 100 - round(($offer * 100) / $price);
        }
    }

    /* funcion para mayuscula inicial */
    static public function capitalize($value)
    {
        $text = str_replace("_", " ", $value);
        return ucwords($text);
    }

    /* funcion para enviar correos electronicos */
    static public function sendEmail($name, $subject, $email, $message, $url, $post)
    {
        date_default_timezone_set("America/Mexico_City");
        $mail = new PHPMailer;
        $mail->Charset = "UTF-8";
        $mail->isMail();
        $mail->setFrom("roster_rtr@hotmail.com", "Seture Support"); //esto se debe cambiar en produccion
        $mail->Subyect = "Hola " . $name . " - " . $subject;
        $mail->addAddress($email);
        $mail->msgHTML('
            <div>
                Hola,' . $name . ':
                <p>' . $message . '</p>
                <a href="' . $url . '">Dale Click al link para: ' . $post . '</a>
                Si no deseas verificar tu email en Seture, favor de ignorar este mensaje.

                Gracias

                Su grupo Seture

            </div>
        ');
        $send = $mail->Send();
        if (!$send) {
            return $mail->ErrorInfo;
        } else {
            return "ok";
        }
    }

    // Funcion para almacear fotos
    static public function AlmacenPhoto($image, $folder, $path, $width, $heigt, $name)
    {
        if (isset($image["tmp_name"]) && !empty($image["tmp_name"])) {
            // configuramos la ruta de directorio donde se guarda la imagen 
            $directory = strtolower("views/" . $folder . "/" . $path);
            // preguntamos primero si existe el directorio, si no lo creamos
            if (!file_exists($directory)) {
                mkdir($directory, 0755);
            }
            // eliminar todos los archivos que existan en ese directorio
            if($folder != "img/stores" && $folder != "img/products"){
                $files = glob($directory . "/*");
                foreach ($files as $file) {
                    unlink($file);
                }
            }
            // captur ancho y alto original de la foto
            list($lastWidth, $lastHeight) = getimagesize($image["tmp_name"]);
            // de acuerdo l tipo de la imagen aplicams las funciones or defecto
            if ($image["type"] == "image/jpeg") {
                // nombre del archivo
                $newName = $name . '.jpg';
                // definimos el directorio a guardar el archivo
                $folderPath = $directory . "/" . $newName;
              
                if(isset($image["mode"]) && $image["mode"] == "base64"){
                    file_put_contents($folderPath, file_get_contents($image["tmp_name"]));
                }else{
                    // crear una copia de la imagen 
                    $start = imagecreatefromjpeg($image["tmp_name"]);
                    // intrucciones para aplicar a la imagen definitiva
                    $end = imagecreatetruecolor($width, $heigt);
                    imagecopyresized($end, $start, 0, 0, 0, 0, $width, $heigt, $lastWidth, $lastHeight);
                    imagejpeg($end, $folderPath);
                }
            } else if ($image["type"] == "image/png") {
                // nombre del archivo
                $newName = $name . '.png';
                // definimos el directorio a guardar el archivo
                $folderPath = $directory . "/" . $newName;
                if(isset($image["mode"]) && $image["mode"] == "base64"){
                    file_put_contents($folderPath, file_get_contents($image["tmp_name"]));
                }else{
                    // crear una copia de la imagen 
                    $start = imagecreatefrompng($image["tmp_name"]);
                    // intrucciones para aplicar a la imagen definitiva
                    $end = imagecreatetruecolor($width, $heigt);
                    imagealphablending($end, false);
                    imagesavealpha($end, true);
                    imagecopyresampled($end, $start, 0, 0, 0, 0, $width, $heigt, $lastWidth, $lastHeight);
                    imagepng($end, $folderPath);
                }
            }
            return $newName;
        } else {
            return "error";
        }
    }

    // funcion paralimpiar html
    static public function cleanhtml($code){
        $search = array('/\>[^\S ]+/s','/[^\S ]+\</s','/(\s)+/s');
        $repalce = array('>','<','\\1');
        $code = preg_replace($search, $repalce, $code);
        $code = str_replace("> <", "><", $code);
        return $code;
    }
}
