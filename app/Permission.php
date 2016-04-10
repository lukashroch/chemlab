<?php namespace ChemLab;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    use FlushModelCache;

    public function getDisplayNameWithDesc()
    {
        return $this->description ? $this->display_name . ' (' . $this->description . ')' : $this->display_name;
    }
}
