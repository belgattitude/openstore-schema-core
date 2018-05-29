# CONTRIBUTING

## Recommended workflow

### Step 1: Make your own fork.

1. Setup a [GitHub account](https://github.com/), if you haven't yet.
2. Fork the project (i.e from the github project page). 
3. Clone your newly created fork: 

```shell
$ git clone https://github.com/<username>/openstore-schema-core.git`
```

4. Install deps

```shell
$ composer update
```

### Step 2: Configure your working copy

Make a copy of the [distribution config file](https://github.com/belgattitude/openstore-schema-core/blob/master/config/openstore-schema-core.config.php.dist) and
edit your database parameters:

```shell
$ cp ./config/openstore-schema-core.config.php.dist ./config/openstore-schema-core.config.php
# Edit database parameters
$ vi ./config/openstore-schema-core.config.php
```

### Step 3: Create the db and apply the schema

```shell
$ mysql -e "CREATE DATABASE openstore_test CHARACTER SET='utf8mb4' COLLATE='utf8mb4_unicode_ci';" -u {USER} -p
```

```shell
$ ./bin/openstore-schema-core openstore:schema:create
```

### Step 4: Create a branch to make an addition or fix

1. Create a new branch from master (i.e. name your branch like `feature/24` or `hotfix/25`)
2. Make the code changes...
3. Good to check the schema diff:

```shell
$ ./bin/openstore-schema-core openstore:schema:update
```

### Step 5: When happy, release a P/R (pull request)

1. First ensure the code is clean

```shell
$ composer cs-fix
$ composer phpstan
```

2. Don't forget to generate raw sql

```shell
$ composer generate-sql
```

3. Don't forget to update the `CHANGELOG.md`

4. Commit/push your changes. 
