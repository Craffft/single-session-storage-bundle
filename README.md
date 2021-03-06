[![Build Status](https://travis-ci.org/Craffft/single-session-storage-bundle.svg?branch=master)](https://travis-ci.org/Craffft/single-session-storage-bundle)

Single Session Storage Bundle
=============================

Single Session Storage for Symfony

Installation
------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require craffft/single-session-storage-bundle "~1.1"
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new Craffft\SingleSessionStorageBundle\CraffftSingleSessionStorageBundle(),
        );

        // ...
    }

    // ...
}
```

Usage example
-------------

```php
<?php
// AppBundle/Controller/DemoController.php

// ...
class DemoController extends Controller
{
    public function myAction()
    {
        // Set data via service
        $singleSessionStorage = $this->container->get('craffft.single_session_storage');
        $singleSessionStorage->setNamespace('testStorage'); // optional
        $singleSessionStorage->set('key', 'value');
        $singleSessionStorage->saveSession();
        
        // Set data via class
        $singleSessionStorage = new SingleSessionStorage($this->container, 'testStorage');
        $singleSessionStorage->set('key', 'value');
        $singleSessionStorage->saveSession();
        
        // ...
    }

    // ...
}
```
