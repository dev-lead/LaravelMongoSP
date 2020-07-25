# LaravelMongoSP
Service Provider to support Mongo DB operations in Laravel

I built this because I needed it. Report bugs so I can fix it. Send documentation if you feel like it.

### Requirements:
`MongoDB PHP driver`

|   Version  |   Laravel    |       Fixes        |  Release Date |
|------------|:------------:|:------------------:|--------------:|
|   1.7.0    |      7       | +Laravel 7 support | July 19, 2020 |

### Usage:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Services\MongoDB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(MongoDB $mongo)
    {
      $cursor = $mongo
        ->collection('collection_name')
        ->query(['author' => 'Stevens Cadet'])
        ->exec();

      foreach($cursor as $document) {
        //do something
          //var_dump($document);
      }
        return view('home');
    }
}
```

### Installation:
1. Place files/folders in their respective directories in laravel installation (/path/to/laravel).
2. Append the mongoDB service provider (App\Providers\MongoServiceProvider::class) to the 'providers' array in /path/to/laravel/config/app.php.
3. Update `.env` with mongoDB settings:
```s
MONGO_HOST=12.0.0.1
MONGO_PORT=27017
MONGO_USER=
MONGO_PASSWORD=
MONGO_DATABASE=
MONGO_SRV=FALSE
MONGO_OPTIONS=
```