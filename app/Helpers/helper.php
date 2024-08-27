<?php

use App\Models\AddToCart;
use App\Models\Category;
use App\Models\CompanyDetail;
use App\Models\ProductInventory;
use App\Models\ProductVariation;
use App\Models\ProductVariationMedia;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

// User roles define for entire application
const ROLE_BUYER = User::ROLE_BUYER;
const ROLE_SUPPLIER = User::ROLE_SUPPLIER;
const ROLE_ADMIN = User::ROLE_ADMIN;
const ROLE_SUB_ADMIN = User::ROLE_SUB_ADMIN;
const PERMISSION_ADD_PRODUCT = User::PERMISSION_ADD_PRODUCT;
const PERMISSION_LIST_PRODUCT = User::PERMISSION_LIST_PRODUCT;
const PERMISSION_EDIT_PRODUCT_DETAILS = User::PERMISSION_EDIT_PRODUCT_DETAILS;
const PERMISSION_ADD_CONNCETION = User::PERMISSION_ADD_CONNCETION;
const PERMISSION_EDIT_CONNCETION = User::PERMISSION_EDIT_CONNCETION;
const PERMISSION_ADD_NEW_ORDER = User::PERMISSION_ADD_NEW_ORDER;
const PERMISSION_LIST_ORDER = User::PERMISSION_LIST_ORDER;
const PERMISSION_EDIT_ORDER = User::PERMISSION_EDIT_ORDER;
const PERMISSION_CANCEL_ORDER = User::PERMISSION_CANCEL_ORDER;
const PERMISSION_ADD_COURIER = User::PERMISSION_ADD_COURIER;
const PERMISSION_LIST_COURIER = User::PERMISSION_LIST_COURIER;
const PERMISSION_EDIT_COURIER = User::PERMISSION_EDIT_COURIER;
const PERMISSION_ORDER_TRACKING = User::PERMISSION_ORDER_TRACKING;
const PERMISSION_PAYMENT_LIST = User::PERMISSION_PAYMENT_LIST;
const PERMISSION_PAYMENT_EDIT = User::PERMISSION_PAYMENT_EDIT;
const PERMISSION_PAYMENT_EXPORT = User::PERMISSION_PAYMENT_EXPORT;
const PERMISSION_TOP_CATEGORY = User::PERMISSION_TOP_CATEGORY;
const PERMISSION_TOP_PRODUCT = User::PERMISSION_TOP_PRODUCT;
const PERMISSION_BANNER = User::PERMISSION_BANNER;
const PERMISSION_MIS_SETTING_INVENTORY = User::PERMISSION_MIS_SETTING_INVENTORY;
const PERMISSION_CATEGORY_MANAGEMENT = User::PERMISSION_CATEGORY_MANAGEMENT;
const PERMISSION_USER_LIST = User::PERMISSION_USER_LIST;
const PERMISSION_ADMIN_LIST = User::PERMISSION_ADMIN_LIST;

// return order permission
const PERMISSION_CREATE_RETURN_ORDER = User::PERMISSION_CREATE_RETURN_ORDER;
const PERMISSION_LIST_RETURN_ORDER = User::PERMISSION_LIST_RETURN_ORDER;
const PERMISSION_VIEW_RETURN_ORDER = User::PERMISSION_VIEW_RETURN_ORDER;
const PERMISSION_EDIT_RETURN_ORDER = User::PERMISSION_EDIT_RETURN_ORDER;

// Bulk Upload Processing Status
const BULK_UPLOAD_STATUS_PENDING = 1;
const BULK_UPLOAD_STATUS_PROCESSING = 2;
const BULK_UPLOAD_STATUS_COMPLETED = 3;
const BULK_UPLOAD_STATUS_FAILED = 4;
const BULK_UPLOAD_STATUS_QUEUED = 5;
const BULK_UPLOAD_STATUS_VALIDATION_ERROR = 6;

