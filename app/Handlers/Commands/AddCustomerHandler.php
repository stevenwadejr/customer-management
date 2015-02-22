<?php namespace App\Handlers\Commands;

use App\Commands\AddCustomer;
use App\Customer;
use App\Phone;
use App\Email;
use Illuminate\Database\DatabaseManager;
use Illuminate\Queue\InteractsWithQueue;

class AddCustomerHandler
{
    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * Handle the command.
     *
     * @param  AddCustomer  $command
     * @return void
     */
    public function handle(AddCustomer $command)
    {
        $this->databaseManager->beginTransaction();

        try {
            // Add Customer
            $customer = new Customer([
                'first_name' => $command->firstName,
                'last_name' => $command->lastName
            ]);

            $customer->save();

            // Add associations
            $emails = [];
            foreach ($command->email as $email) {
                $emails[] = new Email(['address' => $email]);
            }
            $customer->emails()->saveMany($emails);

            $phones = [];
            foreach ($command->phone as $phone) {
                $phones[] = new Phone(['number' => $phone]);
            }
            $customer->phones()->saveMany($phones);

            $this->databaseManager->commit();
        } catch (\Exception $e) {
            $this->databaseManager->rollback();
            throw $e;
        }
    }

}
