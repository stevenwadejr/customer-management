<?php namespace App\Commands;

use App\Commands\Command;

class MergeCustomerProfiles extends Command
{
    public $customerId;
    public $duplicateIds;

    public function __construct($customerId, array $duplicateIds)
    {
        $this->customerId = $customerId;
        $this->duplicateIds = $duplicateIds;
    }

}