// Media Type
const MEDIA_TYPE_IMAGE = ProductVariationMedia::MEDIA_TYPE_IMAGE;
const MEDIA_TYPE_VIDEO = ProductVariationMedia::MEDIA_TYPE_VIDEO;
const IS_MASTER_TRUE = ProductVariationMedia::IS_MASTER_TRUE;
const IS_MASTER_FALSE = ProductVariationMedia::IS_MASTER_FALSE;

// Product Inventory Sorting Status
const SORTING_STOCK_HIGH_TO_LOW = 1;
const SORTING_STOCK_LOW_TO_HIGH = 2;
const SORTING_PRICE_HIGH_TO_LOW = 3;
const SORTING_PRICE_LOW_TO_HIGH = 4;
const SORTING_REGULAR_AVAILABLE = 5;
const SORTING_TILL_STOCK_LAST = 6;

/**
 * Encrypts a string using a salt key.
 *
 * @param  string  $string  The string to be encrypted.
 * @return string|array If successful, returns the encrypted string.
 *                      If no string provided, returns an array with status false and an error message.
 */
if (! function_exists('salt_encrypt')) {
    function salt_encrypt($string)
    {
        //return $string;
        if (! empty($string)) {
            $encrypted = encrypt(env('SALT_KEY').$string);

            return $encrypted;
        } else {
            return [
                'status' => false,
                'message' => 'Error: Please provide string to be decrypted.',
            ];
        }
    }
}

/**
 * Decrypts an encrypted string, removing the salt key from it.
 *
 * @param  string  $string  The encrypted string to be decrypted.
 * @return string|array If successful, returns the decrypted string.
 *                      If no encrypted string provided, returns an array with status false and an error message.
 */
if (! function_exists('salt_decrypt')) {
    function salt_decrypt($string)
    {
        //return $string;
        if (! empty($string)) {
            $decrypted = decrypt($string);
            $mainString = str_replace(env('SALT_KEY'), '', $decrypted);

            return $mainString;
        } else {
            return [
                'status' => false,
                'message' => 'Error: Please provide encrypted string.',
            ];
        }
    }
}

/**
 * Prints the human-readable representation of a variable and exits the script.
 *
 * This function is useful for debugging purposes to print out the contents of a variable
 * in a human-readable format and then exit the script execution.
 *
 * @param  mixed  $string  The variable to be printed.
 * @return void This function does not return a value.
 */
if (! function_exists('printR')) {
    function printR($string)
    {
        echo '<pre>';
        print_r($string);
        echo '</pre>';
        exit;
    }
}

/**
 * Generate a unique username based on the given name and next number.
 *
 * @param  string  $name  The name of the user.
 * @param  int  $nextNumber  The next number to be appended to the username.
 * @return string The generated username.
 */
if (! function_exists('generateUniqueCompanyUsername')) {
    function generateUniqueCompanyUsername($companyName = null)
    {
        
        if ($companyName) {
            // Extract the initials
            $username = '';
            $words = explode(' ', $companyName);
            if (count($words) == 1) {
                $username = strtoupper($words[0]);
            } else {
                foreach ($words as $word) {
                    $username .= strtoupper($word[0]);
                }
            }

            $counter = 1;
            $originalUsername = $username;

            // Ensure the username is unique
            while (CompanyDetail::where('display_name', $username)->exists()) {
                $username = $originalUsername.$counter;
                $counter++;
            }

            return $username;
        } else {
            return '';
        }
    }
}

/**
 * Generate a unique username based on the given name and next number.
 *
 * @param  string  $name  The name of the user.
 * @param  int  $nextNumber  The next number to be appended to the username.
 * @return string The generated username.
 */
