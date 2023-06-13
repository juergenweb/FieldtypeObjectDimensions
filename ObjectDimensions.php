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

        $this->set('length', 0.00);
        $this->set('width', 0.00);
        $this->set('height', 0.00);
        $this->set('volume', 0.00);
        $this->set('area', 0.00);
        $this->set('unit', 0.00);

    }

    /**
     * Render all dimensions as a string (fe 25cm * 10cm * 25cm)
     * @param bool $label - show the label (true) or not (false)
     * @param string $multiplicationSign - the sign for the multiplication (default is *)
     * @return string
     */
    public function renderDimensions(bool $label = false, string $multiplicationSign = '*'):string {

        $label = $label ? InputfieldObjectDimensions::getLabels()['dimensions'] . ': ' : '';

        $length = $this->length ? $this->length . ' (' . $this->_('L') . ')' : '';
        $width = $this->width ? $this->width . ' (' . $this->_('W') . ')' : '';
        $height = $this->height ? $this->height . ' (' . $this->_('H') . ')' : '';

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
            $this->renderDimensions(true, $multiplicationSign),
            $this->areaLabel,
            $this->volumeLabel
        ];
        $values = array_filter($allDimensions);
        $out = '';
        if ($values) {
            $out .= '<ul class="dimensions">';
            foreach ($values as $value) {
                $out .= '<li>' . $value . '</li>';
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
