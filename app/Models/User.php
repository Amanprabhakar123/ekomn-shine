<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\CompanyDetail;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\VerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable,  HasRoles, SoftDeletes;

    const ROLE_BUYER = 'buyer';
    const ROLE_SUPPLIER = 'supplier';
    const ROLE_ADMIN = 'super-admin';
    const PERMISSION_ADD_PRODUCT = 'add_product_details';
    const PERMISSION_LIST_PRODUCT = 'list_product_details';
    const PERMISSION_EDIT_PRODUCT_DETAILS = 'edit_product_details';
    const PERMISSION_ADD_CONNCETION = 'add_connection';
    const PERMISSION_EDIT_CONNCETION = 'edit_connection';
    const PERMISSION_ADD_NEW_ORDER = 'add_new_order';
    const PERMISSION_EDIT_ORDER = 'edit_order';
    const PERMISSION_ADD_NEW_RETURN = 'add_new_return';

    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'picture',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id'; // Replace 'custom_key_name' with your actual primary key column name
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notification
     * @return string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email; // Use the user's email as the recipient
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token The password reset token.
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        // Your your own implementation.
        $this->notify(new ResetPasswordNotification($token));
    }
    
    /**
     * Mutator for setting the name column by concatenating first_name and last_name.
     *
     * @param string $value
     */
    public function setFirstNameAttribute($value)
    {
        $names = explode(' ', $this->attributes['name']);
        $lastName = isset($names[1]) ? $names[1] : '';
        $this->attributes['name'] = $value . ' ' . $lastName;
    }

    /**
     * Mutator for setting the name column by concatenating first_name and last_name.
     *
     * @param string $value
     */
    public function setLastNameAttribute($value)
    {
        $names = explode(' ', $this->attributes['name']);
        $firstName = $names[0];
        $this->attributes['name'] = $firstName . ' ' . $value;
    }

    /**
     * Accessor for getting the first name.
     *
     * @return string
     */
    public function getFirstNameAttribute()
    {
        $names = explode(' ', $this->attributes['name']);
        return $names[0];
    }

    /**
     * Accessor for getting the last name.
     *
     * @return string
     */
    public function getLastNameAttribute()
    {
        $names = explode(' ', $this->attributes['name']);
        return $names[1] ?? '';
    }

    /**
     * Accessor for getting the full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->attributes['name'];
    }

    /**
     * Define a one-to-one relationship with the CompanyDetails model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function companyDetails()
    {
        return $this->hasOne(CompanyDetail::class);
    }
    /**
     * Define a one-to-many relationship with the ProductInventory model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productInventories()
    {
        return $this->hasMany(ProductInventory::class)->withPivot('product_id', 'id');
    }

    /**
     * Define a one-to-many relationship with the BuyerInventory model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function buyerInventories()
    {
        return $this->hasMany(BuyerInventory::class, 'buyer_id', 'id');
    }
}
