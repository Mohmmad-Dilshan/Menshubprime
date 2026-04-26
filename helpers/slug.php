<?php
function makeSlug($string){
  $string = strtolower($string);
  $string = preg_replace('/[^a-z0-9]+/','-',$string);
  return trim($string,'-');
}
?>