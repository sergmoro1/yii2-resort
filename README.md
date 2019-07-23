Yii2 module for resort rooms & price management
===============================================

Advantages
----------

The definition of rooms by category. 
Description of rooms, services provided. Determination of prices for rooms depending on the category, food, treatment. 

Installation
------------

After installation [Yii2 advanced template](https://github.com/yiisoft/yii2-app-advanced/blob/master/docs/guide/start-installation.md).

1. Change project composer file.

Package has dev-master version and depends on the same packages, so in app directory change `composer.json`.

```
  "minimum-stability": "dev",
  "prefer-stable": true,
```

2. Install package.

The preferred way to install this extension is through composer.

Either run

`composer require --prefer-dist sergmoro1/yii2-resort`

or add

`"sergmoro1/yii2-blog-tools": "dev-master"`

to the require section of your composer.json.

3. Init yii2-blog-tools

Blog init and configs as explained in [sergmoro1/yii2-blog-tools](https://github.com/sergmoro1/yii2-blog-tools). 

4. Run migration

`php yii migrate --migrationPath=@vendor/sergmoro1/yii2-resort/src/migrations`

5. Copy predefined files to appropriate folders by bathch file `initresort`

To get it make a command in app directory.

```
cp ./vendor/sergmoro1/yii2-resort/src/initresort ./
php initresort
```
To start the application, you need to determine the names of buildings of your hotel, room categories, accommodation options, food. 
As an example, you can run a migration.

6. Prepare and run migration use an example

`php yii migrate --migrationPath=@app/migrations/resort`

Configuration
-------------

Change `common/config/main.php`.

```php
return [
  ...
  'modules' => [
    ...
    'resort' => ['class' => 'sergmoro1\resort\Module'],
    'slide' => ['class' => 'sergmoro1\slide\Module'],
    ],
```

Replace default `frontend/config/main.php`.

```php
return [
  'email' => [
    'admin' => 'admin@your-site.ru',
    'contact' => 'admin@your-site.ru',
  ],
  'commentsPerPage' => 5,
  'authorShow' => true,
  // Header menu (example)
  'header-menu' => [
    'items' => [
      ['label' => 'Service', 'title' => 'About your serveces', 'url' => ['site/index']],
      ['label' => 'Blog', 'title' => 'Posts about ...', 'url' => ['post/index']],
      ['label' => 'Feedback', 'title' => 'Send us a short message by email', 'url' => ['site/feedback']],
    ],
  ],
  // Footer menus (example)
  'footer-menu' => [
    'first' => [
      ['label' => 'Service', 'title' => 'About your serveces', 'url' => ['site/index']],
      ['label' => 'Blog', 'title' => 'Posts about ...', 'url' => ['post/index']],
    ],
    'second' => [
      ['label' => 'Feedback', 'title' => 'Send us a short message by email', 'url' => ['site/feedback']],
    ],
  ],
  // fab fa-$icons[$id] fa-stack-1x fa-inverse
  'icons' => [
    'yandex' => 'yandex',
    'vkontakte' => 'vk',
  ],
  'common' => [
    'slides' => [
      ['id' => 1, 'caption' => 'Реклама'],
      ['id' => 2, 'caption' => 'Характерная черта'],
      ['id' => 3, 'caption' => 'Ключевая услуга'],
    ],
    // Description format
    // Title # Subtitle # Slogan # Link
    'highlights' => ['h4', 'p', 'small', 'b', 'p', 'small'],
  ],
];
```

Start
-----

Enter `http://your-app/backend/web` and `Login`.
