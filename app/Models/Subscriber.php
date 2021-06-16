<?php

namespace App\Models;

use App\Events\Subscribers\SubscriberAdded;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Guid\Guid;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = ['verification_key', 'unsubscribe_key', 'manage_key'];

    protected $dispatchesEvents = [
        'created' => SubscriberAdded::class,
    ];

    public function generateVerificationKey(): string
    {
        $key = Guid::uuid4()->toString();
        $this->update(['verification_key' => Hash::make($key)]);
        return $key;
    }

    public function generateUnsubscribeKey(): string
    {
        $key = Guid::uuid4()->toString();
        $this->update(['unsubscribe_key' => $key]);
        return $key;
    }

    public function generateManageKey(): string
    {
        $key = Guid::uuid4()->toString();
        $this->update(['manage_key' => $key]);
        return $key;
    }

    public function getUnsubscribeKey(){
        return $this->unsubscribe_key;
    }

    public function verifyEmail() {
        $this->verification_key = null;
        $this->email_verified = true;
        $this->email_verified_at = Carbon::now();
        foreach (Component::all() as $component) {
            if($component->visibility){
                $this->components()->attach($component->id);
            }
        }
        return $this->save();
    }

    public function components() {
        return $this->belongsToMany(Component::class);
    }
}
