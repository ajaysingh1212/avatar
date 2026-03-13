<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

protected $fillable = [

'id',
'title',
'custom_notification',
'alert_message',
'project_status',
'address',
'description',

// General
'app_name',
'time_zone',
'date_format',
'default_language',
'tracking_interval',
'enable_tracking',

// Device
'enable_gps_tracking',
'enable_background_tracking',
'device_id',
'phone_number',
'user_id',
'imei',
'device_model',
'os_version',
'last_active_time',
'battery_status',

// Location
'gps_accuracy_level',
'location_update_interval',
'geofence_radius',
'enable_geofencing',
'allowed_location_area',
'latitude',
'longitude',
'location_history_limit',

// Alerts
'low_battery_alert',
'out_of_area_alert',
'device_offline_alert',
'emergency_sos_alert',
'email_notification_enable',
'sms_notification_enable',
'push_notification_enable',

// Security
'data_encryption_enable',
'location_history_retention',
'user_consent_required',
'admin_access_control',
'api_key',
'token_expiry_time',

// Map
'map_provider',
'map_api_key',
'default_zoom_level',
'map_theme',

// Logs
'enable_tracking_logs',
'log_retention_period',
'export_report',
'daily_tracking_report_enable',

// Integration
'sms_gateway_api',
'email_smtp_settings',
'firebase_push_key',
'third_party_tracking_api'

];


/*
|--------------------------------------------------------------------------
| Media Relation
|--------------------------------------------------------------------------
*/

public function media()
{
return $this->morphMany(Media::class,'model','model_type','model_id');
}


/*
|--------------------------------------------------------------------------
| Logo Relation
|--------------------------------------------------------------------------
*/

public function logo()
{
return $this->morphOne(Media::class,'model','model_type','model_id')
->where('collection_name','logo');
}

}
