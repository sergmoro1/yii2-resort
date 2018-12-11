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

