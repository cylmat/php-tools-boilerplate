###############
# Composer v2 #
###############

Available commands:
  about                Shows the short information about Composer.
  archive              Creates an archive of this composer package.
  browse               Opens the package's repository URL or homepage in your browser.
  cc                   Clears composer's internal package cache.
  check-platform-reqs  Check that platform requirements are satisfied.
  clear[-]cache        Clears composer's internal package cache.
  config               Sets config options.
  create-project       Creates new project from a package into given directory.
  depends              Shows which packages cause the given package to be installed.
  diagnose             Diagnoses the system to identify common errors.
  dump[-]autoload      Dumps the autoloader.
  exec                 Executes a vendored binary/script.
  fund                 Discover how to help fund the maintenance of your dependencies.
  global               Allows running commands in the global composer dir ($COMPOSER_HOME).
  help                 Displays help for a command
  home                 Opens the package's repository URL or homepage in your browser.
  info                 Shows information about packages.
  init                 Creates a basic composer.json file in current directory.
  (i)nstall            Installs the project dependencies from the composer.lock file if present, or falls back on the composer.json.
  licenses             Shows information about licenses of dependencies.
  list                 Lists commands
  outdated             Shows a list of installed packages that have updates available, including their latest version.
  prohibits            Shows which packages prevent the given package from being installed.
  remove               Removes a package from the require or require-dev.
  require              Adds required packages to your composer.json and installs them.
  run                  Runs the scripts defined in composer.json.
  run-script           Runs the scripts defined in composer.json.
  search               Searches for packages.
  self[-]update        Updates composer.phar to the latest version.
  serve                Runs the serve script as defined in composer.json.
  show                 Shows information about packages.
    --(i)nstalled --locked --(p)latform --(P)ath --(t)ree --(o)utdated --(s)elf --working-(d)ir
  status               Shows a list of locally modified packages.
  suggests             Shows package suggestions.
  (u)pdate             Upgrades your dependencies to the latest version according to composer.json, and updates the composer.lock file.
  upgrade              Upgrades your dependencies to the latest version according to composer.json, and updates the composer.lock file.
  validate             Validates a composer.json and composer.lock.
  why                  Shows which packages cause the given package to be installed.
  why-not              Shows which packages prevent the given package from being installed.


# Installs
php composer-setup.php --install-dir=bin --filename=composer && mv composer.phar /usr/local/bin/composer

# Schema
require: php, ext-<name>, lib-<name>

####################
#     Schema       #
####################
name, description, version, keywords, homepage, readme, time
- type (library, project, metapackage, composer-plugin)
- "license": "(LGPL-2.1-only or GPL-3.0-or-later)" | (array)
- authors (name, email, homepage, role, etc...)
- support (email, irc, forum, wiki, rss, chat, etc...)
- funding (type=patreon|tidelift, url)

#########
# Links #
#########
require, require-dev, conflict, replace, suggest, autoload

# require
constraint@stability, ex: 
"monolog/monolog": "1.0.*@beta",
"monolog/monolog": "dev-master#2eb0c0978d290<commit>4hgf56",
"php" : "^5.5 || ^7.0",
"ext-mbstring": "*"
"lib-uuid":"3"

# autoload: psr-4, psr-0, classmap, files
ex: Acme\Foo\ => "src/"
PSR-0 : look Acme\Foo\Bar into src/Acme/Foo/Bar.php (full directory structure)
PSR-4 : look Acme\Foo\Bar into src/Bar.php (shorter)

"psr-4": { "Monolog\\": ["src/", "lib/"] }
"psr-0": { "": "src/", "Vendor\\Namespace\\": "src/" }
"classmap": { ["src/addons/*/lib/", "3rd-party/*", "Something.php"] } (support wildcard)
  "exclude-from-classmap": ["/Tests/", "/test/", "/tests/"]
"files": ["src/MyLibrary/functions.php"]

