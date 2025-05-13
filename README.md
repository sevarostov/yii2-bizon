# yii2-bizon
Travel service for business trips
=======
```clone project
   git clone git@github.com:sevarostov/yii2-bizon.git 
```

```copy .env file
   cp .env.example .env
```

REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 7.4.

### Install with Docker

Update your vendor packages

    docker-compose run --rm php composer update --prefer-dist
    
Run the installation triggers (creating cookie validation code)

    docker-compose run --rm php composer install    
    
Start the container

    docker-compose up -d
    
You can then access the application through the following URL:

    http://127.0.0.1:8000

**NOTES:** 
- Minimum required Docker engine version `17.04` for development (see [Performance tuning for volume mounts](https://docs.docker.com/docker-for-mac/osxfs-caching/))
- The default configuration uses a host-volume in your home directory `.docker-composer` for composer caches


```run migrations
   yii migrate
```
