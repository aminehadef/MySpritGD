<?php

class Sprit{
    private $images_name = [];
    private $mini_images_name = [];
    private $sprit_path = '';

    public function fusion($path){
        $i = 0;
        $destination = imagecreatefromjpeg($this->sprit_path);
        $largeur_destination = imagesx($destination);
        $hauteur_destination = imagesy($destination);
        
        foreach ($this->mini_images_name as $value) {
            $source = imagecreatefromjpeg("$path/$value");
           
            $largeur_source = imagesx($source);
            $hauteur_source = imagesy($source);
            
            imagecopymerge($destination, $source, $i, 0, 0, 0, $largeur_source, $hauteur_source, 100);
            imagejpeg($destination, $this->sprit_path);
            $i = $i + 50;
        }
    }

    public function create_img($path){
        header ("Content-type: image/jpeg");
        $image = imagecreate(count($this->mini_images_name) * 50,30);
        $colo = imagecolorallocate($image, 255, 255, 255);
        imagejpeg($image, "./$path/sprit.jpg");
        $this->sprit_path = "$path/sprit.jpg";
    }

    public function create_mini($path,$des){
        $this->images_name($path);

        foreach ($this->images_name as $value) {
            $source = imagecreatefromjpeg("$path/$value");
            $destination = imagecreatetruecolor(50,50);

            $source_x = imagesx($source);
            $source_y = imagesy($source);

            $destination_x = imagesx($destination);
            $destination_y = imagesy($destination);

            imagecopyresampled($destination, $source, 0, 0, 0, 0, $destination_x, $destination_y, $source_x,$source_y);
            imagejpeg($destination, "$des/$value");

        }

        $this->mini_images_name($des);
    }

    private function images_name($path){
        $dirname = opendir($path);
        while($file = readdir($dirname)) { 
                if($file != '.' && $file != '..') 
                { 
                    array_push($this->images_name,$file);
                } 
            }
        closedir($dirname); 
    }
    private function mini_images_name($path){
        $dirname = opendir($path);
        while($file = readdir($dirname)) { 
                if($file != '.' && $file != '..') 
                { 
                    array_push($this->mini_images_name,$file);
                } 
            }
        closedir($dirname); 
    }

}
$sp = new Sprit();
$sp->create_mini('./images', './spitimage');
$sp->create_img('./final');
$sp->fusion('./spitimage');