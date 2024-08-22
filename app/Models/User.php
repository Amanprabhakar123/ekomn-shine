<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Order;
use App\Models\OrderRefund;
use App\Models\OrderInvoice;
use App\Models\CompanyDetail;
use App\Models\BuyerInventory;
use App\Models\SupplierPayment;
use App\Models\ProductInventory;
use Laravel\Sanctum\HasApiTokens;
use App\Models\OrderCancellations;
use App\Notifications\VerifyEmail;
use Spatie\Activitylog\LogOptions;
use App\Models\OrderItemAndCharges;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\OrderPaymentDistribution;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Faker\Provider\ar_EG\Person;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable,  HasRoles, SoftDeletes, LogsActivity;

    const ROLE_BUYER = 'buyer';
    const ROLE_SUPPLIER = 'supplier';
    const ROLE_ADMIN = 'super-admin';
    const PERMISSION_ADD_PRODUCT = 'add_product_details';
    const PERMISSION_LIST_PRODUCT = 'list_product_details';
    const PERMISSION_EDIT_PRODUCT_DETAILS = 'edit_product_details';
    const PERMISSION_ADD_CONNCETION = 'add_connection';
    const PERMISSION_EDIT_CONNCETION = 'edit_connection';
    const PERMISSION_ADD_NEW_ORDER = 'add_new_order';
    const PERMISSION_LIST_ORDER = 'list_order';
    const PERMISSION_EDIT_ORDER = 'edit_order';
    const PERMISSION_CANCEL_ORDER = 'cancel_order';
    const PERMISSION_ADD_NEW_RETURN = 'add_new_return';
    const PERMISSION_ADD_COURIER = 'add_new_courier';
    const PERMISSION_LIST_COURIER = 'list_courier';
    const PERMISSION_EDIT_COURIER = 'edit_courier';
    const PERMISSION_ORDER_TRACKING = 'order_tracking';
    const PERMISSION_PAYMENT_LIST = 'payment_list';
    const PERMISSION_PAYMENT_EDIT = 'payment_edit'; 
    const PERMISSION_PAYMENT_EXPORT = 'payment_export';
    const PERMISSION_TOP_CATEGORY = 'top_category';
    const PERMISSION_TOP_PRODUCT = 'top_product';
    const PERMISSION_BANNER = 'banner';
    const PERMISSION_MIS_SETTING_INVENTORY = 'mis_setting_inventory';

    // define permission for return order
    const PERMISSION_CREATE_RETURN_ORDER = 'create_return_order';
    const PERMISSION_LIST_RETURN_ORDER = 'list_return_order';
    const PERMISSION_VIEW_RETURN_ORDER = 'view_return_order';
    const PERMISSION_EDIT_RETURN_ORDER = 'edit_return_order';
 

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
     * Get the options for logging changes to the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'name',
            'email',
            'password',
            'picture',
            'google_id',
        ])
        ->logOnlyDirty()
        ->useLogName('User Log')
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} users with ID: {$this->id}");
    }

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

    /**
     * Define a one-to-many relationship with the Ordwer model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'buyer_id', 'id');
    }

    /**
     * Define a one-to-many relationship with the OrderItemAndCharges model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItemAndCharges::class, 'buyer_id', 'id');
    }

    /**
     * Define a one-to-many relationship with the OrderItemAndCharges model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function supplierOrders()
    {
        return $this->hasMany(OrderItemAndCharges::class, 'supplier_id', 'id');
    }

    /**
     * Define a one-to-many relationship with the OrderPayment model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderSupplierDistributionPayments()
    {
        return $this->hasMany(OrderPaymentDistribution::class, 'supplier_id', 'id');
    }

    /**
     * Define a one-to-many relationship with the OrderPayment model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderCanccellations()
    {
        return $this->hasMany(OrderCancellations::class, 'cancelled_by_id', 'id');
    }

    /**
     * Define a one-to-many relationship with the OrderPayment model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderRefunds()
    {
        return $this->hasMany(OrderRefund::class, 'buyer_id', 'id');
    }

    /**
     * Define a one-to-many relationship with the OrderPayment model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderSupplierRefunds()
    {
        return $this->hasMany(OrderRefund::class, 'supplier_id', 'id');
    }

    /**
     * Define a one-to-many relationship with the OrderPayment model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderBuyerInvoices()
    {
        return $this->hasMany(OrderInvoice::class, 'buyer_id', 'id');
    }

    /**
     * Define a one-to-many relationship with the OrderPayment model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderSupplierInvoices()
    {
        return $this->hasMany(OrderInvoice::class, 'supplier_id', 'id');
    }

    /**
     * Define a one-to-many relationship with the OrderPayment model.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderSupplierPayments()
    {
        return $this->hasMany(SupplierPayment::class, 'supplier_id', 'id');
    }
    
}
