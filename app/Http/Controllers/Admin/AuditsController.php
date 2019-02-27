<?php

namespace ChemLab\Http\Controllers\Admin;

use ChemLab\DataTables\AuditsDataTable;
use ChemLab\Http\Controllers\Controller;
use OwenIt\Auditing\Models\Audit;

class AuditsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:audits-show');
    }

    /**
     * Display a listing of the resource
     *
     * @param \ChemLab\DataTables\AuditsDataTable $table
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(AuditsDataTable $table)
    {
        return $table->render('admin.audits.index');
    }

    /**
     * Create new resource in storage
     *
     * @param Audit $audit
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Audit $audit)
    {
        return view('audits.show', compact('audit'));
    }
}
