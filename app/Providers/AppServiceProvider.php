<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (Schema::hasTable('settings')) {
                $mailFromAddress = Setting::get('mail_from_address');
                $mailFromName = Setting::get('mail_from_name');
                $smtpHost = Setting::get('smtp_host');
                $smtpPort = Setting::get('smtp_port');
                $smtpEncryption = Setting::get('smtp_encryption');
                $smtpUsername = Setting::get('smtp_username');
                $smtpPassword = Setting::get('smtp_password');
                $smtpTimeout = Setting::get('smtp_timeout');
                $sessionTimeout = Setting::get('session_timeout_minutes');

                if ($mailFromAddress) {
                    config(['mail.from.address' => $mailFromAddress]);
                }
                if ($mailFromName) {
                    config(['mail.from.name' => $mailFromName]);
                }
                if ($smtpHost) {
                    config(['mail.mailers.smtp.host' => $smtpHost]);
                }
                if ($smtpPort) {
                    config(['mail.mailers.smtp.port' => (int) $smtpPort]);
                }
                if ($smtpEncryption) {
                    config(['mail.mailers.smtp.encryption' => $smtpEncryption === 'none' ? null : $smtpEncryption]);
                }
                if ($smtpUsername) {
                    config(['mail.mailers.smtp.username' => $smtpUsername]);
                }
                if ($smtpPassword) {
                    config(['mail.mailers.smtp.password' => $smtpPassword]);
                }
                if ($smtpTimeout) {
                    config(['mail.mailers.smtp.timeout' => (int) $smtpTimeout]);
                }
                if ($sessionTimeout) {
                    config(['session.lifetime' => (int) $sessionTimeout]);
                }
            }
        } catch (\Exception $e) {
            // Database not available (e.g., during build-time artisan commands).
            // Silently skip loading settings from the database.
        }
    }
}
