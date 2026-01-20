# Scratch Wikis
This repository contains the MediaWiki installation used by the [Scratch Wikis](https://scratch-wiki.info).

## Prerequisites
- Latest Apache 2
- PHP version compatible with currently supported MediaWiki version

## Setup (production)
1. Clone the repo:
```
# Or some other location; absolute path required
REPO=/home/user/web
git clone --recurse-submodules https://github.com/InternationalScratchWiki/wikis $REPO
cd $REPO
```
2. Obtain a clone of `config/private`.
3. `make`
4. Configure your `%{DOCUMENT_ROOT}` to point to `$REPO/wiki`.
5. `pushd config; for subdomain in */; do mkdir -p ../wiki/w/images/$subdomain ../cache/$subdomain; done; popd`

## Setup (local)
Note that a local clone will always be a fork because your `config/private` repo will be different than production and your local does not use the same domain as production. You can never merge your fork into the base repository.
1. Fork this repository on GitHub.
2. Production step 1, replacing the GitHub URL with yours.
3. `git remote add upstream https://github.com/InternationalScratchWiki/wikis`
4. `pushd config/private; git init; popd`
5. Provide the following `config/private` files:
    - `CommonSettings.php` - containing `$swgDB`, `$wgUpgradeKey`, and `$wgSecretKey` - see below
    - `.htaccess` - containing any private Apache configuration, such as `Deny from` rules
6. Commit these files in both `config/private` and your fork.
7. (This is the annoying part) Change all references to `scratch-wiki` to your own domain (watch out for usages in regex).
8. Production steps 3 onwards.

### `config/private/CommonSettings.php`
```php
<?php
$swgDB = [
	'wiki-subdomain' => [
		'name' => (used for $wgDBname),
		'user' => (used for $wgDBuser),
		'password' => (used for $wgDBpassword),
		'prefix' => (used for $wgDBprefix),
		'charset' => ('utf8' or 'binary'),
		'uploadHashing' => (used for $wgHashedUploadDirectory),
	],
	...
]; // not immediately indexed; CS needs all of this for foreign file repos
$wgSecretKey = [
	'wiki-subdomain' => (secret key),
    ...
][$wiki];
$wgUpgradeKey = [
	'wiki-subdomain' => (upgrade key),
    ...
][$wiki];
```

## Adding a wiki
In the extremely infrequent event that a new wiki is to be added, the following must be done to support it:
* Add its subdomain to the `WIKIS` variable in `Makefile` and then run `make`.
* Add rewrite rules to `.htaccess` in the same format as those for existing wikis and then run `make`.
* Create its database and add its credentials to `config/private`.
* Generate its `$wgUpgradeKey` and `$wgSecretKey` and add them to `config/private`.
