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
    $zone = null;

    foreach($this->components as $component){
      $c = $component->pointInPolygon($point,$c);

      if($c && !$area_id){
        $area_id = $component->getSRID();
        $hours = $component->getHours();
        $zone = $component->getZone();
      }
    }

    if(!$returnArea){
      return $c;
    }
    else{
      return (object) array('status' => $c, 'area_id' => $area_id, 'hours' => $hours, 'zone' => $zone);
    }
  }

  public function parsePolygons(){
    
    $data = [];
    
    foreach($this->components as $component){
      array_push($data, (object) array(
        'area_id' => $component->getSRID(),
        'zone' => $component->getZone(),
        'hours' => $component->getHours(),
      ));
    }

    return $data;
  }
}
