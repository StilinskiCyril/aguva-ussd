<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Aguva Ussd Package

Aguva Ussd is a modern and adaptable USSD application solution that accommodates various languages, such as English and Swahili, with the option to integrate additional languages as needed. Its syntax is clear and sophisticated, ensuring exceptional user-friendliness. Additionally, it includes a built-in USSD simulator, streamlining the debugging and upkeep of the application.

## Installation

### Run the following command
    composer require aguva/ussd:dev-main

### Publish package support files
    php artisan vendor:publish --provider="Aguva\Ussd\Providers\UssdServiceProvider" --tag=aguva-ussd-lang --force

### Run the migrations

    php artisan migrate

### Add the following variables in your root project's .env

    ## The default message displayed to users when no other response is available
    USSD_DEFAULT_MESSAGE=

    ## If set to true, only MSISDNs (phone numbers) in the whitelist are allowed to access the USSD service
    ## If false, the USSD service is open to all MSISDNs
    USSD_RESTRICT_TO_WHITELIST=

    ## If set to true, all incoming USSD request payloads from the provider will be logged for tracking and debugging
    USSD_LOG_REQUEST=

    ## A comma-separated list of MSISDNs (phone numbers) that are allowed to access the USSD service
    ## Only applicable if 'USSD_RESTRICT_TO_WHITELIST' is set to true
    USSD_WHITELIST_MSISDNS=

    ## The number of seconds to wait before ending a USSD session
    ## Some providers require a slight delay before terminating the session
    USSD_END_SESSION_SLEEP_SECONDS=

    ## The USSD code assigned by your service provider (e.g., *999#)
    USSD_CODE=

    ## The API endpoint that receives USSD request payloads from the provider
    ## This should be a valid URL where the USSD server can forward incoming requests
    USSD_ONLINE_ENDPOINT='api/process-payload/55034fd5-bd23h5d9948f'

### Create a UssdProcessor.php file in root project's app/Repositories dir & add the following boilerplate code. This is your PLAYGROUND, GO CRAZY
N/B Treat each a method as a new USSD screen instance

```php
    <?php
    namespace App\Repositories;
    use Aguva\Ussd\Repositories\Handler;

    class UssdProcessor
    {
        // Distinguish if it's a new user (first dial) or a registered user
        static function activityHome(Handler $handler, $params)
        {
            if (array_key_exists('newUser', $handler->userInput) && $handler->userInput['newUser']) {
                return self::activityHomeNewUser($handler, $params);
            }
            return self::activityHomeExistingUser($handler, $params);
        }
    
        // This is an existing user
        static function activityHomeExistingUser(Handler $handler, $params)
        {
            $handler->message = __('ussd.welcome_new_user', ['name' => $handler->user->first_name]);
            $menu = [
                1 => [
                    'text' => __('ussd.item_home'),
                    'activity' => 'activityHome',
                ],
                2 => [
                    'text' => __('ussd.item_choose_language'),
                    'activity' => 'activityChooseLanguage',
                ],
                3 => [
                    'text' => __('ussd.item_quit'),
                    'activity' => 'activityQuit',
                ]
            ];
            $handler->menuItems = $menu;
            return self::activityReturnValidMessage($handler);
        }
    
        // This is a new user
        static function activityHomeNewUser(Handler $handler, $params)
        {
            $handler->message = __('ussd.welcome_registered_user', ['name' => '']);
            $menu = [
                1 => [
                    'text' => __('ussd.item_choose_language'),
                    'activity' => 'activityChooseLanguage',
                ],
                2 => [
                    'text' => __('ussd.item_quit'),
                    'activity' => 'activityQuit',
                ]
            ];
    
            $handler->menuItems = $menu;
            return self::activityReturnValidMessage($handler);
        }
    
        // Exit the application
        static function activityQuit(Handler $handler, $params)
        {
            $handler->message = __('ussd.item_message_quit');
            $handler->end = true;
            return self::activityReturnValidMessage($handler);
        }
    
        // Choose app language
        public static function activityChooseLanguage(Handler $handler, $params)
        {
            $handler->message = __('ussd.item_choose_language');
            $languageLookUp = ['1' => 'en', '2' => 'sw'];
            $handler->userInput['localeLookup'] = $languageLookUp;
    
            $handler->menuItems = [
                '1' => [
                    'text' => __('ussd.item_language_english'),
                    'activity' => 'activityChangeLanguage'
                ],
                '2' => [
                    'text' => __('ussd.item_language_swahili'),
                    'activity' => 'activityChangeLanguage'
                ],
                '0' => [
                    'text' => __('ussd.item_navigation_home'),
                    'activity' => 'activityHome'
                ]
            ];
    
            return self::activityReturnValidMessage($handler);
        }
    
        // Change the app language
        public static function activityChangeLanguage(Handler $handler, $params)
        {
            if (!collect($handler->userInput['localeLookup'])->has($handler->ussdString)) {
                return self::activityHome($handler, $params);
            }
    
            $locale = $handler->userInput['localeLookup'][$handler->ussdString];
            $handler->user->locale = $locale;
            $handler->user->save();
    
            $handler->setLang();
    
            $handler->message = __('ussd.item_locale_saved');
    
            $handler->menuItems = [
                '0' => [
                    'text' => __('ussd.item_navigation_home'),
                    'activity' => 'activityHome'
                ]
            ];
            return self::activityReturnValidMessage($handler);
        }
    
        // Returned message
        public static function activityReturnValidMessage(Handler $handler)
        {
            if ($handler->invalidInput) {
                $handler->message = __('ussd.enter_valid_input') . " $handler->ussdString\n$handler->message";
            }
            return $handler;
        }
    
        /**
         * ALL YOUR OTHER MENUS WILL BE WRITTEN HERE... FEEL FREE TO PLAY AROUND
         */
    }
```


### Simulator URL

    The ussd simulator can be found in the url "/simulator". Kindly note that it mimics a live ussd environment meaning that you have to click "new session" button whenever you want to simulate the start of a new session.

## Queue Workers Used
Make sure you listen to the following queue(s) which is used to save ussd sessions data into the database

    save-ussd-message

You could use either of the following;
- [redis](https://laravel.com/docs/11.x/queues/)
- [beanstalkd](https://beanstalkd.github.io/)

N/B Install [horizon console](https://laravel.com/docs/11.x/horizon) or [beanstalkd console](https://github.com/ptrofimov/beanstalk_console) to help you monitor the queues & also install the necessary respective laravel packages.

### Uninstallation

    composer remove aguva/ussd

## Security Vulnerabilities

If you discover a security vulnerability within the library, please send an e-mail to [Cyril Aguvasu](mailto:aguvasucyril@gmail.com). All security vulnerabilities will be promptly addressed.

## License

This library is owned and maintained by [Cyril Aguvasu](https://github.com/StilinskiCyril)
