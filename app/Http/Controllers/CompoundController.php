<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Compound;
use ChemLab\Http\Requests\CompoundRequest;
use ChemLab\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CompoundController extends ResourceController
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $str = $request->get('search');
        $compounds = Compound::select('compounds.*', 'users.name as owner_name')
            ->leftJoin('users', 'compounds.owner_id', '=', 'users.id')
            ->where(function ($query) use ($user) {
                if (!$user->can('compound-show-all')) {
                    $query->where('compounds.owner_id', '=', $user->id);
                }
            })
            ->OfOwner($request->get('owner'))
            ->where(function ($query) use ($user, $str) {
                $query->where('compounds.id', 'LIKE', "%" . str_ireplace('k', '', $str) . "%");
                $query->orWhere('compounds.internal_id', 'LIKE', "%" . $str . "%");
                $query->orWhere('compounds.name', 'LIKE', "%" . $str . "%");
            })
            ->orderBy('id', 'asc')
            ->paginate($user->listing)
            ->appends($request->all());

        $action = $user->can(['compound-edit', 'compound-delete']);

        if ($user->can('compound-show-all'))
            $owners = ['nd' => trans('compound.owner.unknown')] + User::SelectList();
        else
            $owners = [$user->id => $user->name];

        return view('compound.index', compact('compounds', 'owners', 'action'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $compound = new Compound();
        $owners = User::selectList();

        return view('compound.form', compact('compound', 'owners'));
    }

    /**
     * Show the form for creating a new range of resources.
     *
     * @return \Illuminate\View\View
     */
    public function createReserve()
    {
        $compound = new Compound();
        $owners = User::selectList();

        return view('compound.form', compact('compound', 'owners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompoundRequest $request
     * @return \Illuminate\View\View
     */
    public function store(CompoundRequest $request)
    {
        $compound = Compound::create($request->all());

        return redirect(route('compound.edit', ['id' => $compound->id]))->withFlashMessage(trans('compound.msg.inserted', ['name' => $compound->name]));
    }

    public function storeReserve(CompoundRequest $request)
    {
        $compound = Compound::create($request->all());

        return redirect(route('compound.edit', ['id' => $compound->id]))->withFlashMessage(trans('compound.msg.inserted', ['name' => $compound->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param Compound $compound
     * @return \Illuminate\View\View
     */
    public function show(Compound $compound)
    {
        $compound->load('owner');
        return view('compound.show', compact('compound'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Compound $compound
     * @return \Illuminate\View\View
     */
    public function edit(Compound $compound)
    {
        $owners = User::selectList();
        return view('compound.form', compact('compound', 'owners'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Compound $compound
     * @param CompoundRequest $request
     * @return \Illuminate\View\View
     */
    public function update(Compound $compound, CompoundRequest $request)
    {
        $compound->update($request->all());
        return redirect(route('compound.index'))->withFlashMessage(trans('compound.msg.updated', ['name' => $compound->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Compound $compound
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Compound $compound)
    {
        return response()->json([
            'type' => false,
            'alert' => ['type' => 'warning', 'text' => trans('compound.msg.deleted.disabled')]
        ]);
    }
}
