<?php namespace App\Commands;

use App\Commands\Command;

class AddCustomer extends Command
{

    public $firstName;
    public $lastName;
    public $email;
    public $phone;

    public function __construct(
        $first_name,
        $last_name,
        $email = [],
        $phone = []
    ) {
        $this->firstName = $first_name;
        $this->lastName = $last_name;
        $this->email = $email;
        $this->phone = $phone;
    }

}
