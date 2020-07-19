# LaravelMongoSP
Service Provider to support Mongo DB operations in Laravel

I built this because I needed it. Report bugs so I can fix it. Send documentation if you feel like it.

### Requirements:
`MongoDB PHP driver`


|   Version  |   Laravel    |       Fixes        |  Release Date |
|------------|:------------:|:------------------:|--------------:|
|   1.7.0    |      7       | +Laravel 7 support | July 19, 2020 |

### Installation:
1. Place files/folders in their respective directories in laravel installation (/path/to/laravel).
2. Append the mongoDB service provider (App\Providers\MongoServiceProvider::class) to the 'providers' array in /path/to/laravel/config/app.php.
3. Update `.env` with mongoDB settings:
  - MONGO_USER=,
  - MONGO_PASSWORD=
  - MONGO_HOST=
  - MONGO_PORT=
  - MONGO_SRV=FALSE
  - MONGO_SSL=TRUE
  - MONGO_DATABASE=
  - MONGO_AUTH_SOURCE=
  - MONGO_OPTIONS=