"autoload-dev": {
        "psr-4": { "MyLibrary\\Tests\\": "tests/" }
    }

- conflict: "<1.0 || >=1.1"
- replace: self.version
- suggest: "monolog/monolog": "<description> Allows more advanced logging of the application flow"

########
# others
- deprecated: include-path, target-dir
- minimum-stability: dev, alpha, beta, RC, stable(default)
- "prefer-stable": true
- archive : {
  "name": "Strange_name",
  "exclude": ["/foo/bar", "baz", "/*.test", "!/foo/bar/baz"]
}
- abandoned: "true"
- "non-feature-branches": ["latest-.*"]



########################
# Repositories (custom)
########################
dist (package) and src (sources in dev)
# types
  - composer: packages.json via network contain a list of composer.json, with dist/source 
  - vcs: fetch from git, svn, fossil and hg
  - packages
    "vendor/package-name": {
        "dev-master": { @composer.json },

# sample
   "type": "composer",
        "url": "https://myownpackages.example.com",
        "options": {
            "ssl": {
                "verify_peer": "true"
            }
        }
  "type": "package", 
      "package": {
          "name": "smarty/smarty",
          "version": "3.1.7",
          "dist": {
              "url": "https://www.smarty.net/files/Smarty-3.1.7.zip",
              "type": "zip"
          },
          "source": {
              "url": "https://smarty-php.googlecode.com/svn/",
              "type": "svn",
              "reference": "tags/Smarty_3_1_7/distribution/"
          }
          "provider-includes": {
              "providers-a.json": {
                  "sha256": "f5b4bc0b354108ef08614e569c1ed01a2782e67641744864a74e788982886f4c"
              },
              "providers-b.json": {
                  "sha256": "b38372163fac0573053536f5b8ef11b86f804ea8b016d239e706191203f6efac"
              }
    },
    "providers-url": "/p/%package%$%hash%.json"
      }
- notify-batch

# sample with own lib
  "require": {
        "vendor/my-private-repo": "dev-master"
    },
    "repositories": [
        {
            "type": "vcs",
            "url":  "git@bitbucket.org:vendor/my-private-repo.git"
        }
    ]

# local
    "repositories": [
      {
        "packagist.org": false
      },
        {
            "type": "path",
            "url": "../../packages/my-package"
        }
    ],
    "require": {
        "my/package": "*"
    }

##########
# config #
# https://getcomposer.org/doc/06-config.md
##########
process-timeout (can be disabled in script section: "Composer\\Config::disableProcessTimeout" or "process-timeout": 0)
use-include-path: (php include path)
preferred-install: source, dist, [auto]
store-auths (authorisations) true(always), false, [prompt] (every time)
github-protocols : ["https", "ssh", "git"]
github-oauth / gitlab-oauth / gitlab-token / bitbucket-oauth / bearer: ex {"github.com": "oauthtoken"}
disable-tls: false  /  secure-http: true   /   cafile, capath   /   htaccess-protect: true
http-basic: {"example.org": {"username": "alice", "password": "foo"}}
platform (emulate fake one): {"php": "7.0.3", "ext-something": "4.0.3"}
platform-check: true (php & ext), false, [php-only]
vendor-dir [vendor] / bin-dir [vendor-bin] / data-dir [$home] / cache-dir [$home/cache] / archive-dir [.]
cache-files-dir / cache-repo-dir / cache-vcs-dir / cache-file-ttl / cache-file-maxsize / cache-read-only
bin-compat : [auto], full (both win and linux)
prepend-autoloader: [true]   /   autoloader-suffix: [null] (random)
optimize-autoloader: [false]  /  sort-packages: [false]  /  apcu-autoloader: [false]
classmap-authoritative: [false] (true for classmap only)
github-domains ["github.com"]  /  github-expose-hostname [true]  /  gitlab-domains ["gitlab.com"]
use-github-api [true]  / no-api: false
notify-on-install [true]  /  discard-changes: true, stash, [false]
lock: true   /   archive-format: tar

# PROD only
# Optimize (transforme PSR to hard class-map)
1)classmap generation
2a)authoritative classmap
2b)apcu cache
config: "optimize-autoloader": true / "classmap-authoritative": true / "apcu-autoloader": true
install/update --(o)ptimize-autoloader --classmap-(a)uthoritative --apcu-autoloader
dump-autoload --(o)ptimize --classmap-(a)uthoritative --apcu

