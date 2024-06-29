<?php

namespace App\Events;

use App\Models\CommercialPolicy;
use Illuminate\Queue\SerializesModels;

class CommercialPolicyUpdated
{
    use SerializesModels;

    public CommercialPolicy $commercialPolicy;

    /**
     * Create a new event instance.
     *
     * @param CommercialPolicy $commercialPolicy
     */
    public function __construct(CommercialPolicy $commercialPolicy)
    {
        $this->commercialPolicy = $commercialPolicy;
    }
}
