<h1>Yii2 module for resort rooms & price management.</h1>

<h2>Advantages</h2>
The definition of rooms by category. 
Description of rooms, services provided. Determination of prices for rooms depending on the category, food, treatment. 

<h2>Installation</h2>

After installation <a href='https://github.com/yiisoft/yii2-app-advanced/blob/master/docs/guide/start-installation.md'>Yii2 advanced template</a>.

<h3>Change project composer file</h3>

Package has dev-master version and depends on the same packages, so

In app directory change <code>composer.json</code>:

<pre>
  "minimum-stability": "dev",
  "prefer-stable": true,
</pre>

<h3>Install package</h3>

<pre>
$ composer require --prefer-dist sergmoro1/yii2-resort "dev-master"
</pre>

<h3>Init yii2-blog-tools</h3>

Blog init, run all migrations and configs as explained in <a href='https://github.com/sergmoro1/yii2-blog-tools'>Yii2-blog-tools</a>. 

<h3>Run migrations</h3>

<pre>
$ php yii migrate --migrationPath=@vendor/sergmoro1/yii2-resort/src/migrations
</pre>

<h3>Copy predefined files to appropriate folders</h3>

In app directory:

<pre>
$ cp ./vendor/sergmoro1/yii2-resort/src/initresort ./
$ php initresort
$ chmod -R 777 ./frontend/web/files
</pre>

<h3>Config</h3>

Change <code>common/config/main.php</code>.

<pre>
<?php
return [
  ...
  'modules' => [
    ...
    'resort' => ['class' => 'sergmoro1\resort\Module'],
    'slide' => ['class' => 'sergmoro1\slide\Module'],
	],
</pre>

Replace default <code>frontend/config/main.php</code>.

<pre>
<?php  
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
</pre>

<h2>Start</h2>

Enter <code>http://your-app/backend/web</code> and <code>Login</code>.