function convertImageToBase64($imagePath)
{
    // Check if the file exists
    if (file_exists($imagePath)) {
        // Get the image content
        $imageData = file_get_contents($imagePath);

        // Encode the image content in Base64
        $base64Image = base64_encode($imageData);

        // Get the image type
        $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);

        // Return the Base64 encoded image with the appropriate data URL prefix
        return 'data:image/'.$imageType.';base64,'.$base64Image;
    } else {
        // Handle the error if the file does not exist
        return null;
    }
}

/**
 * Generate an error response.
 */
function errorResponse(string $message): JsonResponse
{
    $parts = explode('-', $message);
    $key = '';
    if (! empty($parts)) {
        $message = $parts[0];
        $key = $parts[1] ?? null;
    }
    $response = [
        'statusCode' => __('statusCode.statusCode422'),
        'status' => __('statusCode.status422'),
        'message' => $message,
    ];
    if ($key) {
        if (strpos($key, '.') !== false) {
            $a = explode('.', trim($key));
            $key = $a[0][0].'_'.$a[1];
        }
        $response['key'] = trim($key);
    }

    return response()->json(['data' => $response], __('statusCode.statusCode200'));
}

/**
 * Generate a success response.
 */
function successResponse(?int $id = null, ?array $data = null): JsonResponse
{
    $response = [
        'statusCode' => __('statusCode.statusCode200'),
        'status' => __('statusCode.status200'),
        'message' => __('auth.registerSuccess'),
    ];

    if ($id) {
        $response['id'] = $id;
    }
    if ($data) {
        $response['data'] = $data;
    }

    return response()->json(['data' => $response], __('statusCode.statusCode200'));
}

/**
 * Generate a company serial ID based on the given ID and type.
 *
 * @param  int  $id  The ID of the company.
 * @param  string  $type  The type of the company.
 * @return string The generated company serial ID.
 */
function generateCompanySerialId($id, $type)
{
    $company_serial_id = $type.mt_rand(100000, 999999);
        while (CompanyDetail::where('company_serial_id', $company_serial_id)->exists()) {
            $company_serial_id = $type.mt_rand(100000, 999999);
        }
    // Format the new supplier ID with leading zeros and 's' prefix
    // return $type.str_pad($id, 6, '0', STR_PAD_LEFT);
    return $company_serial_id;
}

/**
 * Generates a unique SKU for a product based on its name, category and the current time.
 *
 * The SKU is composed of:
 * - The first 2 characters of the product name (uppercase)
 * - The first 2 characters of the category name (uppercase)
 * - The last 4 digits of the current Unix timestamp
 * - A random 4-digit number
 *
 * Ensures the generated SKU is unique by checking against existing SKUs in the database.
 *
 * @param  string  $name  The name of the product.
 * @param  string  $category  The category of the product.
 * @return string The generated SKU, which is a maximum of 10 characters long.
 */
function generateSKU($name, $category)
{
    $namePart = strtoupper(substr($name, 0, 2));

    $categoryPart = strtoupper(substr($category, 0, 2));

    $timePart = substr(time(), -4);

    $randomPart = mt_rand(1000, 9999);

    $sku = $namePart.$categoryPart.$timePart.$randomPart;

    while (ProductVariation::where('sku', $sku)->exists()) {
        $randomPart = mt_rand(1000, 9999);
        $sku = $namePart.$categoryPart.$timePart.$randomPart;
    }

    return substr($sku, 0, 12);
}

/**
 * Generates a unique SKU code for a product based on its SKU, color, size, and a counter.
 *
 * The SKU code is composed of:
 * - The SKU of the product
 * - The first letter of the color (uppercase)
 * - The first letter of the size (uppercase)
 * - A counter value
 *
 * Ensures the generated SKU code is unique by checking against existing SKU codes in the database.
 *
 * @param  string  $sku  The SKU of the product.
 * @param  string  $color  The color of the product.
 * @param  string  $size  The size of the product.
 * @param  int  $i  The counter value.
 * @return string The generated SKU code.
 */
