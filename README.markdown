n1c0OfficialtextBundle
======================

Bundle to manage officialtexts.

Step 1: Setting up the bundle
-----------------------------

### A) Download and install N1c0Officialtext

To install N1c0Officialtext run the following command

``` bash
$ php composer.phar require n1c01a5/n1c0officialtext-bundle
```

### B) Enable the bundle

Enable the required bundles in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new FOS\RestBundle\FOSRestBundle(),
        new JMS\SerializerBundle\JMSSerializerBundle(),
        new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
        new Bazinga\Bundle\HateoasBundle\BazingaHateoasBundle(),
        new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
        new N1c0\OfficialtextBundle\N1c0OfficialtextBundle(),
    );
}
```
FOSRestBundle, StofDoctrineExtensionsBundle and NelmioApiDocBundle must be configured.
This bundle require the Diff implementation for PHP: "sebastian/diff": "*" (``composer.json``).

### C) Enable Http Method Override

[Enable HTTP Method override as described here](http://symfony.com/doc/master/cookbook/routing/method_parameters.html#faking-the-method-with-method)

As of symfony 2.3, you just have to modify your config.yml :

``` yaml
# app/config/config.yml

framework:
    http_method_override: true
```
    

Step 2: Setup Doctrine ORM mapping
----------------------------------

The ORM implementation does not provide a concrete Officialtext class for your use, you must create one. This can be done by extending the abstract entities provided by the bundle and creating the appropriate mappings.

For example, the officialtext entity:

``` php
<?php
// src/MyProject/MyBundle/Entity/Officialtext.php

namespace MyProject\MyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use N1c0\OfficialtextBundle\Entity\Officialtext as BaseOfficialtext;

/**
 * @ORM\Entity
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Officialtext extends BaseOfficialtext
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid", length=36)
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;
}
```
For example, the argument entity:

``` php
<?php
// src/MyProject/MyBundle/Entity/Argument.php

namespace MyProject\MyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use N1c0\OfficialtextBundle\Entity\Argument as BaseArgument;

/**
 * @ORM\Entity
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Argument extends BaseArgument
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid", length=36)
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * Officialtext of this argument
     *
     * @var Officialtext 
     * @ORM\ManyToOne(targetEntity="MyProject\MyBundle\Entity\Argument")
     */
    protected $officialtext;
}
```

Add in app/config/config.yml:
``` yaml
# N1c0OfficialtextBundle
n1c0_officialtext:
    db_driver: orm
    class:
        model:
            officialtext: MyProject\MyBundle\Entity\Officialtext
            argument: MyProject\MyBundle\Entity\Argument

entity_managers:
            default:
                mappings:
                    N1c0OfficialtextBundle: ~
                    MyBundleMyProjectBundle: ~

assetic:
    bundles:        ["N1c0OfficialtextBundle"]

```

Step 3: Import N1c0OfficialtextBundle routing files
---------------------------------------------------

```
# /app/config/routing.yml
n1c0_officialtext:
    type: rest
    prefix: /api
    resource: "@N1c0Officialtext/Resources/config/routing.yml"
