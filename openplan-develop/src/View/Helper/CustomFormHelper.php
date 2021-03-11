<?php
namespace App\View\Helper;

use Cake\View\Helper\FormHelper;

/*
 *  Este helper se para las modificaciones de los input a mdbootstrap
 */

class CustomFormHelper extends FormHelper
{
    public function control($fieldName, array $options = [])
    {
        if (isset($options['type']) && $options['type'] == 'radio') {
            //modifica el input radio. Lo hace vertical u horizontal
            if (!empty($options['vertical'])) {
                $containerClass = 'btn-group-vertical';
                $labelClass = 'btn btn-primary no-margin';
            } else {
                $containerClass = 'btn-group-horizontal';
                $labelClass = 'btn btn-primary';
            }
            $radios = '';
            $titleClass = '';
            if (!empty($options['titleClass'])) {
                $titleClass = $options['titleClass'];
            }
            if (empty($options['label']) && !isset($options['label'])) {
                $radios .= "<div class='" . $titleClass . " col-12'><span>{$fieldName}</span></div>";
            } elseif (!empty($options['label'])) {
                $radios .= "<div class='" . $titleClass . "'><span>{$options['label']}</span></div>";
            }
            $radios .= '<div class="' . $containerClass . '" data-toggle="buttons">';
            $values = $options['options'];
            unset($options['options']);
            $options['hiddenField'] = false;
            //debido a como pinta cake los inputs, se tienen que pintar cada radio individual.
            foreach ($values as $key => $optionValue) {
                $options['templates'] = [
                    'inputContainer' => '{{content}}',
                    'nestingLabel' => '{{hidden}}<label {{attrs}} class="' . $labelClass . '">{{text}}{{input}}</label>',
                    'radioWrapper' => '{{label}}',
                ];
                if (isset($options['value']) && $optionValue == $options['value']) {
                    $options['templates']['nestingLabel'] = '{{hidden}}<label {{attrs}} class="' . $labelClass . ' active">{{text}}{{input}}</label>';
                    $options['checked'] = 'checked';
                } elseif (isset($options['checked'])) {
                    unset($options['checked']);
                }
                $options['label'] = false;
                $options['options'] = [$key => $optionValue];
                $radios .= parent::control($fieldName, $options);
                $options['hiddenField'] = false;
            }
            $radios .= '</div>';

            return $radios;
        } elseif (isset($options['multiple']) && $options['multiple'] == 'checkbox' || $options['type'] == 'checkbox') {
            if (empty($options['templates'])) {
                $options['templates'] = [
                    'inputContainer' => '<div class="form-group {{required}}">{{content}}</div>',
                    'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
                    'checkboxWrapper' => '<div class="form-group">{{label}}</div>'
                ];
            }
        }

        return parent::control($fieldName, $options);
    }

    public function control2($fieldName, array $options = [])
    {
        if (isset($options['type']) && $options['type'] == 'radio') {
            //modifica el input radio. Lo hace vertical u horizontal
            if (!empty($options['vertical'])) {
                $containerClass = 'btn-group-vertical';
                $labelClass = 'btn btn-primary no-margin';
            } else {
                $containerClass = 'btn-group-horizontal';
                $labelClass = 'btn btn-primary';
            }
            $radios = '';
            $titleClass = '';
            if (!empty($options['titleClass'])) {
                $titleClass = $options['titleClass'];
            }
            if (empty($options['label']) && !isset($options['label'])) {
                $radios .= "<div class='" . $titleClass . " col-12'><span>{$fieldName}</span></div>";
            } elseif (!empty($options['label'])) {
                $radios .= "<div class='" . $titleClass . "'><span>{$options['label']}</span></div>";
            }
            $radios .= '<div class="' . $containerClass . '" data-toggle="buttons">';
            $values = $options['options'];
            unset($options['options']);
            $options['hiddenField'] = false;
            //debido a como pinta cake los inputs, se tienen que pintar cada radio individual.
            foreach ($values as $key => $optionValue) {
                $options['templates'] = [
                    'inputContainer' => '{{content}}',
                    'nestingLabel' => '{{hidden}}<label {{attrs}} class="' . $labelClass . '">{{text}}{{input}}</label>',
                    'radioWrapper' => '{{label}}',
                ];
                if (isset($options['value']) && $optionValue == $options['value']) {
                    $options['templates']['nestingLabel'] = '{{hidden}}<label {{attrs}} class="' . $labelClass . ' active">{{text}}{{input}}</label>';
                    $options['checked'] = 'checked';
                } elseif (isset($options['checked'])) {
                    unset($options['checked']);
                }
                $options['label'] = false;
                $options['options'] = [$key => $optionValue];
                $radios .= parent::control($fieldName, $options);
                $options['hiddenField'] = false;
            }
            $radios .= '</div>';

            return $radios;
        } elseif (isset($options['multiple']) && $options['multiple'] == 'checkbox' || $options['type'] == 'checkbox') {
            if (empty($options['templates'])) {
                $options['templates'] = [
                    'inputContainer' => '<div class="form-group {{required}}">{{content}}</div>',
                    'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}></label>',
                    'checkboxWrapper' => '<div class="form-group">{{label}}</div>'
                ];
            }
        }

        return parent::control($fieldName, $options);
    }
    /* Mathias was here */

    public function input($fieldName, array $options = [], $is_control = 'control')
    {
        if ($is_control == 'control') {
            $this->setTemplates([
                'inputContainer' => '<div class="md-form {{required}}">{{content}}</div>',
                'inputContainerError' => '<div class="md-form {{required}}">{{content}}{{error}}</div>'
            ]);
            return parent::control($fieldName, $options);
        } else {
            $this->setTemplates([
                'textarea' => '<div class="md-form"><textarea name="{{name}}" class="md-textarea" {{attrs}}>{{value}}</textarea><label for="textarea-char-counter">' . $options['label'] . '</label></div>',
            ]);
            return parent::textarea($fieldName, $options);
        }
    }

    public function normalRadio($fieldName, $radioOptions = [], array $options = [], $inline = false)
    {
        if ($inline) { //Horizontal
            $this->setTemplates([
                'inputContainer' => '<div class="md-form {{required}}">{{content}}</div>',
                'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
                'radioWrapper' => '<div class="form-group btn-group-horizontal">{{label}}</div>',
            ]);
        } else {
            $this->setTemplates([
                'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
                'radioWrapper' => '<div class="form-group">{{label}}</div>',
            ]);
        }

        return parent::radio($fieldName, $radioOptions, $options);
    }

    public function customSubmit($caption, $options = [])
    {
        $this->setTemplates([
            'submitContainer' => '<div class="submit send-customer-data">{{content}}</div>'
        ]);

        return parent::submit($caption, $options);
    }
}
