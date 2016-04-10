<?php namespace ChemLab\Http\Controllers;

use ChemLab\Http\Requests\UserRequest;
use ChemLab\Role;
use ChemLab\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Mail;

class UserController extends ResourceController
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $str = $request->input('search');
        $users = User::orderBy('name', 'asc')
            ->where('name', 'LIKE', "%" . $str . "%")
            ->orWhere('email', 'LIKE', "%" . $str . "%")
            ->paginate($request->user()->listing)
            ->appends($request->all());

        $action = $request->user()->can(['user-edit', 'user-delete']);

        return view('user.index')->with(compact('users', 'action'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('user.form')->with(['user' => new User()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return Response
     */
    public function store(UserRequest $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $password = Helper::generateKey();
        $user->password = bcrypt($password);

        $data = array('url' => URL::to('/'), 'name' => $user->name, 'email' => $user->email, 'password' => $password);
        \Mail::send('user.emails.new', $data, function ($message) use ($data) {
            $message->to($data['email'], $data['name'])->from(Config::get('mail.from.address'), Config::get('mail.from.name'))->subject('ChemLab: Váš nový účet');
        });
        $user->save();

        return redirect(route('user.edit', ['id' => $user->id]))->withFlashMessage(trans('user.msg.inserted', ['name' => $user->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return Response
     */
    public function show(User $user)
    {
        return view('user.show')->with(compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return Response
     */
    public function edit(User $user)
    {
        $roles = Role::whereNotIn('id', $user->roles->pluck('id'))->orderBy('name')->get();

        return view('user.form')->with(compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  User $user
     * @param UserRequest $request
     * @return Response
     */
    public function update(User $user, UserRequest $request)
    {
        $user->name = $request->input('name');
        $user->save();

        return redirect(route('user.index'))->withFlashMessage(trans('user.msg.updated', ['name' => $user->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        Session::flash('flash_message', trans('user.msg.deleted', ['name' => $user->name]));
        $user->delete();

        return response()->json(['state' => true, 'url' => route('user.index')]);
    }

    public function profile()
    {
        $user = Auth::user();

        return view('user.profile')->with(compact('user'));
    }

    public function password()
    {
        return view('user.password')->with(['user' => Auth::user()]);
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function passwordUpdate(Request $request)
    {
        $user = $request->user();

        if (!Auth::attempt(['email' => $user->email, 'password' => $request->input('password_current')]))
            return redirect()->back()->withInput()->withErrors([trans('user.password.current.no.match')]);

        $this->validate($request, ['password' => 'required|confirmed|min:6']);
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return redirect(route('user.profile'))->withFlashMessage(trans('user.password.changed'));
    }

}
