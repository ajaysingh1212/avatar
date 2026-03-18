<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Device;
use App\Jobs\ProcessGpsPacket;

class Gt06TcpServer extends Command
{
    protected $signature = 'gt06:listen {--port=5023}';
    protected $description = 'GT06 GPS TCP Server';

    protected $clients = [];

    public function handle()
    {
        set_time_limit(0);

        $host = "0.0.0.0";
        $port = (int)$this->option('port');

        $server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        socket_set_option($server, SOL_SOCKET, SO_REUSEADDR, 1);

        socket_bind($server, $host, $port);

        socket_listen($server);

        $this->info("🚀 GT06 TCP Server started on port {$port}");

        while (true) {

            $client = socket_accept($server);

            socket_getpeername($client, $ip);

            $this->info("DEVICE CONNECTED : ".$ip);

            while ($data = socket_read($client, 2048)) {

                $hex = strtoupper(bin2hex($data));

                $this->line("\n━━━━━━━━ PACKET RECEIVED ━━━━━━━━");
                $this->line("DEVICE IP : ".$ip);
                $this->line("RAW HEX   : ".$hex);

                if(substr($hex,0,4)!="7878"){
                    continue;
                }

                $protocol = substr($hex,6,2);

                /*
                ======================
                LOGIN PACKET
                ======================
                */

                if($protocol=="01"){

                    $imeiHex = substr($hex,8,16);

                    $imei = $this->decodeImei($imeiHex);

                    $this->clients[$ip] = $imei;

                    Device::firstOrCreate([
                        'imei'=>$imei
                    ]);

                    $this->info("LOGIN SUCCESS");
                    $this->line("IMEI : ".$imei);

                    $serial = substr($hex,-8,4);

                    $ack = "78780501".$serial."D9DC0D0A";

                    socket_write($client,hex2bin($ack));

                    continue;
                }

                /*
                ======================
                HEARTBEAT
                ======================
                */

                if($protocol=="13"){

                    $imei = $this->clients[$ip] ?? "UNKNOWN";

                    $this->line("HEARTBEAT FROM : ".$imei);

                    $serial = substr($hex,-8,4);

                    $ack = "78780513".$serial."D9DC0D0A";

                    socket_write($client,hex2bin($ack));

                    continue;
                }

                /*
                ======================
                LOCATION PACKET
                ======================
                */

                if($protocol=="22"){

                    $imei = $this->clients[$ip] ?? null;

                    if(!$imei){

                        $this->error("IMEI NOT FOUND → waiting login packet");

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

                    if($speed>180){
                        $speed=0;
                    }

                    $trackedAt = Carbon::parse($time);

                    ProcessGpsPacket::dispatch([
                        'imei'=>$imei,
                        'tracked_at'=>$trackedAt,
                        'latitude'=>$lat,
                        'longitude'=>$lng,
                        'speed'=>$speed,
                        'course'=>$course,
                        'ignition'=>$ignition,
                        'gps_valid'=>$gpsValid
                    ]);

                    $this->line("IMEI      : ".$imei);
                    $this->line("LAT/LNG   : ".$lat." , ".$lng);
                    $this->line("SPEED     : ".$speed." km/h");
                    $this->line("IGNITION  : ".($ignition?"ON":"OFF"));
                    $this->line("TIME      : ".$trackedAt);

                    $serial = substr($hex,-8,4);

                    $ack = "78780522".$serial."D9DC0D0A";

                    socket_write($client,hex2bin($ack));

                    continue;
                }
            }

            socket_close($client);
        }
    }

    /*
    ======================
    HELPERS
    ======================
    */

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
}
