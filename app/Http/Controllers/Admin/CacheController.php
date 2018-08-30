<?php

namespace ChemLab\Http\Controllers\Admin;

use ChemLab\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Prologue\Alerts\Facades\Alert;

class CacheController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cache-show')->only('index');
        $this->middleware('permission:cache-delete')->only('delete');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cache = [];

        if (Cache::has('chemical_search'))
            $cache['chemical-search'] = count(Cache::get('chemical_search'));
        if (Cache::has('brand_search'))
            $cache['brand-search'] = count(Cache::get('brand_search'));
        if (Cache::has('store_treeview'))
            $cache['store-treeview'] = count(Cache::get('store_treeview'));
        if (Cache::has('permission_search'))
            $cache['permission-search'] = count(Cache::get('permission_search'));
        if (Cache::has('role_search'))
            $cache['role-search'] = count(Cache::get('role_search'));
        if (Cache::has('user_search'))
            $cache['user-search'] = count(Cache::get('user_search'));
        if (Cache::has('team_search'))
            $cache['team-search'] = count(Cache::get('team_search'));

        return view('admin.cache.index')->with(compact('cache'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear()
    {
        Cache::flush();
        Alert::success(trans('cache.cleared'))->flash();
        return redirect(route('cache.index'));
    }
}
