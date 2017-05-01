<?php

namespace App\Core;


use App\Forum\Forum;
use App\User\Role;

class SelectInput {

    private $name;
    private $multiple;
    private $selected;
    private $allow_none;
    private $forum_options;
    private $role_options;
    private $permission_settings_options;
    private $selected_string = 'selected="selected"';

    /**
     * SelectInput constructor.
     */
    public function __construct()
    {
        $this->name = '';
        $this->multiple = false;
        $this->selected = null;
        $this->none = false;
        $this->forum_options = false;
        $this->role_options = false;
        $this->permission_settings_options = false;
    }

    /**
     * The name for the select field
     *
     * @param $name
     * @return $this
     */
    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * This method is called if the select field should be a multiple select
     *
     * @return $this
     */
    public function multiple()
    {
        $this->multiple = true;
        return $this;
    }

    /**
     * The default selected value
     * Can be both string or array depending on which method the select input is being built for
     *
     * If string, it must be the key.
     *
     * @param $name string|array
     * @return $this
     */
    public function selected($name = null)
    {
        $this->selected = $name;
        return $this;
    }

    /**
     * If the select input should have a "none" field
     *
     * @param bool|int|string $custom_string
     * @return $this
     */
    public function allowNone($custom_string = false)
    {
        $this->allow_none = $custom_string ?: trans('site.none');
        return $this;
    }

    /**
     * All forums in options to be used in a select form
     *
     * @return $this
     */
    public function forums()
    {
        $nodes = Forum::get()->toTree();
        $traverse = function ($categories, $prefix = '') use (&$traverse) {
            $option = '';
            foreach ($categories as $category) {
                $selected = $this->selected && $this->selected == $category->id ? $this->selected_string : '';
                $option .= "<option {$selected} value='{$category->id}'>" . PHP_EOL . $prefix . ' ' . $category->name . '</option> ';
                $option .= $traverse($category->children, $prefix . '&nbsp&nbsp&nbsp&nbsp');
            }
            return $option;
        };
        $this->forum_options = $traverse($nodes);
        return $this;
    }

    /**
     * All roles to be used in a select form
     *
     * @return $this
     */
    public function roles()
    {
        $roles = Role::getList();
        $this->role_options = $this->genericInputCreator($roles);
        return $this;
    }

    /**
     * Create a general input form for select options if there is an array
     *
     * @param $items
     * @return $this
     */
    public function genericInputCreator($items)
    {
        $selected = null;
        $input = '';
        foreach ($items as $key => $item) {
            if ($this->selected) {
                if (is_array($this->selected)) {
                    $selected = in_array($item, $this->selected) ? $this->selected_string : null;
                } else {
                    $selected = $this->selected === $key ? $this->selected_string : null;
                }
            }
            if (old($this->name) == $key) {
                $selected = $this->selected_string;
            }
            $input .= "<option {$selected} value='{$key}'>$item</option>";
        }
        return $input;
    }

    /**
     * Get all permission settings and put them in a nice select box which is grouped by the settings category.
     *
     * @return $this
     */
    public function permissionSettings()
    {
        $permission_groups = PermissionSettings::getCachedGroups();
        foreach ($permission_groups as $permission_group) {
            $this->permission_settings_options .= "<optgroup label='{$permission_group->name}'>";
            $this->permission_settings_options .= $this->genericInputCreator($permission_group->subPermissions->lists('name', 'id'));
            $this->permission_settings_options .= "</optgroup>";
        }
        return $this;
    }

    /**
     * Build a form using all the methods above that is chained.
     *
     * @return string
     */
    public function get()
    {
        if ($this->multiple) {
            $input = "<select multiple='multiple' name='{$this->name}[]' class='form-control'>";
        } else {
            $input = "<select name='{$this->name}' class='form-control'>";
        }
        $input .= $this->allow_none ? sprintf('<option value="0">%s</option>', $this->allow_none) : '';
        $input .= $this->forum_options ?: '';
        $input .= $this->role_options ?: '';
        $input .= $this->permission_settings_options ?: '';
        $input .= '</select>';
        return $input;
    }

}