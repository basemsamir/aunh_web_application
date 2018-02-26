<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\User;
use Auth;

class HomeComposer
{
    protected $user;

    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        $this->user = User::with('role')
                          ->where('id',Auth::id())
                          ->first(); 
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('user_role', $this->user->role->name);
    }
}