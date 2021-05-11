Resource System
===============

[![Build Status](https://github.com/FiveLab/Resoure/workflows/Testing/badge.svg?branch=master)](https://github.com/FiveLab/Resource/actions)

Add functionality for work with resources in you application and serialize this resources to any formats.

Support formats:

* WebAPI - simple JSON/XML structure.
* [HATEOAS](https://en.wikipedia.org/wiki/HATEOAS)
* [VndError](https://github.com/blongden/vnd.error)

Requirements
------------

* PHP 7.4 or higher

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

Problem
-------

More web applications use API (Application Programming Interface) with difference result structures. It's difficult 
for developers and clients (who use this API) because each developer can return any data (JSON or XML).
And in more cases, applications does not support media types and return JSON data with any `Content-Type` header.

And in most cases, developers use real entities from database for map to JSON (as an example `symfony/serializer`). 
This work funny, because one entity in backend application can representation to many resources for clients. As an example:
we have `User` entity with more data. If user authorized, we must return all data, but if user not logged, we must
return less data (`id` and `avatar` as an example). Yes, more people speak what we have a group system, 
but what will happen if I say that we should have more than 100 groups? Yes, in large application it's real case.

In this library we try to resolve all issue related with API.

> Note: we don't speak - `API`, we must speak - `Resource`, 
> because all operations (create, edit, delete, etc...) are performed on one resource (`Blog` as an example).

Solution
--------

1. Full isolate between model in database and resource for representation.
   Model from database convert to resource via `Assembler`.
   `Blog -> Assembler -> BlogResource`. By this we can create any resources for one model in database. 
   (For `Blog` as example: `BlogResoure`, `PremiumBlogResoure`, `HotBlogResource`, etc...). 
   We don't use group system for separate, we have a separate assembler for each resource. 
2. We full support [media type](https://en.wikipedia.org/wiki/Media_type) (`Content-Type/Accept`). 
   If client accept `json`, we return `json`, if client accept `xml`, we return `xml` 
   (but previously we must configure it ;) ). And - one resource, many formats ;)
   
> Note: in our library we use `symfony/serializer` with custom normalizers and additional functionality.
> As result, all you custom normalizers/denormaizers will be normal work with our library. 

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