function generateSKUCode($sku, $color, $size, $i)
{
    $sku = strtoupper(str_replace(' ', '-', $sku));
    // get color first 1 letter in upper case
    $color = strtoupper(substr($color, 0, 1));
    // get size first 1 letter in upper case
    $size = strtoupper(substr($size, 0, 1));
    $sku = $sku.'-'.$color.$size.'-'.$i;
    while (ProductVariation::where('sku', $sku)->exists()) {
        // $i++;
        $sku = $sku.'-'.$i;
    }

    return $sku;
}

/**
 * Generates a slug from the given product name.
 *
 * @param  string  $name  The product name.
 * @return string The generated slug.
 */
function generateSlug($name, $p_id)
{
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    $p_id = strtolower($p_id);

    return $slug.'-'.$p_id;
}

/**
 * Generate a unique product ID based on the given title and next number.
 *
 * @param  string  $title  The title of the product.
 * @param  int  $nextNumber  The next number to be appended to the product ID.
 * @return string The generated product ID.
 */
function generateProductID($title, $nextNumber)
{
    // Extract and sanitize the first 2 letters of the product title
    $prefix = strtoupper(substr(preg_replace('/[^A-Za-z0-9]+/', '', $title), 0, 2));

    // Ensure the prefix is exactly 2 characters, padding with 'X' if needed
    $prefix = str_pad($prefix, 2, 'X');

    // Format the next number as a zero-padded string, ensuring it's 6 digits
    $numericPart = str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

    // Combine prefix and numeric part to form the ProductID
    return $prefix.$numericPart;
}

/**
 * Print the SQL query along with the parameter bindings for debugging purposes.
 *
 * This function takes a query builder instance as input, retrieves the SQL query string,
 * and the parameter bindings from the query. It then combines them to create a complete
 * SQL query with actual parameter values for display and debugging purposes.
 *
 * @param  \Illuminate\Database\Query\Builder  $query  The query builder instance to print.
 * @return string The combined SQL query with actual parameter values.
 *
 * @example
 * $query = DB::table('users')
 *            ->where('name', 'John')
 *            ->orWhere('age', '>', 30);
 *
 * $combinedQuery = printQueryWithParameters($query);
 * echo $combinedQuery;
 *
 * // Output:
 * // select * from `users` where `name` = 'John' or `age` > 30
 */
function printQueryWithParameters($query)
{
    // Get the SQL query string
    $sql = $query->toSql();

    // Get the parameter bindings
    $bindings = $query->getBindings();

    // Combine them for display
    return vsprintf(str_replace(['%', '?'], ['%%', "'%s'"], $sql), $bindings);
}

/**
 * Get the string representation of a status based on its type value.
 *
 * @param  int  $type  The type value of the status.
 * @return string The string representation of the status.
 */
function getStatusName($type)
{
    switch ($type) {
        case ProductInventory::STATUS_ACTIVE:
            return 'Active';
        case ProductInventory::STATUS_INACTIVE:
            return 'Inactive';
        case ProductInventory::STATUS_OUT_OF_STOCK:
            return 'Out of Stock';
        case ProductInventory::STATUS_DRAFT:
            return 'Draft';
        default:
            return 'Unknown';
    }
}

/**
 * Get the string representation of an availability status based on its type value.
 *
 * @param  int  $type  The type value of the availability status.
 * @return string The string representation of the availability status.
 */
function getAvailablityStatusName($type)
{
    switch ($type) {
        case ProductInventory::TILL_STOCK_LAST:
            return 'Till Stock Last';
        case ProductInventory::REGULAR_AVAILABLE:
            return 'Regular Available';
        default:
            return 'Unknown';
    }
}

/**
 * Calculate the inclusive price and exclusive tax amount based on GST.
 *
 * @param  float  $exclusivePrice  Price before GST.
 * @param  float  $gstRate  GST rate in percentage.
 * @return array Associative array containing inclusive price and exclusive tax amount.
 */
