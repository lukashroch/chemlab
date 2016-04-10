<?php

namespace ChemLab\Http\Controllers;

use ChemLab\Compound;
use ChemLab\Http\Requests\CompoundRequest;
use ChemLab\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CompoundController extends ResourceController
{
    protected $user;

    /**
     * CompoundController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->user = $request->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $str = Input::get('search');
        $compounds = Compound::select('compounds.*', 'users.name as owner_name')
            ->leftJoin('users', 'compounds.owner_id', '=', 'users.id')
            ->where(function ($query) {
                if (!$this->user->can('compound-show-all')) {
                    $query->where('compounds.owner_id', '=', $this->user->id);
                }
            })
            ->OfOwner(Input::get('owner'))
            ->where(function ($query) use ($str) {
                $query->where('compounds.id', 'LIKE', "%" . str_ireplace('k', '', $str) . "%");
                $query->orWhere('compounds.internal_id', 'LIKE', "%" . $str . "%");
                $query->orWhere('compounds.name', 'LIKE', "%" . $str . "%");
            })
            ->orderBy('id', 'asc')
            ->paginate($this->user->listing)
            ->appends(Input::All());

        $action = $this->user->can(['compound-edit', 'compound-delete']);

        if ($this->user->can('compound-show-all'))
            $owners = ['nd' => trans('compound.owner.unknown')] + User::SelectList();
        else
            $owners = [$this->user->id => $this->user->name];

        return view('compound.index')->with(compact('compounds', 'owners', 'action'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $compound = new Compound();
        $owners = User::SelectList();

        return view('compound.form')->with(compact('compound', 'owners'));
    }

    /**
     * Show the form for creating a new range of resources.
     *
     * @return Response
     */
    public function createReserve()
    {
        $compound = new Compound();
        $owners = User::SelectList();

        return view('compound.form')->with(compact('compound', 'owners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompoundRequest $request
     * @return Response
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
     * @param  Compound $compound
     * @return Response
     */
    public function show(Compound $compound)
    {
        return view('compound.show')->with(compact('compound'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Compound $compound
     * @return Response
     */
    public function edit(Compound $compound)
    {
        $owners = User::SelectList();
        return view('compound.form')->with(compact('compound', 'owners'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Compound $compound
     * @param CompoundRequest $request
     * @return Response
     */
    public function update(Compound $compound, CompoundRequest $request)
    {
        $compound->update($request->all());
        return redirect(route('compound.index'))->withFlashMessage(trans('compound.msg.updated', ['name' => $compound->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Compound $compound
     * @return Response
     */
    public function destroy(Compound $compound)
    {
        return response()->json([
            'state' => false,
            'alert' => ['type' => 'warning', 'str' => trans('compound.msg.deleted.disabled')]
        ]);
    }
}
