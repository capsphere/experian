# capsphere/experian

## Getting Started

#### Environment
Make sure to have a `.vscode` folder with a `launch.json` file corresponding to the below for debugging:

```
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9003,
            "pathMappings": {
                "C:\\$PATH_TO_WORKSPACE": "${workspaceFolder}"
            }
        }
    ]
}
```

### Dependencies

Make sure you're on PHP 7.4 or 8, and that you have PHPUnit as a dependency.

```
composer update
composer install
```

If you are trying to import the dependency into your codebase, make sure you create a Pesonal Access Token (PAT) on github. Copy the value and type: 

```
composer config --global --auth github-oauth.github.com <<INSERT TOKEN>>
```

Add the following to your composer.json:

```
{
    "require": {
        "capsphere/experian": "dev-master"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:capsphere/experian.git"
        }
    ]
}
```

### Running Tests

To run the unit tests, type this in the console:

```
.\vendor\bin\phpunit .\tests
```