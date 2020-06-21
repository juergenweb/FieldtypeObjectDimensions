<?php

namespace ProcessWire;
/**
 * Helper WireData Class to hold a dimension object
 *
 */
class ObjectDimensions extends WireData {

    protected $page;


    public function __construct() {
      try {
        $this->set('width', null);
        $this->set('height', null);
        $this->set('depth', null);
      }
      catch (WireException $e) {
      }
    }

    public function set($key, $value) {

        if($key == 'width' || $key == 'height' || $key == 'depth') {
            // if value isn't numeric, don't change the value if already
            // one set, else set it to 0 and throw an exception so it can be seen on API usage
            if(!is_numeric($value) && !is_null($value)) {
                $value = $this->$key ? $this->$key : 0;
                throw new WireException("Dimension Object only accepts numbers (float or integer) values");
            }
        }
        return parent::set($key, $value);
    }

    public function get($key) {
        return parent::get($key);

    }


    // for echo $field; directly
    public function __toString()
    {
        return $this->width.'*'.$this->height.'*'.$this->depth;
    }

}
