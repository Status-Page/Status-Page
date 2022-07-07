<?php

namespace App\Http\Livewire\Dashboard\Administration\Modals;

use App\Actions\Fortify\PasswordValidationRules;
use App\Events\ActionLog;
use App\Models\User;
use Auth;
use Hash;
use Livewire\Component;

class UserUpdateModal extends Component
{
    use PasswordValidationRules;

    public bool $modal = false;
    public User $user;
    public string $password = '';
    public string $role = '';
    protected array $rules;

    public function __construct($id = null)
    {
        $this->rules = [
            'user.name' => 'required|string|min:3|max:255',
            'user.email' => ['required', 'email', 'min:0', 'max:255'],
            'password' => $this->updatePasswordRules(),
            'user.deactivated' => 'boolean',
            'role' => 'required|string',
        ];

        parent::__construct($id);
    }

    public function render()
    {
        return view('livewire.dashboard.administration.modals.user-update-modal');
    }

    public function start(){
        $this->role = $this->user->getRoleNames()->first();

        $this->modal = true;
    }

    public function save(){
        $this->validate();

        if($this->password != ""){
            $this->user->password = Hash::make($this->password);
        }

        $this->user->save();

        $this->user->roles()->detach();
        $this->user->assignRole($this->role);

        ActionLog::dispatch(array(
            'user' => Auth::id(),
            'type' => 1,
            'message' => 'User '.$this->user->name.' (ID: '.$this->user->id.')',
        ));

        $this->modal = false;
        $this->emitUp('refreshData');
    }
}
