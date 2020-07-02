<?php

namespace ProcessWire;
/**
 * Helper WireData Class to hold a dimension object
 *
 */
class ObjectDimensions extends WireData {

    public function __construct() {
      parent::__construct();

      try {
        $this->set('width', null);
        $this->set('height', null);
        $this->set('depth', null);
        $this->set('volume', null);
        $this->set('area', null);
        $this->set('unit', null);
      }
      catch (WireException $e) {
      }
    }

    public function set($key, $value) {
        return parent::set($key, $value);
    }

    public function get($key) {
        return parent::get($key);
    }

    /**
    * Method to render all dimensions in a string like 25cm * 10cm * 25cm
    * @param string $multiplicator (the sign between the values)
    * @param bool $addUnit (adds fe cm after the value) true|false
    * @return string
    */
    public function renderDimensions(string $multiplicator = ' * ', bool $addUnit = true): string
    {
      $unit = $addUnit ? $this->unit : '';
      $width = $this->width ? $this->width.$unit : '';
      $height = $this->height ? $this->height.$unit : '';
      $depth = $this->depth ? $this->depth.$unit : '';
      $dimensions = array_filter([$width, $height, $depth]);
      return (count($dimensions)) ? implode($multiplicator, $dimensions) : '';
    }


    /**
    * Method to render the volume fe 25cm³
    * @param bool $addUnit (adds fe cm³ after the value) true|false
    * @return string
    */
    public function renderVolume(): string
    {
      $unit = $this->unit.'<sup>3</sup>';
      return ($this->volume > 0) ? $this->volume.$unit : '';
    }


    /**
    * Method to render the area fe 25cm²
    * @param bool $addUnit (adds fe cm² after the value) true|false
    * @return string
    */
    public function renderArea(bool $addUnit = true): string
    {
      $unit = $this->unit.'<sup>2</sup>';
      return ($this->area > 0) ? $this->area.$unit : '';
    }


    public function __toString()
    {
      return $this->renderDimensions();
    }

}