function calculateInclusivePriceAndTax(float $exclusivePrice, float $gstRate): array
{
    // Calculate inclusive price
    $inclusivePrice = $exclusivePrice * (1 + $gstRate / 100);

    return [
        'price_after_tax' => $inclusivePrice,
        'price_before_tax' => $exclusivePrice,
    ];
}

/**
 * Convert weight in kilograms to the specified unit.
 *
 * @param  float  $weightInKg  The weight in kilograms to be converted.
 * @param  string  $unit  The unit to convert to. Supported units are 'mg', 'gm', 'ml', 'ltr', and 'kg'.
 * @return float The converted weight.
 *
 * @throws Exception If an unsupported unit is provided.
 */
function convertKg($weightInKg, $unit)
{
    switch ($unit) {
        case 'mg':
            return $weightInKg * 1000000; // Convert kg to mg
        case 'gm':
            return $weightInKg * 1000; // Convert kg to gm
        case 'ml':
            return $weightInKg * 1000; // Convert kg to ml (assuming 1 kg = 1 L)
        case 'ltr':
            return $weightInKg; // Convert kg to L (assuming 1 kg = 1 L)
        case 'kg':
            return $weightInKg;
        default:
            throw new Exception("Unsupported unit. Please use 'mg', 'gm', 'ml', or 'ltr'.");
    }
}

/**
 * Calculate the volumetric weight in kilograms based on the dimensions and unit.
 *
 * @param  float  $length  The length of the object.
 * @param  float  $breadth  The breadth of the object.
 * @param  float  $height  The height of the object.
 * @param  string  $unit  The unit of dimensions. Supported units are 'mm', 'cm', and 'inch'.
 * @return float The volumetric weight in kilograms.
 *
 * @throws Exception If an unsupported unit is provided.
 */
function calculateVolumetricWeight($length, $breadth, $height, $unit = 'cm')
{
    // Convert dimensions to centimeters
    switch ($unit) {
        case 'm':
            $length *= 100;
            $breadth *= 100;
            $height *= 100;
            break;
        case 'mm':
            $length /= 10;
            $breadth /= 10;
            $height /= 10;
            break;
        case 'in':
            $length *= 2.54;
            $breadth *= 2.54;
            $height *= 2.54;
            break;
        case 'inch':
            $length *= 2.54;
            $breadth *= 2.54;
            $height *= 2.54;
            break;
        case 'ft':
            $length *= 30.48;
            $breadth *= 30.48;
            $height *= 30.48;
            break;
        case 'cm':
            // No conversion needed
            break;
        default:
            throw new Exception("Unsupported unit. Please use 'mm', 'cm','ft', 'm' or 'inch'.");
    }

    // Dimensional Weight Factor for cm to kg
    $dimensionalWeightFactor = 5000;

    // Calculate the volumetric weight in kilograms
    $volumetricWeight = ($length * $breadth * $height) / $dimensionalWeightFactor;

    return $volumetricWeight;
}
/**
 * Unlink a file or delete a directory along with its contents.
 *
 * @param  string  $path  The path to the file or directory.
 * @return void
 */
function unlinkFile($path)
{
    if (file_exists($path)) {
        if (is_dir($path)) {
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::CHILD_FIRST
            );
            foreach ($files as $fileinfo) {
                if ($fileinfo->isDir()) {
                    rmdir($fileinfo->getRealPath());
                } else {
                    unlink($fileinfo->getRealPath());
                }
            }
            rmdir($path);
        } else {
            unlink($path);
        }
    }
}

/**
 * Recursively add a folder to a zip archive
 *
 * @param  string  $folder
 * @param  string  $parentFolder
 * @return void
 */
