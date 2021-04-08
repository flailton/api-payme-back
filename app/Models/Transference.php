<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transference extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'transferenced_at'
    ];

    /**
     * The payers transference that belong to the user.
     */
    public function payers()
    {
        return $this->belongsToMany(User::class, 'payer_transference', 'transference_id', 'user_id');
    }

    /**
     * The payees transference that belong to the user.
     */
    public function payees()
    {
        return $this->belongsToMany(User::class, 'payee_transference', 'transference_id', 'user_id');
    }

    public function rules()
    {
        return [
            'value' => 'required',
            'payer' => 'required|exists:App\Models\User,id',
            'payee' => 'required|exists:App\Models\User,id'
        ];
    }

    public function messages()
    {
        return [
            'value.required' => 'O campo de valor é obrigatório!',

            'payer.required' => 'O campo pagador é obrigatório!',
            'payer.exists' => 'Usuário informado não existe!',

            'payee.required' => 'O campo beneficiário é obrigatório!',
            'payee.exists' => 'Usuário informado não existe!',
        ];
    }
}