########
# script
########
- Command 
pre(post)-install(update)(status)(archive)-cmd: occurs before the install command is executed with a lock file present.
pre(post)-autoload-dump: the autoloader is dumped, either during install/update
post-root-package-install: occurs after the root package has been installed
post-create-project-cmd: occurs after the create-project command has been executed.

- Installer
pre-operations-exec: occurs before the install/upgrade/.. operations are executed when installing a lock file.

- Package
pre(post)-package-install(update)(uninstall): occurs before a package is installed.

- Plugin
init: occurs after a Composer instance is done being initialized.
command: occurs before any Composer Command is executed on the CLI. It provides you with access to the input and output objects of the program.
pre(post)-file-download: occurs before files are downloaded and allows you to manipulate the HttpDownloader
pre-command-run: occurs before a command is executed and allows you to manipulate the InputInterface object's options 
pre-pool-create: occurs before the Pool of packages is created, and lets you filter the list of packages which is going to enter the Solver.

ex: 
  "scripts": {
      "post-update-cmd": "MyVendor\\MyClass::postUpdate",
      "post-package-install": [
          "MyVendor\\MyClass::postPackageInstall"
      ],
      "post-install-cmd": [
          "MyVendor\\MyClass::warmCache",
          "phpunit -c app/"
      ],
      "post-autoload-dump": [
          "MyVendor\\MyClass::postAutoloadDump"
      ],
      "post-create-project-cmd": [
          "php -r \"copy('config/local-example.php', 'config/local.php');\""
      ],

      # -> REFERENCE
      "test": [
            "@clearCache -vvv",  #self
            "@composer install", #composer instance
            "@php script.php",   #php instance
            "@putenv COMPOSER=phpstan-composer.json",
            "phpunit"
        ],
        "clearCache": "rm -rf cache/*"
  }
  "scripts-descriptions": {
        "test": "Run all tests!"  # composer list or composer run -l
    }

- Fired EVENTS in php (will be in COMPOSER_DEV_MODE if no --no-dev provided)
ex: Composer\EventDispatcher\Event or Composer\Plugin\PostFileDownloadEvent
$event->getComposer()->getConfig()->get('vendor-dir');
$event->getOperation()->getPackage();

- extra
  used with $extra = $event->getComposer()->getPackage()->getExtra();

########### 
# runtime #
###########
\Composer\InstalledVersions::isInstalled('vendor/package'); // returns bool
\Composer\InstalledVersions::isInstalled('psr/log-implementation'); // returns bool

# with  "composer/semver": "^2.0"
use Composer\Semver\VersionParser;
\Composer\InstalledVersions::satisfies(new VersionParser, 'vendor/package', '2.0.*');
\Composer\InstalledVersions::satisfies(new VersionParser, 'psr/log-implementation', '^1.0');
\Composer\InstalledVersions::getVersion('vendor/package');
\Composer\InstalledVersions::getReference('vendor/package');
$loader->addPsr4('Acme\\Test\\', __DIR__);


#########
# version
# ref: https://semver.org/lang/fr/
# test: https://semver.mwl.be
#########
# release life-cycle
pre-alpha (nightly build, dev release), alpha (white-box/code testing, pre-black-box testing)
beta (pre-release to user, black-box/functionnal testing, demo, preview)
rc (release-candidate / "going silver", pass all tests, minor bugs, no features to add now)
Rtm (release to manufacture/marketing / "going gold", send to mass copy)

