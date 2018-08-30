<?php

namespace ChemLab\Http\Controllers\Admin;

use ChemLab\Http\Controllers\Controller;
use OwenIt\Auditing\Models\Audit;

class AuditsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:audits-show');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        dd(Audit::with('auditable', 'user')->first());

        return view('admin.index')->with(compact('count'));
    }
}
