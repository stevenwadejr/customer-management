<?php namespace App\Commands;

use App\Commands\Command;

class UpdateCustomer extends Command
{

    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $phone;

    public function __construct(
        $id,
        $first_name,
        $last_name,
        $email = [],
        $phone = []
    ) {
        $this->id = $id;
        $this->firstName = $first_name;
        $this->lastName = $last_name;
        $this->email = $email;
        $this->phone = $phone;
    }

}
