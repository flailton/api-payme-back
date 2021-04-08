<?php

namespace App\Repositories;

use App\Models\Transference;
use App\Interfaces\ITransferenceRepository;

class TransferenceRepository implements ITransferenceRepository
{
    public Transference $transference;
    
    public function __construct(Transference $transference) {
        $this->transference = $transference;
    }
    
    /**
     * Create a resource.
     *
     * @param  Array  $attributes
     * @return App\Models\Transference
     */
    public function show($id)
    {
        return $this->transference->find($id);
    }

    /**
     * Create a resource.
     *
     * @param  Array  $attributes
     * @return App\Models\Transference
     */
    public function store($attributes)
    {
        $this->transference = $this->transference->create($attributes);
        $this->transference->payers()->attach($attributes['payer']);
        $this->transference->payees()->attach($attributes['payee']);
        
        return $this->transference;
    }

    /**
     * Update the resource.
     *
     * @param  Array  $attributes
     * @return App\Models\Transference
     */
    public function update($attributes, $id)
    {
        $this->transference->update($attributes);
        return $this->transference;
    }

    /**
     * Get current resource.
     * 
     * @return App\Models\Transference
     */
    public function getTransference()
    {
        return $this->transference;
    }

}