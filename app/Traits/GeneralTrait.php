<?php namespace App\Traits;

use Input;

trait GeneralTrait {

  public function emptyStringToNull($string){
    if(trim($string) === ''){
      $string = null;
    }
    return $string;
  }

  public function emptyStringToDash($string){
    if(trim($string) === ''){
      $string = '---';
    }
    return $string;
  }

  public function nullRequestToFalse($request){
    if($request == null){
      $status = false;
    }
    else{
      $status = true;
    }
    return $status;
  }

  public function fixWidthWords($string, $size){
    $string = str_pad(trim($string), $size);
    return $string;
  }

}
