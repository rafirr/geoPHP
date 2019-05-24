<?php
/**
 * MultiPolygon: A collection of Polygons
 */
class MultiPolygon extends Collection
{
  protected $geom_type = 'MultiPolygon';
  
  public function pointInPolygon($point,$c = false, $returnArea = false){

    $area_id = null;
    $hours = null;

    foreach($this->components as $component){
      $c = $component->pointInPolygon($point,$c);

      if($c && !$area_id){
        $area_id = $component->getSRID();
        $hours = $component->getHours();
      }
    }

    if(!$returnArea){
      return $c;
    }
    else{
      return (object) array('status' => $c, 'area_id' => $area_id, 'hours' => $hours);
    }
  }
}
