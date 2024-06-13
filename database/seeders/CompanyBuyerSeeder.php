<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use App\Models\CompanyDetail;
use Illuminate\Database\Seeder;
use App\Models\CompanyCanHandle;
use App\Models\CompanyBusinessType;
use App\Models\CompanySalesChannel;
use App\Models\CompanyAddressDetail;
use App\Models\CompanyProductCategory;
use Illuminate\Support\Facades\Storage;


class CompanyBuyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $faker = Faker::create();
            $data =  [
                'user_id' => 1, // 'user_id' is the id of the user table
                'business_name' => $faker->company,
                'display_name' => generateUniqueCompanyUsername($faker->company),
                'designation' => $faker->jobTitle,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'mobile_no' => $faker->phoneNumber,
                'pan_no' => $faker->unique()->randomNumber(9),
                'gst_no' => $faker->unique()->randomNumber(9),
                'pan_no_file_path' => $faker->imageUrl(),
                'gst_no_file_path' => $faker->imageUrl(),
                'pan_verified' => $faker->boolean,
                'gst_verified' => $faker->boolean,
                'language_i_can_read' => json_encode(range(0,8)),
                'language_i_can_understand' => json_encode(range(0, 8)),
                'alternate_business_contact' => json_encode($this->extractAlternateBusinessContactData()),
                'bank_name' => $faker->company,
                'bank_account_no' => $faker->bankAccountNumber,
                'ifsc_code' => $faker->swiftBicNumber,
                'swift_code' => $faker->swiftBicNumber,
                'cancelled_cheque_file_path' => $faker->imageUrl(),
                'signature_image_file_path' => $faker->imageUrl(),
                'bank_account_verified' => $faker->boolean,
            ];
            // Create a new CompanyDetail instance
            $company = CompanyDetail::create($data);

            // Example product categories
            $this->handleCompanyProductCategories($company->id, [5, 6, 7]);

            // Example business types
            $this->handleCompanyBusinessTypes($company->id, [12, 13, 14]);

            // Example sales channels
            $this->handleCompanySalesChannels($company->id, [1]);

            // Example can handle
            // $this->handleCompanyCanHandle($company->id, [1, 2]);

            // Example addresses
            $this->handleAddress($company->id, [
                'address_line1' => $faker->streetAddress,
                'city' => $faker->city,
                'state' => $faker->state,
                'pincode' => $faker->postcode,
                'address_type' => CompanyAddressDetail::TYPE_DELIVERY_ADDRESS,
                'is_primary' => true,
                'location_link' => $faker->url,
            ], CompanyAddressDetail::TYPE_DELIVERY_ADDRESS);

            $this->handleAddress($company->id, [
                'address_line1' => $faker->streetAddress,
                'city' => $faker->city,
                'state' => $faker->state,
                'pincode' => $faker->postcode,
                'address_type' => CompanyAddressDetail::TYPE_BILLING_ADDRESS,
                'is_primary' => true,
                'location_link' => $faker->url,
            ], CompanyAddressDetail::TYPE_BILLING_ADDRESS);
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getLine(), $e->getFile());
            // Handle the exception here
            // You can log the error or display a message to the user
        }
    }


    /**
     * Extract alternate business contact data from validated data.
     *
     * @param array $validatedData
     * @return array
     */
    private function extractAlternateBusinessContactData(): array
    {
        try {
            $faker = Faker::create();
            return [
                'alternate_business_contact' => [
                    'BusinessPerformanceAndCriticalEvents' => [
                        'name' => $faker->name,
                        'mobile_no' => $faker->phoneNumber,
                    ],
                    'ProductSourcingAlert' => [
                        'name' => $faker->name,
                        'mobile_no' => $faker->phoneNumber,
                    ],
                    'BulkOrderContact' => [
                        'name' => $faker->name,
                        'mobile_no' => $faker->phoneNumber,
                    ],
                ]
            ];
        } catch (\Exception $e) {
            // Handle the exception here
            throw $e->getMessage();
        }
    }

    /**
     * Store a file and return its path.
     *
     * @param string $filename
     * @param string $path
     * @return string
     */
    private function storeFile(string $filename, string $path): string
    {
        try {
            $filePath = "$path/$filename";
            Storage::put($filePath, 'sample content');
            return Storage::url($filePath);
        } catch (\Exception $e) {
            // Handle the exception here
            // You can log the error or display a message to the user
            throw $e->getMessage();
        }
    }

    /**
     * Handle company product categories.
     *
     * @param int $companyId
     * @param array $categories
     */
    private function handleCompanyProductCategories(int $companyId, array $categories): void
    {
        try {
            foreach ($categories as $categoryId) {
                CompanyProductCategory::create([
                    'company_id' => $companyId,
                    'product_category_id' => $categoryId,
                ]);
            }
        } catch (\Exception $e) {
            throw $e->getMessage();
            // Handle the exception here
            // You can log the error or display a message to the user
        }
    }

    /**
     * Handle company business types.
     *
     * @param int $companyId
     * @param array $businessTypes
     */
    private function handleCompanyBusinessTypes(int $companyId, array $businessTypes): void
    {
        try {
            foreach ($businessTypes as $businessTypeId) {
                CompanyBusinessType::create([
                    'company_id' => $companyId,
                    'business_type_id' => $businessTypeId,
                ]);
            }
        } catch (\Exception $e) {
            throw $e->getMessage();
            // Handle the exception here
            // You can log the error or display a message to the user
        }
    }

    /**
     * Handle company sales channels.
     *
     * @param int $companyId
     * @param array $salesChannels
     */
    private function handleCompanySalesChannels(int $companyId, array $salesChannels): void
    {
        try {
            foreach ($salesChannels as $salesChannelId) {
                CompanySalesChannel::create([
                    'company_id' => $companyId,
                    'sales_channel_id' => $salesChannelId,
                ]);
            }
        } catch (\Exception $e) {
            throw $e->getMessage();
            // Handle the exception here
            // You can log the error or display a message to the user
        }
    }

    /**
     * Handle company can handle.
     *
     * @param int $companyId
     * @param array $canHandles
     */
    private function handleCompanyCanHandle(int $companyId, array $canHandles): void
    {
        try {
            foreach ($canHandles as $canHandleId) {
                CompanyCanHandle::create([
                    'company_id' => $companyId,
                    'can_handles_id' => $canHandleId,
                ]);
            }
        } catch (\Exception $e) {
            throw $e->getMessage();
            // Handle the exception here
            // You can log the error or display a message to the user
        }
    }

    /**
     * Handle address.
     *
     * @param int $companyId
     * @param array $address
     * @param string $addressType
     */
    private function handleAddress(int $companyId, array $address, string $addressType): void
    {
        try {
            CompanyAddressDetail::create(array_merge($address, [
                'company_id' => $companyId,
                'address_type' => $addressType,
            ]));
        } catch (\Exception $e) {
            throw $e->getMessage();
            // Handle the exception here
            // You can log the error or display a message to the user
        }
    }
}
