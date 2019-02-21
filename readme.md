# Settings for Temply Resources Selector

## Instructions

1. Install Package
	```php
	composer require infinety-es/temply-resources-selector
	```

2. Add a Listener in EventServiceProvider.php
	```php
	'Infinety\TemplyResourcesSelector\Events\ResourceChangedEvent' => [
        '\App\Listeners\YourListener',
    ],
    ```
3. Add the card to `NovaServiceProvider`

	```php
	use Infinety\TemplyResourcesSelector\TemplyResourcesSelector;

	//...

	new TemplyResourcesSelector())
            ->width('1/3')
            ->type('groups'),
	```