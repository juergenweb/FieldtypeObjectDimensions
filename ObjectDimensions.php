<?php
declare(strict_types=1);

namespace ProcessWire;

/**
 * Helper WireData Class to hold a dimension object
 *
 * Created by Jürgen K.
 * https://github.com/juergenweb
 * File name: FieldtypeObjectDimensions.module
 * Created: 02.02.2022
 */
class ObjectDimensions extends WireData {

    public function __construct() {

        parent::__construct();

        $this->set('length', null);
        $this->set('width', null);
        $this->set('height', null);
        $this->set('volume', null);
        $this->set('area', null);
        $this->set('unit', null);

    }

    /**
     * Render all dimensions as a string (fe 25cm * 10cm * 25cm)
     * @param bool $label - show the label (true) or not (false)
     * @param string $multiplicationSign - the sign for the multiplication (default is *)
     * @return string
     */
    public function renderDimensions(bool $label = false, string $multiplicationSign = '*'):string {

        $label = $label ? InputfieldObjectDimensions::getLabels()['dimensions'] . ': ' : '';
        // do not show zero values inside the string
        $length = ($this->lengthUnformatted != 0) != 0 ? $this->length . ' (' . $this->_('L') . ')' : '';
        $width = ($this->widthUnformatted != 0) ? $this->width . ' (' . $this->_('W') . ')' : '';
        $height = ($this->heightUnformatted != 0) ? $this->height . ' (' . $this->_('H') . ')' : '';

        $dimensions = array_filter([$length, $width, $height]);

        return $dimensions ? $label . implode(' ' . $multiplicationSign . ' ', $dimensions) : '';
    }

    /**
     * Render dimensions, area and volume as an unordered list
     * @param string $multiplicationSign
     * @return string
     */
    public function renderAll(string $multiplicationSign = '*'):string {

        $allDimensions = [
            'lwh' => $this->renderDimensions(true, $multiplicationSign),
            'area' => $this->areaLabel,
            'volume' => $this->volumeLabel
        ];
        // disable area if 0
        if($this->areaUnformatted == 0) {
            unset($allDimensions['area']);
        }
        // disable volume if 0
        if($this->volumeUnformatted == 0){
            unset($allDimensions['volume']);
        }
        
        // filter out 0 values on dimensions string
        $values = array_filter($allDimensions);

        $out = '';
        if ($values) {
            $out .= '<ul class="dimensions">';
            foreach ($values as $name => $value) {
                $out .= '<li class="'.$name.'">' . $value . '</li>';
            }
            $out .= '</ul>';
        }
        return $out;
    }

    /**
     * @return string
     */
    public function __toString():string {
        return $this->renderAll();
    }

}
