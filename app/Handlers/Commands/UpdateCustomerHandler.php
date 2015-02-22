<?php namespace App\Handlers\Commands;

use App\Commands\UpdateCustomer;
use App\Customer;
use App\Email;
use App\Phone;
use App\Repositories\CustomerRepository;
use Illuminate\Database\DatabaseManager;
use Illuminate\Queue\InteractsWithQueue;

class UpdateCustomerHandler
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;
    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * Create the command handler.
     *
     * @return void
     */
    public function __construct(
        CustomerRepository $customerRepository,
        DatabaseManager $databaseManager
    ) {
        $this->customerRepository = $customerRepository;
        $this->databaseManager = $databaseManager;
    }

    /**
     * Handle the command.
     *
     * @param  UpdateCustomer  $command
     * @return void
     */
    public function handle(UpdateCustomer $command)
    {
        $this->databaseManager->beginTransaction();

        try {


            $customer = $this->customerRepository->findById($command->id);

            // Update Customer
            $customer->fill(
                [
                    'first_name' => $command->firstName,
                    'last_name' => $command->lastName
                ]
            );
            $customer->save();

            // Remove old associations
            $customer->emails()->delete();
            $customer->phones()->delete();

            // (re)Save associations
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
