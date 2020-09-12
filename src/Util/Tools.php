<?php
namespace App\Util;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class Tools
{
    public static function chaineAleatoire($nbcar, $oupc = false)
    {
        $chaine = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        if($oupc)
            $chaine = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        srand((double)microtime()*1000000);
        $variable='';
        for($i=0; $i<$nbcar; $i++) $variable .= $chaine[rand()%strlen($chaine)];
        return $variable;
    }
        
    public static function rmRecursive($path) {
        if (!file_exists($path)) {
            return false;
        }
        if (is_dir($path)) {
            $dir = dir($path);
            while (($file_in_dir = $dir->read()) !== false) {
                if ($file_in_dir == '.' or $file_in_dir == '..')
                    continue; // passage au tour de boucle suivant
                Tools::rmRecursive("$path/$file_in_dir");
            }
            $dir->close();
        } else {
            unlink($path);
        }
    }
    
    public static function copyFiles($src_dir, $dest_dir, $sym_link = false) {
        $fs = new Filesystem();
        if($fs->exists($src_dir)) {
            $fs->mkdir($dest_dir, 0755, true);
            $dir_iterator = new \RecursiveDirectoryIterator($src_dir, \RecursiveDirectoryIterator::SKIP_DOTS);
            $iterator = new \RecursiveIteratorIterator($dir_iterator, \RecursiveIteratorIterator::SELF_FIRST);
            foreach($iterator as $element){
               if($element->isDir()){
                    $fs->mkdir($dest_dir . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
               } else{
                    if(!$fs->exists($dest_dir . DIRECTORY_SEPARATOR . $iterator->getSubPathName()))
                        if($sym_link)
                            $fs->symlink($element, $dest_dir . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
                        else
                            $fs->copy($element, $dest_dir . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
               }
            }
        }
    }
    
    public static function copy($src_file, $dest_file, $sym_link = false) {
        $fs = new Filesystem();
        if($fs->exists($src_file)) {
            if($sym_link)
                $fs->symlink($src_file, $dest_file);
            else
                $fs->copy($src_file, $dest_file);
        }
    }
    
    public static function removeFile($file) {
        $fs = new Filesystem();
        if($fs->exists($file)) {
            $fs->remove($file);
            return true;
        }
        return false;
    }
    
    public static function removeFiles($ressources_path) {
        $fs = new Filesystem();

        if($fs->exists($ressources_path)) {
            $dir_iterator = new \RecursiveDirectoryIterator($ressources_path, \RecursiveDirectoryIterator::SKIP_DOTS);
            $iterator = new \RecursiveIteratorIterator($dir_iterator, \RecursiveIteratorIterator::SELF_FIRST);
            foreach($iterator as $element){
                if ($fs->exists($element) && !$element->isDir())
                    $fs->remove($element);
            }
            $fs->remove($ressources_path);
        }
    }
    
    public static function getFileExtension($fic){
        if(file_exists($fic)) {
            $fileType = exif_imagetype($fic);
            if($fileType==IMAGETYPE_GIF) 
                $extension='gif';
            elseif($fileType==IMAGETYPE_JPEG) 
                $extension='jpg';
            elseif($fileType==IMAGETYPE_PNG)
                $extension='png';
        } else {
            $extension = substr($fic, strrpos($fic, '.')+1);
        }
        return strtolower($extension);
	}
    
    public static function vire_ponctuation($str){
		$tab_ponct=array('.', ',','?','?',':','!','%',';','«','»');
		return str_replace($tab_ponct, '', $str);
	}
    
    public static function vire_accents($str) {
		$tab2replace=array('À','Á','Â','Ã','Ä','Å','à','á','â','ã','ä','å','Ò','Ó','Ô','Õ','Ö','Ø','ò','ó','ô','õ','ö','ø','È','É','Ê','Ë','è','é','ê','ë','Ç','ç','Ì','Í','Î','Ï','ì','í','î','ï','Ù','Ú','Û','Ü','ù','ú','û','ü','ÿ','Ñ','ñ', 'œ');
		$tab_replace=array('a','a','a','a','a','a','a','a','a','a','a','a','o','o','o','o','o','o','o','o','o','o','o','o','e','e','e','e','e','e','e','e','c','c','i','i','i','i','i','i','i','i','u','u','u','u','u','u','u','u','y','n','n', 'oe');
		return str_replace($tab2replace, $tab_replace, $str);
	}
	
    public static function nom_web($s, $sep="-"){
		if (trim($s) != ''){
			$s=str_replace('&','et', $s);
			$s=str_replace('+','plus', $s);
			$s=Tools::vire_ponctuation($s);

			$exclu=array('de', 'le', 'la', 'les', 'un', 'une', 'des', 'du', 'au', 'à', 'en', 'the', '.', 'l');

			$lettreok=" abcdefghijklmnopqrstuvwxyz0123456789";   

			/*$s=strtr(strtolower($s), "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");*/

			$tab2replace=array('À','Á','Â','Ã','Ä','Å','à','á','â','ã','ä','å','Ò','Ó','Ô','Õ','Ö','Ø','ò','ó','ô','õ','ö','ø','È','É','Ê','Ë','è','é','ê','ë','Ç','ç','Ì','Í','Î','Ï','ì','í','î','ï','Ù','Ú','Û','Ü','ù','ú','û','ü','ÿ','Ñ','ñ', 'œ');
			$tab_replace=array('a','a','a','a','a','a','a','a','a','a','a','a','o','o','o','o','o','o','o','o','o','o','o','o','e','e','e','e','e','e','e','e','c','c','i','i','i','i','i','i','i','i','u','u','u','u','u','u','u','u','y','n','n', 'oe');
			$s=str_replace($tab2replace, $tab_replace, $s);
			
			$s=strtolower($s);
			
			$r="";
            
            $s=str_replace('  ', ' ', $s);
            $s=str_replace('---', '-', $s);
            $s=str_replace('--', '-', $s);
            
			for ($i=0;$i<strlen($s);$i++) if (strpos($lettreok, $s[$i])>0) $r.=$s[$i]; else $r.=' ';
			
			$e1=explode(' ', $r);

			foreach($e1 as $v){
				if ($v<>'' and !in_array($v, $exclu)) $e2[]=$v;
			}
			
			if(count($e2)>0){
				return implode($sep,$e2);
			}else{
				return '';
			}
		}else{
			return '';
		}
	}
    
    static public function decode($string) {
		if (preg_match('!!u', $string))
		{
		   return utf8_decode($string);
		}
		else 
		{
		   return $string;
		}
	}
	
	static public function encode($string)
	{
		if (preg_match('!!u', $string))
		{
		   return $string;
		}
		else 
		{
		   return utf8_encode($string);
		}
	}
}

