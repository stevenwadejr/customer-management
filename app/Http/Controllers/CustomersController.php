<?php namespace App\Http\Controllers;

use App\Commands\MergeCustomerProfiles;
use App\Commands\RemoveCustomer;
use App\Customer;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\CustomerFormRequest;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $customers = $this->customerRepository->listCustomers(10);

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $customer = new Customer();
        $action = 'Add';
        $route = 'customers.store';
        return view('customers.form', compact('customer', 'action', 'route'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CustomerFormRequest $formRequest, Request $request)
    {
        $this->dispatchFrom('App\Commands\AddCustomer', $request);
        flash()->success('Customer successfully added!');
        return redirect()->route('customers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $customer = $this->customerRepository->findById($id);
        $action = 'Edit';
        $route = ['customers.update', $customer->id];
        return view('customers.form', compact('customer', 'action', 'route'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, CustomerFormRequest $formRequest, Request $request)
    {
        $request->merge(['id' => $id], $request->all());
        $this->dispatchFrom(
            'App\Commands\UpdateCustomer',
            $request
        );
        flash()->success('Customer successfully updated');
        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->dispatch(new RemoveCustomer($id));
        flash()->success('Customer successfully removed');
        return redirect()->route('customers.index');
    }

    public function listDuplicates()
    {
        $customers = $this->customerRepository->getCustomersWithDuplicates(10);

        return view('customers.duplicates-list', compact('customers'));
    }

    public function viewDuplicateProfile($id)
    {
        $customer = $this->customerRepository->findById($id);
        $duplicates = $this->customerRepository->getCustomerDuplicates($customer);

        return view('customers.duplicates-profile', compact('customer', 'duplicates'));
    }

    public function mergeDuplicateProfiles($id)
    {
        $this->dispatch(new MergeCustomerProfiles($id, \Input::get('profiles', [])));
        flash()->success('Profiles successfully merged');
        return redirect()->route('customers.index');
    }

}
