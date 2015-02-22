<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $table = 'customers';

    protected $fillable = ['first_name', 'last_name', 'email', 'phone'];

    public function emails()
    {
        return $this->hasMany('App\Email', 'entity_id');
    }

    public function phones()
    {
        return $this->hasMany('App\Phone', 'entity_id');
    }

    public function duplicates()
    {
        $query = $this->hasMany(get_class($this), 'first_name', 'first_name');
        $query->where('last_name', $this->last_name);
        $query->where('id', '!=', $this->id);
        return $query;
    }
}