function addFolderToZip(ZipArchive $zip, $folder, $parentFolder = '')
{
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($folder, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($files as $fileinfo) {
        $filePath = $fileinfo->getRealPath();
        $relativePath = $parentFolder.'/'.substr($filePath, strlen($folder) + 1);

        if ($fileinfo->isDir()) {
            $zip->addEmptyDir($relativePath);
        } else {
            $zip->addFile($filePath, $relativePath);
        }
    }
}

if (! function_exists('storage')) {

    /**
     * Store or retrieve or delete data file from storage.
     *
     * @param  string  $key  The storage key.
     * @param  mixed|null  $data  The data to store. Pass `null` to retrieve data.
     * @param  array  $args  Additional arguments for formatting the storage path.
     * @param  string|null  $name  The name of the file to store.
     * @return mixed Returns the stored file path or content, or `null` if retrieval fails.
     */
    function storage(string $key, $data = null, array $args = [], $name = null)
    {
        $isFileOnS3 = config('app.FILE_STORAGE_PLACE');
        if (is_null($data)) {
            // get the file from local storage or s3 depends on environment
            return Storage::disk($isFileOnS3 ? 's3' : 'local')->get($key);
        } elseif ($data == 'delete') {
            // delete the file from local storage or s3 depends on environment
            return Storage::disk($isFileOnS3 ? 's3' : 'local')->delete($key);
        } else {
            $config = config('paths.'.$key);
            if (is_string($data)) {
                $path = vsprintf($config['path'], $args).'/'.$name;
                $visibility = $config['visibility'];
            } else {
                $path = vsprintf($config['path'], $args);
                $visibility = $config['assets_visibility'];
            }

            // store the file from local storage or s3 depends on environment
            $file = Storage::disk($isFileOnS3 ? 's3' : 'local')->put($path, $data, $visibility);

            return is_string($data) ? $path : $file;
        }
    }
}

/**
 * Convert a number to its equivalent words.
 *
 * @param  int  $number  The number to convert.
 * @return string The equivalent words for the number.
 */
function convertNumberToWords($number)
{
    $words = [
        '0' => 'Zero', '1' => 'One', '2' => 'Two',
        '3' => 'Three', '4' => 'Four', '5' => 'Five',
        '6' => 'Six', '7' => 'Seven', '8' => 'Eight',
        '9' => 'Nine', '10' => 'Ten', '11' => 'Eleven',
        '12' => 'Twelve', '13' => 'Thirteen', '14' => 'Fourteen',
        '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
        '18' => 'Eighteen', '19' => 'Nineteen', '20' => 'Twenty',
        '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty', '60' => 'Sixty',
        '70' => 'Seventy', '80' => 'Eighty', '90' => 'Ninety',
    ];

    if ($number <= 20) {
        return $words[$number];
    } elseif ($number < 100) {
        return $words[10 * floor($number / 10)]
            .($number % 10 > 0 ? ' '.$words[$number % 10] : '');
    } else {
        $output = '';
        if ($number >= 1000000000) {
            $output .= convertNumberToWords(floor($number / 1000000000))
                .' Billion ';
            $number %= 1000000000;
        }
        if ($number >= 1000000) {
            $output .= convertNumberToWords(floor($number / 1000000))
                .' Million ';
            $number %= 1000000;
        }
        if ($number >= 1000) {
            $output .= convertNumberToWords(floor($number / 1000))
                .' Thousand ';
            $number %= 1000;
        }
        if ($number >= 100) {
            $output .= convertNumberToWords(floor($number / 100))
                .' Hundred ';
            $number %= 100;
        }
        if ($number > 0) {
            $output .= ($number <= 20) ? $words[$number] :
            $words[10 * floor($number / 10)].' '
                .($number % 10 > 0 ? $words[$number % 10] : '');
        }

        return trim($output);
    }
}
/**
 * Get the count of items in the cart for a logged-in buyer.
 *
 * @param  int  $buyerId  The ID of the logged-in buyer.
 * @return int The count of items in the cart.
 */
function getCartItemCount($buyerId)
{
    return AddToCart::where('buyer_id', $buyerId)->count();
}
