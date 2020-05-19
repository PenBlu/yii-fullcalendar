FullCalendar Extension
=================
Extension de FullCalendar creada por PenBlu

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist penblu/fullcalendar "*"
```

or add

```
"penblu/fullcalendar": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \penblu\fullcalendar\FullCalendar::widget([
        "containerId" => "pb-cal",
        "lang" => Yii::$app->language,
        "dataEvents" => $exam,//Json::encode(array()),
        "maxWidth" => "100%",
        "margin" => "0px auto",
        "eventClickFn" => "showEvent",
]); ?>```


# FullCalendar [![Build Status](https://travis-ci.com/fullcalendar/fullcalendar.svg?branch=master)](https://travis-ci.com/fullcalendar/fullcalendar)

A full-sized drag & drop JavaScript event calendar

- [Project website and demos](http://fullcalendar.io/)
- [Documentation](http://fullcalendar.io/docs)
- [Support](http://fullcalendar.io/support)
- [Contributing](CONTRIBUTING.md)
- [Changelog](CHANGELOG.md)
- [License](LICENSE.txt)

*From the blog*: [Changes in the Upcoming v5](https://fullcalendar.io/blog/2020/02/changes-in-the-upcoming-v5)
