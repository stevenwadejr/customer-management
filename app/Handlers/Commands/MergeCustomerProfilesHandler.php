<?php namespace App\Handlers\Commands;

use App\Commands\MergeCustomerProfiles;
use App\Customer;
use Illuminate\Database\DatabaseManager;
use Illuminate\Queue\InteractsWithQueue;

class MergeCustomerProfilesHandler
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
     * @param  MergeCustomerProfiles  $command
     * @return void
     */
    public function handle(MergeCustomerProfiles $command)
    {
        // Find main profile
        $customer = Customer::find($command->customerId);

        $this->databaseManager->beginTransaction();

        try {
            // Attach duplicate profile associations to main profile
            $duplicates = Customer::with(['emails', 'phones'])->find($command->duplicateIds);
            foreach ($duplicates as $duplicate) {
                foreach ($duplicate->emails as $email) {
                    $email->entity_id = $customer->id;
                    $email->save();
                }
                foreach ($duplicate->phones as $phone) {
                    $phone->entity_id = $customer->id;
                    $phone->save();
                }

                // Delete duplicate profiles
                $duplicate->delete();
            }

            $this->databaseManager->commit();
        } catch(\Exception $e) {
            $this->databaseManager->rollback();
            throw $e;
        }
    }

}
