<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pincode extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    const LOCAL = 'Local';
    const REGIONAL = 'Regional';
    const NATIONAL = 'National';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pincode',
        'district',
        'state',
        'latitude',
        'longitude',
    ];

    
     /**
     * Get the options for logging changes to the model.
     */
   public function getActivitylogOptions(): LogOptions
   {
       return LogOptions::defaults()
       ->logOnly([
            'pincode',
            'district',
            'state',
            'latitude',
            'longitude',
       ])
       ->logOnlyDirty()
       ->useLogName('Pincode Log')
       ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} pincode with ID: {$this->id}");
   }

    /**
     * Calculate the distance between two pin codes using longitude and latitude.
     *
     * @param string $originPincode
     * @param string $destinationPincode
     * @return array
     */
    public static function calculateDistance(string $originPincode, string $destinationPincode): array
    {
        $origin = self::where('pincode', $originPincode)->first();
        $destination = self::where('pincode', $destinationPincode)->first();

        if (!$origin || !$destination) {
            return ['distance' => 0, 'zone' => self::NATIONAL];
        }

        $manage = false;

        if ($origin->latitude && $origin->longitude && $destination->latitude && $destination->longitude) {
            // Calculate distance using latitude and longitude
            $distance = self::calculateDistanceUsingLatLong((float) $origin->latitude, (float) $origin->longitude, (float) $destination->latitude, (float) $destination->longitude);
        } elseif ($origin->latitude === 'NA' || $origin->longitude === 'NA'){
            $cities = self::getlatAndLongCities($origin->district);
            if($cities){
                $distance = self::calculateDistanceUsingLatLong((float) $cities->latitude, (float) $cities->longitude, (float) $destination->latitude, (float) $destination->longitude);
            }else{
                $distance = self::calculateDistanceUsingDistrictAndState($origin, $destination);
                $manage = true;
            }
        }elseif ($destination->latitude === 'NA' || $destination->longitude === 'NA') {
            // Handle NA values
            $cities =  self::getlatAndLongCities($destination->district);
            if($cities){
                $distance = self::calculateDistanceUsingLatLong((float) $origin->latitude, (float) $origin->longitude, (float) $cities->latitude, (float) $cities->longitude);
            }else{
                $distance = self::calculateDistanceUsingDistrictAndState($origin, $destination);
                $manage = true;
            }
        }elseif(($origin->latitude === 'NA' || $origin->longitude === 'NA') && ($destination->latitude === 'NA' || $destination->longitude === 'NA')){
            $distance = self::calculateDistanceBetweenCities($origin->district, $destination->district);
        }

        if($manage){
            return ['distance' => 0, 'zone' =>$distance];
        }
        return ['distance' => $distance, 'zone' => self::getZone($distance)];
    }

    /**
     * Calculate distance using latitude and longitude.
     *
     * @param float $originLatitude
     * @param float $originLongitude
     * @param float $destinationLatitude
     * @param float $destinationLongitude
     * @return string
     */
    private static function calculateDistanceUsingLatLong(float $originLatitude, float $originLongitude, float $destinationLatitude, float $destinationLongitude): string
    {
        $R = 6371; // Earth radius in kilometers

        $dlat = deg2rad($destinationLatitude - $originLatitude);
        $dlon = deg2rad($destinationLongitude - $originLongitude);
        $a = sin($dlat / 2) * sin($dlat / 2) + cos(deg2rad($originLatitude)) * cos(deg2rad($destinationLatitude)) * sin($dlon / 2) * sin($dlon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        $distance = $R * $c;
        return $distance;
    }

    /**
     * Calculate distance using district and state.
     *
     * @param Pincode $origin
     * @param Pincode $destination
     * @return string
     */
    private static function calculateDistanceUsingDistrictAndState(Pincode $origin, Pincode $destination): string
    {
        if ($origin->district === $destination->district && $origin->state === $destination->state) {
            return self::LOCAL;
        }

        if ($origin->district != $destination->district && $origin->state === $destination->state) {
            return self::REGIONAL;
        }

        if ($origin->district != $destination->district && $origin->state != $destination->state) {
            return self::NATIONAL;
        }
    }

    /**
     * Calculate the distance between two cities using longitude and latitude.
     *
     * @param string $originCity
     * @param string $destinationCity
     * @return string
     */
    private function calculateDistanceBetweenCities($origin, $destination)
    {
        $origin = DB::table('cities')->where('name', $origin)->first();
        $destination = DB::table('cities')->where('name', $destination)->first();

        if (!$origin || !$destination) {
            return 251;
        }
        $distance = self::calculateDistanceUsingLatLong($origin->latitude, $origin->longitude, $destination->latitude, $destination->longitude);

        return $distance;

    }

    /**
     * Get the latitude and longitude of the cities.
     *
     * @param string $city
     * @return object
     */
    private static function getlatAndLongCities($city)
    {
        $city = DB::table('cities')->where('name', $city)->first();
        if (!$city) {
            return false;
        }
        return $city;
    }


    /**
     * Get the zone based on the distance.
     *
     * @param float $distance
     * @return string
     */
    private static function getZone($distance)
    {
        if($distance <= 50){
            return self::LOCAL;
        }elseif($distance > 50 && $distance <= 250){
            return self::REGIONAL;
        }else{
            return self::NATIONAL;
        }
    }
}