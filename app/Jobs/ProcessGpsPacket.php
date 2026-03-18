<?php

namespace App\Jobs;

use App\Models\DeviceLocation;
use App\Models\LiveLocation;
use App\Services\TripService;
use App\Services\AlertService;
use App\Services\GeofenceService;
use App\Events\LocationUpdated;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessGpsPacket implements ShouldQueue
{
    use Queueable;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        try {

            $imei = $this->data['imei'];

            // server receive time (best for online/offline logic)
            $trackedAt = now();

            /* =========================
               SAVE LOCATION HISTORY
            ========================= */

            DeviceLocation::create([
                'imei'       => $imei,
                'tracked_at' => $trackedAt,
                'latitude'   => $this->data['latitude'],
                'longitude'  => $this->data['longitude'],
                'speed'      => $this->data['speed'],
                'course'     => $this->data['course'],
                'ignition'   => $this->data['ignition'],
                'gps_valid'  => $this->data['gps_valid'],
            ]);

            /* =========================
               UPDATE LIVE LOCATION
            ========================= */

            LiveLocation::updateOrCreate(
                ['imei' => $imei],
                [
                    'latitude'   => $this->data['latitude'],
                    'longitude'  => $this->data['longitude'],
                    'speed'      => $this->data['speed'],
                    'course'     => $this->data['course'],
                    'ignition'   => $this->data['ignition'],
                    'gps_valid'  => $this->data['gps_valid'],
                    'tracked_at' => $trackedAt,
                ]
            );

            /* =========================
               TRIP DETECTION
            ========================= */

            // TripService::detect($this->data);

            /* =========================
               ENGINE ALERTS
            ========================= */

            // AlertService::engine($this->data);

            /* =========================
               GEOFENCE CHECK
            ========================= */

            // GeofenceService::check($this->data);

            /* =========================
               WEBSOCKET BROADCAST
            ========================= */

            event(new LocationUpdated([
                'imei'      => $imei,
                'latitude'  => $this->data['latitude'],
                'longitude' => $this->data['longitude'],
                'speed'     => $this->data['speed'],
                'ignition'  => $this->data['ignition'],
                'tracked_at'=> $trackedAt
            ]));

        } catch (\Exception $e) {

            Log::error("GPS JOB ERROR: ".$e->getMessage());

        }
    }
}
