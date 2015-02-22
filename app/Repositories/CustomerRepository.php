<?php namespace App\Repositories;

use App\Customer;

class CustomerRepository
{
    public function findById($id)
    {
        return Customer::find($id);
    }

    public function listCustomers($perPage = 15)
    {
        return Customer::with(['emails', 'phones'])
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    public function getCustomersWithDuplicates($perPage = 15)
    {
//        SELECT c.id, c.first_name, c.last_name, dup.num_duplicates FROM customers AS c
//        INNER JOIN
//            (SELECT id, first_name, last_name, count(*) as num_duplicates
//            FROM customers
//            GROUP BY first_name, last_name
//            HAVING num_duplicates > 1
//            ) AS dup
//        ON c.first_name = dup.first_name AND c.last_name = dup.last_name
//        WHERE c.deleted_at IS NULL AND c.id <> dup.id
//        GROUP BY c.first_name, c.last_name

        $query = Customer::query();
        $query->select('customers.id', 'customers.first_name', 'customers.last_name')
            ->addSelect('dup.num_duplicates')
            ->join(
                \DB::raw('
                    (SELECT id, first_name, last_name, count(*) as num_duplicates
                     FROM customers
                     GROUP BY first_name, last_name
                     HAVING num_duplicates > 1
                    ) AS dup
                '),
                function($join)
                {
                    $join->on('customers.first_name', '=', 'dup.first_name')
                        ->on('customers.last_name', '=', 'dup.last_name');
                })
            ->where('customers.id', '<>', 'dup.id')
            ->groupBy('customers.first_name')
            ->groupBy('customers.last_name')
            ->orderBy('customers.id', 'desc');
        return $query->get();
    }

    public function getCustomerDuplicates(Customer $customer)
    {
        return $customer->duplicates;
    }
}