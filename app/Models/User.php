<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderRefund;
use Illuminate\Support\Str;
use App\Models\OrderInvoice;
use App\Models\CompanyDetail;
use App\Models\BuyerInventory;
use App\Models\SupplierPayment;
use App\Models\ProductInventory;
use Faker\Provider\ar_EG\Person;
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

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable,  HasRoles, SoftDeletes, LogsActivity;

    // define roles
    const ROLE_BUYER = 'buyer';
    const ROLE_SUPPLIER = 'supplier';
    const ROLE_ADMIN = 'super-admin';
    const ROLE_SUB_ADMIN = 'admin';

    // define permissions
    const PERMISSION_ADD_PRODUCT = 'add_new_inventory';
    const PERMISSION_LIST_PRODUCT = 'my_inventory';
    const PERMISSION_EDIT_PRODUCT_DETAILS = 'edit_and_update_inventory';
    const PERMISSION_ADD_CONNCETION = 'add_connection';
    const PERMISSION_EDIT_CONNCETION = 'edit_connection';
    const PERMISSION_ADD_NEW_ORDER = 'add_new_order';
    const PERMISSION_LIST_ORDER = 'my_order';
    const PERMISSION_EDIT_ORDER = 'edit_and_update_order';
    const PERMISSION_CANCEL_ORDER = 'cancel_order';
    const PERMISSION_ADD_COURIER = 'add_new_courier';
    const PERMISSION_LIST_COURIER = 'my_courier';
    const PERMISSION_EDIT_COURIER = 'edit_and_update_courier';
    const PERMISSION_ORDER_TRACKING = 'order_and_return_tracking';
    const PERMISSION_PAYMENT_LIST = 'my_payment';
    const PERMISSION_PAYMENT_EDIT = 'edit_and_update_payment'; 
    const PERMISSION_PAYMENT_EXPORT = 'export_payment';
    const PERMISSION_CATEGORY_MANAGEMENT = 'category_management';
    const PERMISSION_TOP_CATEGORY = 'top_category_crud';
    const PERMISSION_TOP_PRODUCT = 'top_product_crud';
    const PERMISSION_BANNER = 'banner_crud';
    const PERMISSION_MIS_SETTING_INVENTORY = 'all_mis_setting';

    // define permission for subsctiption
    const PERMISSION_SUBSCRIPTION_LIST = 'subscription_list';
    const PERMISSION_SUBSCRIPTION_VIEW = 'subscription_view'; 

    // define permission for return order
    const PERMISSION_CREATE_RETURN_ORDER = 'add_new_return_order';
    const PERMISSION_LIST_RETURN_ORDER = 'list_return_order';
    const PERMISSION_VIEW_RETURN_ORDER = 'view_return_order';
    const PERMISSION_EDIT_RETURN_ORDER = 'edit_and_update_return_order';
    const PERMISSION_USER_LIST = 'user_list';
    const PERMISSION_ADMIN_LIST = 'admin_list';
    const PERMISSION_PLAN_LIST = 'plan_list';
    const PERMISSION_PLAN_EDIT = 'plan_edit';

    // define permission for Shine
    const PERMISSION_SHINE = 'shine';
    const PERMISSION_MY_SHINE = 'my_shine';

    // define permission for sub admin
    const SUB_ADMIN_PERMISSION_LIST = [
        self::PERMISSION_ADD_PRODUCT,
        self::PERMISSION_LIST_PRODUCT,
        self::PERMISSION_EDIT_PRODUCT_DETAILS,
        self::PERMISSION_LIST_ORDER,
        self::PERMISSION_EDIT_ORDER,
        self::PERMISSION_CANCEL_ORDER,
        self::PERMISSION_ORDER_TRACKING,
        self::PERMISSION_PAYMENT_LIST,
        self::PERMISSION_PAYMENT_EDIT,
        self::PERMISSION_PAYMENT_EXPORT,
        self::PERMISSION_CREATE_RETURN_ORDER,
        self::PERMISSION_LIST_RETURN_ORDER,
        self::PERMISSION_VIEW_RETURN_ORDER,
        self::PERMISSION_EDIT_RETURN_ORDER,
        self::PERMISSION_MIS_SETTING_INVENTORY,
        self::PERMISSION_CATEGORY_MANAGEMENT,
        self::PERMISSION_TOP_CATEGORY,
        self::PERMISSION_TOP_PRODUCT,
        self::PERMISSION_BANNER,
        self::PERMISSION_ADD_COURIER,
        self::PERMISSION_LIST_COURIER,
        self::PERMISSION_EDIT_COURIER,
        self::PERMISSION_USER_LIST,
        self::PERMISSION_ADMIN_LIST,
        self::PERMISSION_SUBSCRIPTION_LIST,
        self::PERMISSION_PLAN_LIST,
        self::PERMISSION_PLAN_EDIT,
        self::PERMISSION_SHINE,
    ];

    // define status user active and inactive
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    // define subscribe and unsubscribe 
    const SUBSCRIBE_YES = 1;
    const SUBSCRIBE_NO = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'isactive',
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
            'isactive',
            'email_verified_at',
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

    /**
     * Define to token generated for unsubscribe.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public static function unsubscribeTokens($user)
    {
         $token = Str::random(60);
    
         UnSubscribeToken::create([
                'user_id' => $user->id,
                'token' => hash('sha256', $token),
                'expires_at' => Carbon::now()->addMinutes(60), // Token valid for 60 minutes
            ]);
    
        return  route('unsubscribe', ['token' => $token]);
    
    }
    
}
