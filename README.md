# PhpAb\Storage-AuraSession

Session Storage Adapter for PhpAb library based in Aura library.

## Install

Via Composer

``` bash
$ composer require phpab/storage-aurasession
```

## Usage

``` php
use PhpAb\Storage\Adapter\AuraSession;
use PhpAb\Storage\Storage;
use PhpAb\Participation\Manager;
use PhpAb\Analytics\DataCollector\Google;
use PhpAb\Event\Dispatcher;
use PhpAb\Participation\Filter\Percentage;
use PhpAb\Variant\Chooser\RandomChooser;
use PhpAb\Engine\Engine;
use PhpAb\Test\Test;
use PhpAb\Variant\SimpleVariant;
use PhpAb\Analytics\Renderer\Google\GoogleUniversalAnalytics;

// Create a Storage and its Adapter
$adapter = new AuraSession();
$storage = new Storage($adapter);

// Create a Participation Manager
$manager = new Manager($storage);

// Create a Data Collector
$analyticsData = new Google();

// Create a Dispatcher
$dispatcher = new Dispatcher();
// And append it as a subscriber
$dispatcher->addSubscriber($analyticsData);

// Create a Participation filter
$filter = new Percentage(50);
// And a Variant Chooser
$chooser = new RandomChooser();

// Create the Engine
$engine = new Engine($manager, $dispatcher, $filter, $chooser);

// Create a tests and its variants
$test = new Test('foo_test', [], [Google::EXPERIMENT_ID => 'exp1']);
$test->addVariant(new SimpleVariant('_control'));
$test->addVariant(new SimpleVariant('_variant1'));
$test->addVariant(new SimpleVariant('_variant2'));

// Create a second test and its variants
$test2 = new Test('bar_test', [], [Google::EXPERIMENT_ID => 'exp2']);
$test2->addVariant(new SimpleVariant('_control'));
$test2->addVariant(new SimpleVariant('_variant1'));
$test2->addVariant(new SimpleVariant('_variant2'));

// Add the tests to the Engine
$engine->addTest($test);
$engine->addTest($test2);

$engine->start();

// Create the Analytics object and pass the Data Collector data to it
$analytics = new GoogleUniversalAnalytics($analyticsData->getTestsData());

// Execute the Analytics functionality
var_dump($analytics->getScript());

```

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email phpab.phpab@gmail.com instead of using the issue tracker.

## Credits

- [Mariano F.co Benítez Mulet](pachicodev@gmail.com)
- [All Contributors](https://github.com/phpab/storage-aurasession/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
