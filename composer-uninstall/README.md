# composer-uninstall.php

This file was created because at WebDevStudios we use composer to manage dependencies and shared packages. We also use Git and a `composer.json` file to manage those dependences. Well, when switching branches where that `composer.json` file changes, we can't just remove a `vendor/` folder and do `composer-install` as our packages are installed to different plugin and theme locations. 

So, normally, I would have to find those, delete them, and run `composer install` again. But, that's hard to do on large projects. So this script will find all the packages installed via `composer.json` and will go delete the folder that package is installed into.

# Installation

## Using `/usr/local/bin`

On Mac/*nix, you can download this script and save it to your `/usr/local/bin` folder as e.g. `/usr/local/bin/composer-uninstall` and run `chmod +x /usr/local/bin/composer-uninstall` and now you should be able to run `composer-uninstall` anywhere.

## Using an alias/function in Bash

If you want to either clone this repo, or download a file you can always create a `.bash_profile`-ish alias like:

```bash
function composer-uninstall {
    php "/path/to/code/composer-uninstall/composer-uninstall.php"
}

function composer-reinstall {
    composer-uninstall
    composer clear-cache
    composer install
}
```

Now running `composer-uninstall` will always run the PHP script. If you cloned my repo, you can always do a `git pull` to get the latest version of this file or re-download it to update it.
