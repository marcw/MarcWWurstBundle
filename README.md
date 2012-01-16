# Wurst bundle.

Prints a nice wurst to your shell. <img src="http://emos.plurk.com/398156630934194ac9929b55f5ff9638_w28_h48.gif" />

## Installation

Installation is a quick (I promise!) 3 step process:

1. Download MarcWWurstBundle
2. Configure the Autoloader
3. Enable the Bundle

### Step 1: Download MarcWWurstBundle

Ultimately, the MarcWWurstBundle files should be downloaded to the
`vendor/bundles/MarcW/Bundle/WurstBundle` directory.

This can be done in several ways, depending on your preference. The first
method is the standard Symfony2 method.

**Using the vendors script**

Add the following lines in your `deps` file:

```
[MarcWWurstBundle]
    git=git://github.com/marcw/MarcWWurstBundle.git
    target=bundles/MarcW/Bundle/WurstBundle
```

Now, run the vendors script to download the bundle:

``` bash
$ php bin/vendors install
```

**Using submodules**

If you prefer instead to use git submodules, then run the following:

``` bash
$ git submodule add git://github.com/marcw/MarcWWurstBundle.git vendor/bundles/MarcW/Bundle/WurstBundle
$ git submodule update --init
```

### Step 2: Configure the Autoloader

Add the `MarcW` namespace to your autoloader:

``` php
<?php
// app/autoload.php

$loader->registerNamespaces(array(
    // ...
    'MarcW' => __DIR__.'/../vendor/bundles',
));
```

### Step 3: Enable the bundle

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
