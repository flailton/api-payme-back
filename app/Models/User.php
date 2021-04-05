<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        return $this->belongsToMany(Wallet::class);
    }

    /**
     * The wallets that belong to the user.
     */
    public function user_type()
    {
        return $this->belongsTo(UserType::class);
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

    public function feedback()
    {
        return [
            'name.required' => 'O campo nome é obrigatório!',
            'name.min' => 'O nome deve ter, pelo menos, 2 caracteres!',
            'name.max' => 'O nome deve ter, no máximo, 80 caracteres!',

            'email.required' => 'O campo e-mail é obrigatório!',
            'email.email' => 'O campo e-mail está fora do formato esperado!',
            'email.unique' => 'O e-mail informado já está cadastrado!',

            'document.required' => 'O campo e-mail é obrigatório!',
            'document.min' => 'Documento fora do formato esperado!',
            'document.max' => 'Documento fora do formato esperado!',
            'document.unique' => 'O documento informado já está cadastrado!',

            'user_type_id.required' => 'O tipo de usuário é obrigatório!',

            'password.required' => 'O campo senha é obrigatório!',
            'password.min' => 'A senha deve ter, pelo menos, 4 caracteres!',
            'password.max' => 'A senha deve ter, no máximo, 32 caracteres!'
        ];
    }
}
