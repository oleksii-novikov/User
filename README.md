User
=========

##Module for ZF2
It uses 
- Doctrine 2
- [BjyAuthorize](https://github.com/bjyoungblood/BjyAuthorize) for ACL

Version
----

1.0

Installation
--------------

```sh
git clone [git-repo-url] user
cd user
cp -r User/ path/to/zf2/module/
```
For this time you should manually add dependencies from composer.json to yours and then run 
```sh
composer update
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