# version constraint
"dev-*<branch_name>" or "<x.x.tag>*-dev": specific branch (ex: v1.x-dev or dev-myfeature)
"monolog/monolog": "1.0.*@beta",
"monolog/monolog": "dev-master#2eb0c0978d290<commit>4hgf56",

- range ("," or " " equal "and")
ex: ">=1.0, <1.1 || >=1.2"
"1.0.*" equiv to ">=1.0 <1.1"

- hyphen (inclusive)
"1.0 - 2.0" equivalent to ">=1.0.0 <2.0.*"

- tilde (next significant release)
"~1.2"    equiv to ">=1.2 <2.0.0"
"~1.2.3"  equiv to ">=1.2.3 <1.3.0"
"~1.2" don't install "2.0-beta.1" (the ~1 doesn't change)

- caret (all above)
"^1.2.3" equiv to ">=1.2.3 <2.0.0"

#############
#    CLI    #
#############
- init --name --description --author --type --homepage --require foo/bar:1.0.0 --require-dev 
          --(s)tability --license --repository

- install --prefer-source --prefer-dist --dry-run --(no-)dev --no-autoloader --no-scripts --optimize-autoloader --ignore-platform-reqs
          --no-progress --classmap-authoritative --apcu-autoloader --apcu-autoloader-prefix --ignore-platform-req
- update --lock --with foo/bar:1.0.0 --with(out)-dependencies --prefer-stable
- require --dry-run
- search --only-name <monolog>
- show <monolog/*>
- config --(l)ist --(g)lobal --(a)uth --(e)ditor --absolute --json --merge
    ex: php composer.phar config --json extra.foo.bar '{"baz": true, "qux": []}'
- create-project (git clone && composer install)
- dump-autoload --no-scripts --(o)ptimize --classmap-(a)uthoritative --apcu(-prefix) --no-dev --ignore-platform-req(s)
- depends / prohibits (why cannot install ?) <package> --(r)ecursive --(t)ree
- run-script --timeout --(no-)dev --(l)ist
- exec (exec a bin/script.sh) --list
- archive: "php composer.phar archive vendor/package 2.0.21 --format=zip" --dir --file

- remove / check-platform-reqs / global / outdated / status -v / license / diagnose
- browse/home / suggests / fund / validate / self-update / clear-cache 

#######
# ENV #
# prefer use of config section
# https://getcomposer.org/doc/03-cli.md#environment-variables
#######
COMPOSER: composer.json filename
COMPOSER_ALLOW_SUPERUSER: use as root
COMPOSER_ALLOW_XDEBUG
COMPOSER_AUTH: json with  http-basic, github-oauth, bitbucket-oauth, etc...
COMPOSER_BIN_DIR
COMPOSER_CACHE_DIR
COMPOSER_CAFILE
COMPOSER_DISABLE_XDEBUG_WARN
COMPOSER_DISCARD_CHANGES
COMPOSER_HOME : "/home/<user>/.composer"
    COMPOSER_HOME/config.json : set global repositories and config
COMPOSER_HTACCESS_PROTECT: [1]
COMPOSER_MEMORY_LIMIT
COMPOSER_MIRROR_PATH_REPOS (use mirror instead of symlinks)
COMPOSER_NO_INTERACTION : is like --no-interaction
COMPOSER_PROCESS_TIMEOUT : [300] (5 minutes)
COMPOSER_ROOT_VERSION : version of the root package
COMPOSER_VENDOR_DIR
http_proxy or HTTP_PROXY (declare both is best, or use git config --global http.proxy <proxy url>)
HTTP(S)_PROXY_REQUEST_FULLURI : set to 0 is proxy doesn't support request_fulluri flag
COMPOSER_SELF_UPDATE_TARGET : new self-update path (ex for read-only system)
no_proxy or NO_PROXY : (ex: *:8090)
COMPOSER_DISABLE_NETWORK : (used for debugging)
COMPOSER_DEBUG_EVENTS : (for debug)