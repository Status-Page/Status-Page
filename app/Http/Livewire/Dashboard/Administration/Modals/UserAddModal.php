<?php

namespace App\Http\Livewire\Dashboard\Administration\Modals;

use App\Actions\Fortify\PasswordValidationRules;
use App\Events\ActionLog;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UserAddModal extends Component
{
    use PasswordValidationRules;

    public bool $modal = false;
    public User $user;
    public string $password = '';
    public string $email = '';
    public string $role = 'reporter';
    protected array $rules;

    public function __construct($id = null)
    {
        $this->rules = [
            'user.name' => 'required|string|min:3|max:255',
            'email' => ['required', 'email', 'min:0', 'max:255', Rule::unique('users')],
            'password' => $this->consolePasswordRules(),
            'user.deactivated' => 'boolean',
            'role' => 'required|string',
        ];

        parent::__construct($id);
    }

    public function render()
    {
        return view('livewire.dashboard.administration.modals.user-add-modal');
    }

    public function start(){
        $this->user = new User();
        $this->user->deactivated = false;

        $this->modal = true;
    }

    public function save(){
        $this->validate();

        $this->user->email = $this->email;
        $this->user->password = Hash::make($this->password);

        $this->user->save();

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
