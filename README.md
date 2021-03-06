Resource System
===============

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e421183b-e493-4b40-a63a-87ff64c8a0b0/mini.png)](https://insight.sensiolabs.com/projects/e421183b-e493-4b40-a63a-87ff64c8a0b0)
[![Build Status](https://api.travis-ci.org/FiveLab/Resource.svg?branch=master)](https://travis-ci.org/FiveLab/Resource)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/FiveLab/Resource/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/FiveLab/Resource/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/FiveLab/Resource/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/FiveLab/Resource/?branch=master)

Add functionality for work with resources in you application and serialize this resources to any formats.

Support formats:

* WebAPI
* HATEOAS

Requirements
------------

* PHP 7.1 or higher

Installation
------------

Add Resource package in your composer.json:

````json
{
    "require": {
        "fivelab/resource": "~1.0"
    }
}
````

Now tell composer to download the library by running the command:

```shell script
php composer.phar update fivelab/resource
```

Documentation
----------

The source of the documentation is stored in the `docs` folder in this package:

[Read the Documentation](docs/index.md)

License
-------

This library is under the MIT license. See the complete license in library

```
LICENSE
```

Development
-----------

For easy development you can use our `Dockerfile`:

```shell script
docker build -t fivelab-resource .
docker run -it -v $(pwd):/code fivelab-resource bash
```

After run docker container, please install vendors:

```shell script
composer install
```

Reporting an issue or a feature request
---------------------------------------

Issues and feature requests are tracked in the [Github issue tracker](https://github.com/FiveLab/Resource/issues).

Contributors:
-------------

Thanks to [everyone participating](https://github.com/FiveLab/Resource/graphs/contributors) in the development of this Resource library!

