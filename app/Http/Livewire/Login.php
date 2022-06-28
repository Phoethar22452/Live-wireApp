<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class Login extends Component
{
	public $email;
	public $password;

	public $form = [
		'email' => '',
		'password' => '',
	];
	public function submit()
	{
		$this->validate([
			'form.email'=>'required|email',
			'form.password'=>'required',
		]);
		Auth::attempt($this->form);
		return redirect(route('home'));
	}
    public function render()
    {
        return view('livewire.login');
    }
}
