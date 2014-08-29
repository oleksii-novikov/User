User
=========

##Module for ZF2
It uses 
- Doctrine 2
- [BjyAuthorize](https://github.com/bjyoungblood/BjyAuthorize) for authorization

Version
----

1.0

Installation
--------------

```sh
git clone [git-repo-url] user
cd user
#install composer
composer install
cp -r User/ path/to/zf2/module/
```

####Add following lines to config/autoload/bjyauthorize.global.php
```php
return array(
    'bjyauthorize' => array(
            'default_role' => 'guest',
            'identity_provider' => 'User\Provider\Identity\DoctrineProvider',
            'role_providers'        => array(
                'BjyAuthorize\Provider\Role\Config' => array(
                    'guest' => [],
                    'user'  => ['children' => array(
                        'admin' => [],
                    )],
                ),
            )
        )
    )
```

####In module config add next factories config
```php
return array(
    'factories' => array(
        'mail.transport' => function (ServiceManager $serviceManager) {
            //return smtp transport...
        },
        'mail.message' => function (ServiceManager $serviceManager) {
            //return message
        }
    )
)
```
####Activate next modules in specified order in application.config.php
```php
return array(
    'modules' => array(
		//...
        'DoctrineModule',
        'DoctrineORMModule',
        'BjyAuthorize',
        'User'
    )
	//...
)
```



License
----

MIT


**Free Software, Hell Yeah!**