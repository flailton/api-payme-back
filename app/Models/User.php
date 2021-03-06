<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'document',
        'user_type_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
        'email_verified_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The wallets that belong to the user.
     */
    public function wallets()
    {
        return $this->belongsToMany(Wallet::class, 'user_wallet', 'wallet_id', 'user_id');
    }

    /**
     * The wallets that belong to the user.
     */
    public function user_type()
    {
        return $this->belongsTo(UserType::class);
    }

    /**
     * The payers transference that belong to the user.
     */
    public function payments()
    {
        return $this->belongsToMany(Transference::class, 'payer_transference', 'transference_id', 'user_id');
    }

    /**
     * The payees transference that belong to the user.
     */
    public function receiptments()
    {
        return $this->belongsToMany(Transference::class, 'payee_transference', 'transference_id', 'user_id');
    }

    /**
     * The payees transference that belong to the user.
     */
    public function ableTransference()
    {
        return $this->user_type_id === Config::get('constants.common_user.id');;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function rules()
    {
        return [
            'name' => 'required|min:2|max:80',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'document' => 'required|min:11|max:14|unique:users,document,' . $this->id,
            'password' => 'required|min:4|max:32',
            'user_type_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome ?? obrigat??rio!',
            'name.min' => 'O nome deve ter, pelo menos, 2 caracteres!',
            'name.max' => 'O nome deve ter, no m??ximo, 80 caracteres!',

            'email.required' => 'O campo e-mail ?? obrigat??rio!',
            'email.email' => 'O campo e-mail est?? fora do formato esperado!',
            'email.unique' => 'O e-mail informado j?? est?? cadastrado!',

            'document.required' => 'O campo e-mail ?? obrigat??rio!',
            'document.min' => 'Documento fora do formato esperado!',
            'document.max' => 'Documento fora do formato esperado!',
            'document.unique' => 'O documento informado j?? est?? cadastrado!',

            'user_type_id.required' => 'O tipo de usu??rio ?? obrigat??rio!',

            'password.required' => 'O campo senha ?? obrigat??rio!',
            'password.min' => 'A senha deve ter, pelo menos, 4 caracteres!',
            'password.max' => 'A senha deve ter, no m??ximo, 32 caracteres!'
        ];
    }
}
