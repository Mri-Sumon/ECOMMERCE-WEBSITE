<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use app\Models\User;
use App\Policies\CategoryPolicy;
use GuzzleHttp\Promise\Create;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //Authorization Gate এর জন্য।
        //এখানে create-category হল আমাদের দেয়া Gate এর নাম। এখানে User হল একটি মডেল। 
        // Gate::define('create-category', function (User $user) {
        //     //dd('Checking Permission');

        //     //return true করলে আমরা ক্রিয়েট পেজ এ এক্সেস পাবো।
        //     //return true;

        //     //return false করলে আমরা ক্রিয়েট পেজ এ এক্সেস পাবোনা।
        //     //return false;

        //     //একজন Authentic user এর সকল তথ্য পাবো auth()->user() এর মাধ্যমে।
        //     //dd(auth()->user());

        //     // যদি  Authentic user এর আইডি 2 হয় তাহলে ক্রিয়েট পেজ এ এক্সেস পাবে, না হলে পাবেনা।
        //     //যার role_id == 2 হবে, সেই ইউজার ক্রিয়েট বাটন দেখতে পাবে, এবং এক্সেস পাবে।
        //     //if (auth()->user()->id == 2){
        //     if (auth()->user()->role_id == 2){
        //         return true;
        //     }else{
        //         return false;
        //     }
        // });

        Gate::define('create-category', [CategoryPolicy::class, 'create']);
    }
}