```

Content negociation
-------------------

Each ressource is accessible into different formats.

HTTP verbs:

For the officialtexts:

GET:

In html format:
```
curl -i localhost:8000/api/v1/officialtexts/10
```

In json format:
```
curl -i -H "Accept: application/json" localhost:8000/api/v1/officialtexts/10
```

POST:

In html format:
```
curl -X POST -d "n1c0_officialtext_officialtext%5Btitle%5D=myTitle&n1c0_officialtext_officialtext%5Bbody%5D=myBody" http://localhost:8000/api/v1/officialtexts
```

In json format:
```
curl -X POST -d '{"n1c0_officialtext_officialtext":{"title":"myTitle","body":"myBody"}}' http://localhost:8000/api/v1/officialtexts.json --header "Content-Type:application/json" -v
```
PUT:

In json format:
```
curl -X PUT -d '{"n1c0_officialtext_officialtext":{"title":"myNewTitle","body":"myNewBody http://localhost:8000/api/v1/officialtexts/10 --header "Content-Type:application/json" -v
```
For the arguments:

GET:

In json format:
```
curl -i -H "Accept: application/json" localhost:8000/api/v1/officialtexts/10/arguments
```
POST:

In json format:
```
curl -X POST -d '{"n1c0_officialtext_argument":{"title":"myTitleArgument","body":"myBodyArgument"}}' http://localhost:8000/api/v1/officialtexts/10/arguments.json --header "Content-Type:application/json" -v
```
PUT:

In json format:
```
curl -X PUT -d '{"n1c0_officialtext_argument":{"title":"myNewTitleArgument","body":"myNewBodyArgument"}}' http://localhost:8000/api/v1/officialtexts/10/arguments/11.json --header "Content-Type:application/json" -v 
```
PATCH:

In json format:
```
curl -X PATCH -d '{"n1c0_officialtext_argument":{"title":"myNewTitleArgument"}}' http://localhost:8000/api/v1/officialtexts/10/arguments/11.json --header "Content-Type:application/json" -v
```
HATEOAS REST
============

Introduction of the HATEOAS constraint.
```
{
    "user": {
        "id": 10,
        "title": "myTitle",
        "body": "MyBody",
        "_links": {
            "self": { "href": "http://localhost:8000/api/v1/officialtexts/10" }
        }
    }
}
```

Integration with FOSUserBundle
==============================
By default, officialtexts are made anonymously.
[FOSUserBundle](http://github.com/FriendsOfSymfony/FOSUserBundle)
authentication can be used to sign the officialtexts.

### A) Setup FOSUserBundle
First you have to setup [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle). Check the [instructions](https://github.com/FriendsOfSymfony/FOSUserBundle/blob/master/Resources/doc/index.md).

### B) Extend the Officialtext class
In order to add an author to a officialtext, the Officialtext class should implement the
`SignedOfficialtextInterface` and add a field to your mapping.

For example in the ORM:

``` php
<?php
// src/MyProject/MyBundle/Entity/Officialtext.php

namespace MyProject\MyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use N1c0\OfficialtextBundle\Entity\Officialtext as BaseOfficialtext;
use N1c0\OfficialtextBundle\Model\SignedOfficialtextInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 */
class Officialtext extends BaseOfficialtext implements SignedOfficialtextInterface
{
    // .. fields

    /**
     * Authors of the officialtext
     *
     * @ORM\ManyToMany(targetEntity="Application\UserBundle\Entity\User")
     * @var User
     */
    protected $authors;

    public function __construct()
    {
        $this->authors = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add author 
     *
     * @param Application\UserBundle\Entity\User $user
     */
    public function addAuthor(\Application\UserBundle\Entity\User $user)
    {
        $this->authors[] = $user;
    }

    /**
     * Remove user
     *
     * @param Application\UserBundle\Entity\User $user
     */
    public function removeUser(\Application\UserBundle\Entity\User $user)
    {
        $this->authorss->removeElement($user);
    }

    public function getAuthors()
    {
        return $this->authors;
    }

    public function getAuthorsName()
    {
        return $this->authors ?: parent::getAuthorsName(); 
    }
}
```

Step 7: Adding role based ACL security
======================================

**Note:**

> This bundle ships with support different security setups. You can also have a look at [Adding Symfony2's built in ACL security](8-adding_symfony2s_builtin_acl_security.md).

OfficialtextBundle also provides the ability to configure permissions based on the roles
a specific user has. See the configuration example below for how to customise the
default roles used for permissions.

To configure Role based security override the Acl services:

``` yaml
# app/config/config.yml

n1c0_officialtext:
    acl: true
    service:
        acl:
            officialtext:  n1c0_officialtext.acl.officialtext.roles
        manager:
            officialtext:  n1c0_officialtext.manager.officialtext.acl
```

To change the roles required for specific actions, modify the `acl_roles` configuration
key:

``` yaml
# app/config/config.yml

n1c0_officialtext:
    acl_roles:
        officialtext:
            create: IS_AUTHENTICATED_ANONYMOUSLY
            view: IS_AUTHENTICATED_ANONYMOUSLY
            edit: ROLE_ADMIN
            delete: ROLE_ADMIN
```

Using a markup parser
=====================

N1c0Officialtext bundle allows a developer to implement RawOfficialtextInterface, which
will tell the bundle that your officialtexts are to be parsed for a markup language.

You will also need to configure a rawBody field in your database to store the parsed officialtexts.

```php
use N1c0\OfficialtextBundle\Model\RawOfficialtextInterface;

class Officialtext extends BaseOfficialtext implements RawOfficialtextInterface
{
    /**
     * @ORM\Column(name="rawBody", type="text", nullable=true)
     * @var string
     */
    protected $rawBody;
    
