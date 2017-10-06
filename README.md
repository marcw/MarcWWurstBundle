# Wurst bundle.

Prints a nice wurst to your shell. <img src="http://emos.plurk.com/398156630934194ac9929b55f5ff9638_w28_h48.gif" />

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/454f1e7a-57d3-4240-a1c1-a3875ec8bc89/mini.png)](https://insight.sensiolabs.com/projects/454f1e7a-57d3-4240-a1c1-a3875ec8bc89)
[![Total Downloads](https://poser.pugx.org/marcw/wurst-bundle/downloads.png)](https://packagist.org/packages/marcw/wurst-bundle)
[![License](https://poser.pugx.org/marcw/wurst-bundle/license.png)](https://packagist.org/packages/marcw/wurst-bundle)

## Installation

Installation is a quick (I promise!) 3 step process:

1. Download MarcWWurstBundle
2. Configure the Autoloader
3. Enable the Bundle

### Step 1: Download MarcWWurstBundle

Ultimately, the MarcWWurstBundle files should be downloaded to the
`vendor/marcw/wurst-bundle/MarcW/Bundle/WurstBundle` directory.

This can be done in several ways, depending on your preference. The first
method is the standard Symfony2 method.

**Using Composer**

Add MarcWWurstBundle in your composer.json:

``` json
{
    "require": {
        "marcw/wurst-bundle": "dev-master"
    }
}
```

``` bash
$ php composer.phar require marcw/wurst-bundle
```

**Using submodules**

If you prefer instead to use git submodules, then run the following:

``` bash
$ git submodule add git://github.com/marcw/MarcWWurstBundle.git vendor/bundles/MarcW/Bundle/WurstBundle
$ git submodule update --init
```

Note that using submodules requires manually registering the `MarcW` namespace to your autoloader:

``` php
<?php
// app/autoload.php

$loader->registerNamespaces(array(
    // ...
    'MarcW' => __DIR__.'/../vendor/bundles',
));
```

### Step 2: Enable the bundle

Finally, enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new MarcW\Bundle\WurstBundle\MarcWWurstBundle(),
    );
}
```

## Contributing

If you got some nice wurst ascii art, feel free to contribute ;)

## Credits

Big props to all the sfday 2011 attendees!
