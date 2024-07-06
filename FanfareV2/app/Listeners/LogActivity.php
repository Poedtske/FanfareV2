<?php
namespace App\Listeners;

use App\Events;
use App\Functions\UserFunctions;
use Illuminate\Http\Request;
use Illuminate\Auth\Events as LaravelEvents;
use Illuminate\Support\Facades\Log;

class LogActivity
{
    public function login(LaravelEvents\Login $event)
    {
        $ip = request()->getClientIp(true);
        UserFunctions::log("User {$event->user->email} logged in from {$ip}",$event->user);
        // $this->info($event, "User {$event->user->email} logged in from {$ip}", $event->user->email);
    }

    public function logout(LaravelEvents\Logout $event)
    {
        $ip =  request()->getClientIp(true);
        UserFunctions::log("User {$event->user->email} logged out from {$ip}", $event->user);
        // $this->info($event, "User {$event->user->email} logged out from {$ip}", $event->user->email);
    }

    public function registered(LaravelEvents\Registered $event)
    {
        $ip =  request()->getClientIp(true);
        UserFunctions::log("User registered: {$event->user->email} from {$ip}", $event->user);
        // $this->info($event, "User registered: {$event->user->email} from {$ip}");
    }

    public function failed(LaravelEvents\Failed $event)
    {
        $ip =  request()->getClientIp(true);
        UserFunctions::warning("User {$event->credentials['email']} login failed from {$ip}", ['email' => $event->credentials['email']]);
        // $this->info($event, "User {$event->credentials['email']} login failed from {$ip}", ['email' => $event->credentials['email']]);
    }

    public function passwordReset(LaravelEvents\PasswordReset $event)
    {
        $ip =  request()->getClientIp(true);
        UserFunctions::log("User {$event->user->email} password has been reset from {$ip}", $event->user);
        // $this->info($event, "User {$event->user->email} password reset from {$ip}", $event->user->email);
    }

    protected function info(object $event, string $message, array $context = [])
    {
        //$class = class_basename($event::class);
        $class = get_class($event);

        Log::info("[{$class}] {$message}", $context);
    }
}
