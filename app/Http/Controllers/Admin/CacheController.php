<?php

namespace ChemLab\Http\Controllers\Admin;

use ChemLab\Http\Controllers\Controller;
use Prologue\Alerts\Facades\Alert;

class CacheController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:cache');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cache = [];

        if (cache()->has('chemical-search'))
            $cache['chemical-search'] = count(cache()->get('chemical-search'));
        if (cache()->has('brand-search'))
            $cache['brand-search'] = count(cache()->get('brand-search'));
        if (cache()->has('store-treeview'))
            $cache['store-treeview'] = count(cache()->get('store-treeview'));
        if (cache()->has('permission-search'))
            $cache['permission-search'] = count(cache()->get('permission-search'));
        if (cache()->has('role-search'))
            $cache['role-search'] = count(cache()->get('role-search'));
        if (cache()->has('user-search'))
            $cache['user-search'] = count(cache()->get('user-search'));

        return view('admin.cache.index')->with(compact('cache'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cacheClear()
    {
        cache()->flush();
        Alert::success(trans('admin.cache.cleared'))->flash();
        return redirect('admin/cache');
    }
}
