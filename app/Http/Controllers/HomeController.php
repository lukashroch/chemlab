<?php namespace ChemLab\Http\Controllers;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => 'home']);
        $this->middleware('guest', ['only' => 'index']);
    }

    public function home()
    {
        return view('home');
    }

    public function index()
    {
        return redirect('home');
    }

    public function credits()
    {
        return view('credits');
    }
}
