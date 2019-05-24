<?php
/**
 * MultiPolygon: A collection of Polygons
 */
class MultiPolygon extends Collection
{
  protected $geom_type = 'MultiPolygon';
  
  public function pointInPolygon($point,$c = false, $returnArea = false){

    $area_id = null;

    foreach($this->components as $component){
      $c = $component->pointInPolygon($point,$c);

      if($c && !$area_id){
        $area_id = $component->getSRID();
      }
    }

    if(!$returnArea){
      return $c;
    }
    else{
      return (object) array('status' => $c, 'area_id' => $area_id);
    }
  }
}
