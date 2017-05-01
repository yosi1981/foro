<?php

namespace App\Core;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {

    public $timestamps = false;

    /**
     * Since the type can be a select field with many different arguments inside,
     * this method checks if the field as "select" inside and returns 'select' if it does.
     * If not, it returns the original type. This is so that the view can be simply called.
     *
     * @return mixed|string
     */
    public function getSettingTypeAttribute()
    {
        return str_contains($this->type, 'select') ? 'select' : $this->type;
    }

    /**
     * A setting's type can be set to select input,
     * so this method converts the string to array of options to be used in select input
     * @return array
     */
    public function getSelectOptionsAttribute()
    {
        $options = str_replace('select:', '', $this->type);
        return explode('|', $options);
    }

    /**
     * The validation rules for each type of settings
     * @return string
     */
    public function validationRules()
    {
        switch ($this->settingType) {
            case 'yesno':
                $rules = 'numeric';
                break;
            case 'number':
                $rules = 'numeric';
                break;
            case 'select':
                $rules = 'in:' . implode(',', $this->selectOptions);
                break;
        }
        if (isset($rules)) {
            return "required|{$rules}";
        }
        return 'required';
    }
}
