<?php namespace App\Commands;

use App\Commands\Command;

class RemoveCustomer extends Command
{

    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

}
