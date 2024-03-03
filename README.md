# syst-me-de-Leitner


## Project Setup





### Install dependencies

#### - Install Symfony using your favorite package installer:

**Windows via Chocolatey:**
```sh
choco install symfony-cli
```

**For the various linus distributions, check out the install directives on the [symfony website](https://symfony.com/download)**

**MacOs via homebrew:**
```sh
brew install symfony-cli/tap/symfony-cli
```


#### - Then run the following commands to install the various project symfony bundles:
```sh
composer install
```
**You should be good to go!**


### Compile and run the server

```sh
symfony serve
```

### Run Tests with

```sh
npm run test:unit:dev # or `npm run test:unit` for headless testing
```


