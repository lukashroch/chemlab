<?php namespace ChemLab;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    public function getDisplayNameWithDesc()
    {
        return $this->description ? $this->display_name . ' (' . $this->description . ')' : $this->display_name;
    }
}
