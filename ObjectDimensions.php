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
     * Render a dimension including the unit (optional with the label)
     * Output the dimension only if it is higher than 0, otherwise output an empty string
     * @param string $dimension
     * @param bool $label
     * @return string
     */
    public function renderSingleDimension(string $dimension, bool $label = false):string {
        $label = $label ? InputfieldObjectDimensions::getLabels()[$dimension] . ': ' : '';
        $unit = ($this->unit) ? ' ' . $this->unit : '';
        return ($this->{$dimension}) ? $label . $this->{$dimension} . $unit : '';
    }

    /**
     * Render the width including unit and (optional) the label
     * @param bool $label
     * @return string
     */
    public function renderWidth(bool $label = false):string {
        return $this->renderSingleDimension('width', $label);
    }

    /**
     * Render the height including unit and (optional) the label
     * @param bool $label
     * @return string
     */
    public function renderHeight(bool $label = false):string {
        return $this->renderSingleDimension('height', $label);
    }

    /**
     * Render the length including unit and (optional) the label
     * @param bool $label
     * @return string
     */
    public function renderLength(bool $label = false):string {
        return $this->renderSingleDimension('length', $label);
    }

    /**
     * Render all dimensions as a string (fe 25cm * 10cm * 25cm)
     * @param bool $label
     * @param string $multiplicationSign - the sign for the multiplication
     * @return string
     */
    public function renderDimensions(bool $label = false, string $multiplicationSign = '*'):string {
        $label = $label ? InputfieldObjectDimensions::getLabels()['dimensions']. ': ' : '';

        $length = $this->renderLength() ?  $this->renderLength().' ('.$this->_('L').')' : '';
        $width = $this->renderWidth() ?  $this->renderWidth().' ('.$this->_('W').')' : '';
        $height = $this->renderHeight() ?  $this->renderHeight().' ('.$this->_('H').')' : '';

        $dimensions = array_filter([$length, $width, $height]);

        return $dimensions ? $label . implode(' '.$multiplicationSign.' ', $dimensions) : '';
    }

    /**
     * Render the volume (fe 25 cm³ or Volume: 25 cm³)
     *
     * @param bool $label
     * @return string
     */
    public function renderVolume(bool $label = false):string {
        $label = $label ? InputfieldObjectDimensions::getLabels()['volume']. ': ' : '';
        $unit = $this->unit ? ' ' . $this->unit . '<sup>3</sup>' : '';
        return ($this->volume > 0) ? $label . $this->volume . $unit : '';
    }

    /**
     * Render the area (fe 25 cm² or Area: 25 cm²)
     *
     * @param bool $label
     * @return string
     */
    public function renderArea(bool $label = false):string {
        $label = $label ? InputfieldObjectDimensions::getLabels()['area']. ': ' : '';
        $unit = ' ' . $this->unit . '<sup>2</sup>';
        return ($this->area > 0) ? $label . $this->area . $unit : '';
    }

    public function renderAllDimensions(bool $label = false, $mulitiplicationSign = '*'):string {

        $allDimensions = [
        $this->renderDimensions($label, $mulitiplicationSign),
        $this->renderArea($label),
        $this->renderVolume($label)
        ];
        $values = array_filter($allDimensions);
        $out = '';
        if($values){
            $out .= '<ul class="dimensions">';
            foreach($values as $value){
                $out .= '<li>'.$value.'</li>';
            }
            $out .= '</ul>';
        }
        return $out;
    }

    /**
     * @return string
     */
    public function __toString():string {
        return $this->renderAllDimensions(true);
    }

}