    ... also add getter and setter as defined in the RawOfficialtextInterface ...
}
```

When a comment is added, it is parsed and setRawBody() is called with the raw version 
of the comment which is then stored in the database and shown when the officialtext is later rendered.

Any markup language is supported, all you need is a bridging class that
implements `Markup\ParserInterface` and returns the parsed result of a officialtext
in raw html to be displayed on the page.

To set up your own custom markup parser, you are required to define a service
that implements the above interface, and to tell N1c0OfficialtextBundle about it,
adjust the configuration accordingly.

``` yaml
# app/config/config.yml

n1c0_officialtext:
    service:
        markup: your_markup_service
```

For example using the Sundown PECL extension as Markup service
==============================================================

The markup system in N1c0OfficialtextBundle is flexible and allows you to use any
syntax language that a parser exists for. PECL has an extension for markdown
parsing called Sundown, which is faster than pure PHP implementations of a
markdown parser.

N1c0OfficialtextBundle doesnt ship with a bridge for this extension, but it is
trivial to implement.

First, you will need to use PECL to install Sundown. `pecl install sundown`.

You will want to create the service below in one of your application bundles.

``` php
<?php
// src/Vendor/OfficialtextBundle/Markup/Sundown.php

namespace Vendor\OfficialtextBundle\Markup;

use N1c0\OfficialtextBundle\Markup\ParserInterface;
use Sundown\Markdown;

class Sundown implements ParserInterface
{
    private $parser;

    protected function getParser()
    {
        if (null === $this->parser) {
            $this->parser = new Markdown(
                new \Sundown\Render\HTML(array('filter_html' => true)),
                array('autolink' => true)
            );
        }

        return $this->parser;
    }

    public function parse($raw)
    {
        return $this->getParser()->render($raw);
    }
}
```

And the service definition to enable this parser bridge

``` yaml
# app/config/config.yml

services:
    # ...
    markup.sundown_markdown:
        class: Vendor\OfficialtextBundle\Markup\Sundown
    # ...

n1c0_officialtext:
    # ...
    service:
        markup: markup.sundown_markdown
    # ...
```

An other example, using Pandoc as Markup service
================================================

Pandoc is a Haskell program that allows you to convert documents from one format to another. See more in [Pandoc](http://johnmacfarlane.net/pandoc/index.html).

To install Pandoc run this following command
``` bash
$ apt-get install pandoc
```
For more information on the installation of Pandoc, see [Pandoc installation](http://johnmacfarlane.net/pandoc/installing.html).

And we need a naive PHP Wrapper.
The recommended method to installing Pandoc PHP is with [composer](http://getcomposer.org)

```json
{
    "require": {
        "ryakad/pandoc-php": "dev-master"
    }
}
```
Once installed you can create a service markup like

``` php
<?php

namespace vendor\OfficialtextBundle\Markup;

use N1c0\OfficialtextBundle\Markup\ParserInterface;
use Pandoc\Pandoc;

class MarkupPandoc implements ParserInterface
{
    private $parser;

    protected function getParser()
    {
        if (null === $this->parser) {
            $this->parser = new Pandoc();        
        }

        return $this->parser;
    }

    public function parse($raw)
    {
        return $this->getParser()->convert($raw, "markdown", "html");
    }
}
```
And the service definition to enable this parser bridge

``` yaml
# app/config/config.yml

services:
    # ...
    markup.pandoc_markdown:
        class: Vendor\OfficialtextBundle\Markup\MarkupPandoc
    # ...

n1c0_officialtext:
    # ...
    service:
        markup: markup.pandoc_markdown
    # ...
```


Integration with FOSCommentBundle
---------------------------------

Add in ```src/MyProject/MyBundle/Resources/views/Officialtext/getOfficialtexts.html.twig```:
```
<a href="{{ path('api_1_get_officialtext_thread', {'id': officialtext.id}) }}">Commentaires</a>
```

Documentation as bonus (NelmioApiDocBundle)
-------------------------------------------

Go to http://localhost:8000/api/doc.
