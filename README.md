<h1>Jack Sparrow (PHP Checkpoint 3, WCS Web PHP)</h1>

### The goal is to create a game "Jack Sparrow", with a boat where you have to find a treasure by using Symfony


---

## WCS PHP Checkpoint

![](https://static.tvtropes.org/pmwiki/pub/images/potc_monocle2.jpg)

Launch your server and read the instructions.

### Requirements

- Php ^7.2 http://php.net/manual/fr/install.php;
- Composer https://getcomposer.org/download/;

### Steps


1. Clone the repo from GitHub : `git clone git@github.com:jaldabaoth-code/Jack-Sparrow.git`

2. Enter the directory : `cd Jack-Sparrow`

3. Create an <b>.env.local</b> file, you can use <b>.env</b> as model

4. Execute the following commands in your working folder to install the project:

```bash
# Install dependencies
composer install

# Create 'checkpoint3' DB
php bin/console d:d:c

# Execute migrations and create tables
php bin/console d:m:m

# Load the fixtures in database
symfony console doctrine:fixtures:load
```

> Reminder: Don't use composer update to avoid problem

> Assets are directly into _public/_ directory, **we will not use** Webpack with this checkpoint

### Usage

Launch the server with the command below and follow the instructions on the homepage `/`;

```bash
$ symfony server:start
```

---

## The Links

<a href="https://github.com/WildCodeSchool/php_checkpoint3_orleans_march21">
Link to the repository of <b>PHP Checkpoint 3</b></a>
</br>
<a href="https://github.com/WildCodeSchool/php_checkpoint3_orleans_march21/tree/GRIALAT_ZURABI">
Link to <b>my branch</b> repository of <b>PHP Checkpoint 3</b></a>
