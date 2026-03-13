<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Device;
use App\Models\DeviceLocation;
use App\Models\LiveLocation;
use App\Events\LocationUpdated;
use Carbon\Carbon;

class Gt06TcpServer extends Command
{
    protected $signature = 'gt06:listen {--port=5023}';
    protected $description = 'GT06 GPS TCP Listener';

    public function handle()
    {
        set_time_limit(0);

        $host = "0.0.0.0";
        $port = (int)$this->option('port');

        $server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        socket_set_option($server, SOL_SOCKET, SO_REUSEADDR, 1);

        socket_bind($server, $host, $port);
        socket_listen($server);

        $this->info("🚀 GT06 TCP Server running on port {$port}");

        while(true){

            $client = socket_accept($server);

            socket_getpeername($client,$ip);

            $data = socket_read($client,2048);

            if(!$data){
                socket_close($client);
                continue;
            }

            $hex = strtoupper(bin2hex($data));

            $this->line("RAW HEX : ".$hex);

            /* HEADER CHECK */

            if(substr($hex,0,4)!='7878'){
                socket_close($client);
                continue;
            }

            $protocol = substr($hex,6,2);

            /*
            ===================================
            LOGIN PACKET
            ===================================
            */

            if($protocol=="01"){

                $imeiHex = substr($hex,8,16);

                $imei = $this->decodeImei($imeiHex);

                if(!$imei){
                    socket_close($client);
                    continue;
                }

                Device::firstOrCreate([
                    'imei'=>$imei
                ]);

                $this->info("📱 LOGIN SUCCESS : ".$imei);

                $ack = hex2bin('787805010001D9DC0D0A');

                socket_write($client,$ack);

                socket_close($client);

                continue;
            }

            /*
            ===================================
            HEARTBEAT PACKET
            ===================================
            */

            if($protocol=="13"){

                $this->line("❤️ HEARTBEAT RECEIVED");

                $ack = hex2bin('787805130001D9DC0D0A');

                socket_write($client,$ack);

                socket_close($client);

                continue;
            }

            /*
            ===================================
            LOCATION PACKET
            ===================================
            */

            if($protocol=="22"){

                $imei = $this->extractImei($hex);

                if(!$imei){
                    socket_close($client);
                    continue;
                }

                $time = $this->decodeDate(substr($hex,8,12));

                $lat = $this->decodeCoord(substr($hex,20,8));
                $lng = $this->decodeCoord(substr($hex,28,8));

                $speed = hexdec(substr($hex,36,2));

                $courseStatus = hexdec(substr($hex,38,4));

                $course = $courseStatus & 0x03FF;

                $ignition = ($courseStatus & 0x0400)!=0;

                $gpsValid = ($courseStatus & 0x8000)!=0;

                if(!$gpsValid){
                    socket_close($client);
                    continue;
                }

                if($speed > 180){
                    $speed = 0;
                }

                $trackedAt = Carbon::parse($time);

                /*
                SAVE HISTORY
                */

                DeviceLocation::create([
                    'imei'=>$imei,
                    'tracked_at'=>$trackedAt,
                    'latitude'=>$lat,
                    'longitude'=>$lng,
                    'speed'=>$speed,
                    'course'=>$course,
                    'ignition'=>$ignition,
                    'gps_valid'=>true
                ]);

                /*
                UPDATE LIVE LOCATION
                */

                LiveLocation::updateOrCreate(

                    ['imei'=>$imei],

                    [
                        'latitude'=>$lat,
                        'longitude'=>$lng,
                        'speed'=>$speed,
                        'course'=>$course,
                        'ignition'=>$ignition,
                        'gps_valid'=>true,
                        'tracked_at'=>$trackedAt
                    ]
                );

                /*
                WEBSOCKET BROADCAST
                */

                event(new LocationUpdated([
                    'imei'=>$imei,
                    'latitude'=>$lat,
                    'longitude'=>$lng,
                    'speed'=>$speed,
                    'ignition'=>$ignition,
                    'tracked_at'=>$trackedAt
                ]));

                /*
                TERMINAL LOG
                */

                $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
                $this->info("📡 GPS LOCATION RECEIVED");
                $this->line("IMEI     : ".$imei);
                $this->line("LAT/LNG  : ".$lat." , ".$lng);
                $this->line("SPEED    : ".$speed." km/h");
                $this->line("IGNITION : ".($ignition ? "ON":"OFF"));
                $this->line("TIME     : ".$trackedAt);
                $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");

                $ack = hex2bin('787805220001D9DC0D0A');

                socket_write($client,$ack);

                socket_close($client);

                continue;
            }

            socket_close($client);
        }
    }

    /* ================= HELPERS ================= */

    private function decodeImei($hex)
    {
        $imei='';

        for($i=0;$i<strlen($hex);$i+=2){

            $imei .= str_pad(hexdec(substr($hex,$i,2)),2,'0',STR_PAD_LEFT);
        }

        return substr($imei,0,15);
    }

    private function decodeCoord($hex)
    {
        return round((hexdec($hex)/30000)/60,6);
    }

    private function decodeDate($hex)
    {
        return sprintf(
            "20%02d-%02d-%02d %02d:%02d:%02d",
            hexdec(substr($hex,0,2)),
            hexdec(substr($hex,2,2)),
            hexdec(substr($hex,4,2)),
            hexdec(substr($hex,6,2)),
            hexdec(substr($hex,8,2)),
            hexdec(substr($hex,10,2))
        );
    }

    private function extractImei($hex)
    {
        $pos = strpos($hex,'0D0A');

        if($pos === false) return null;

        $imeiHex = substr($hex,$pos-18,16);

        return $this->decodeImei($imeiHex);
    }
}
