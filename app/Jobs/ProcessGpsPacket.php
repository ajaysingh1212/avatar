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
        $imei = $this->data['imei'];

        /* =========================
           SAVE LOCATION HISTORY
        ========================= */

        DeviceLocation::create([
            'imei'       => $imei,
            'tracked_at' => $this->data['tracked_at'],
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
                'tracked_at' => $this->data['tracked_at'],
            ]
        );

        /* =========================
           TRIP DETECTION
        ========================= */

        TripService::detect($this->data);

        /* =========================
           ENGINE ALERTS
        ========================= */

        AlertService::engine($this->data);

        /* =========================
           GEOFENCE CHECK
        ========================= */

        GeofenceService::check($this->data);

        /* =========================
           WEBSOCKET BROADCAST
        ========================= */

        event(new LocationUpdated($this->data));
    }
}
