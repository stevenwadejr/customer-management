<?php namespace App\Handlers\Commands;

use App\Commands\RemoveCustomer;

use App\Customer;
use Illuminate\Queue\InteractsWithQueue;

class RemoveCustomerHandler
{
	/**
	 * Handle the command.
	 *
	 * @param  RemoveCustomer  $command
	 * @return void
	 */
	public function handle(RemoveCustomer $command)
	{
		$customer = Customer::find($command->id);
        $customer->delete();
	}

}
