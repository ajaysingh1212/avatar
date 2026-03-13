<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {

            // General
            $table->string('app_name')->nullable();
            $table->string('time_zone')->nullable();
            $table->string('date_format')->nullable();
            $table->string('default_language')->nullable();
            $table->integer('tracking_interval')->nullable();
            $table->boolean('enable_tracking')->default(true);

            // Device Tracking
            $table->boolean('enable_gps_tracking')->default(true);
            $table->boolean('enable_background_tracking')->default(true);
            $table->string('device_id')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('user_id')->nullable();
            $table->string('imei')->nullable();
            $table->string('device_model')->nullable();
            $table->string('os_version')->nullable();
            $table->timestamp('last_active_time')->nullable();
            $table->integer('battery_status')->nullable();

            // Location
            $table->string('gps_accuracy_level')->nullable();
            $table->integer('location_update_interval')->nullable();
            $table->integer('geofence_radius')->nullable();
            $table->boolean('enable_geofencing')->default(false);
            $table->text('allowed_location_area')->nullable();
            $table->decimal('latitude',10,7)->nullable();
            $table->decimal('longitude',10,7)->nullable();
            $table->integer('location_history_limit')->nullable();

            // Alerts
            $table->boolean('low_battery_alert')->default(false);
            $table->boolean('out_of_area_alert')->default(false);
            $table->boolean('device_offline_alert')->default(false);
            $table->boolean('emergency_sos_alert')->default(false);
            $table->boolean('email_notification_enable')->default(false);
            $table->boolean('sms_notification_enable')->default(false);
            $table->boolean('push_notification_enable')->default(false);

            // Security
            $table->boolean('data_encryption_enable')->default(false);
            $table->integer('location_history_retention')->nullable();
            $table->boolean('user_consent_required')->default(true);
            $table->string('admin_access_control')->nullable();
            $table->string('api_key')->nullable();
            $table->integer('token_expiry_time')->nullable();

            // Map
            $table->string('map_provider')->nullable();
            $table->string('map_api_key')->nullable();
            $table->integer('default_zoom_level')->nullable();
            $table->string('map_theme')->nullable();

            // Logs
            $table->boolean('enable_tracking_logs')->default(true);
            $table->integer('log_retention_period')->nullable();
            $table->string('export_report')->nullable();
            $table->boolean('daily_tracking_report_enable')->default(false);

            // Integration
            $table->text('sms_gateway_api')->nullable();
            $table->text('email_smtp_settings')->nullable();
            $table->text('firebase_push_key')->nullable();
            $table->text('third_party_tracking_api')->nullable();

        });
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};
