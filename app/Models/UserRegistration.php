<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class UserRegistration extends Model
{
    /** @use HasFactory<\Database\Factories\UserRegistrationFactory> */
    use HasFactory;

    protected $primaryKey = 'registration_id';
    
    // Attributes allowed for mass assignment
    protected $fillable = [
        'title',
            'first_name',
            'last_name' ,
            'gender',
            'dob',
            'tel_no',
            'address',
            'image', 
            'status' , 
            'user_id',
            'role_id',
            'added_by'
    
    ];
 
    //  Get the user whos details are these.
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    
    //get the user who added current user
    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    //get the role of the user
    public function role():BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }


}
