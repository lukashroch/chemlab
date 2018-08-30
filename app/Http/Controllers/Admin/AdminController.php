<?php

namespace ChemLab\Http\Controllers\Admin;

use ChemLab\Brand;
use ChemLab\Chemical;
use ChemLab\Http\Controllers\Controller;
use ChemLab\Permission;
use ChemLab\Role;
use ChemLab\Store;
use ChemLab\Team;
use ChemLab\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $count['users'] = User::count();
        $count['roles'] = Role::count();
        $count['permissions'] = Permission::count();
        $count['teams'] = Team::count();
        $count['brands'] = Brand::count();
        $count['stores'] = Store::count();
        $count['chemicals'] = Chemical::count();

        return view('admin.index')->with(compact('count'));
    }
}
