<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
class Register extends Component
{
	public $name;
	public $email;
	public $password;
	//public $password_confirmation;
	public $form = [
		'name' => '',
		'email' => '',
		'password' => '',
		// 'password_confirmation' => '',
	];
	public function submit()
	{
		$this->validate([
			'form.name'=>'required',
			'form.email'=>'required|email',
			'form.password'=>'required',
			// 'form.password_confirmation'=>'required',
		]);
		User::create($this->form);
		return redirect(route('login'));
		//dd($this->form);
	}
    public function render()
    {
        return view('livewire.register');
    }
}
