<div class="page-header">
    <h2>{!! $customer->first_name . ' ' . $customer->last_name !!}</h2>
</div>

<div>
    <h3>Email Addresses</h3>
    @foreach($customer->emails as $email)
    {!! $email->address !!} <br>
    @endforeach
</div>

<div>
    <h3>Phone Numbers</h3>
    @foreach($customer->phones as $phone)
    {!! $phone->number !!} <br>
    @endforeach
</div>