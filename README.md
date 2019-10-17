# AutoPaginator

A simple extension to the [Zend Paginator](https://framework.zend.com/manual/1.12/en/zend.paginator.html), providing a 
way to automatically iterate through items of all remaining pages.

## Usage

You can initialize and use it exactly as the default paginator, for example:

```php
$adapter = new Zend_Paginator_Adapter_DbSelect($db->select()->from('table_name'));
$paginator = new Avltree\AutoPaginator($adapter);

foreach ($paginator as $item) {
    // Do something with the item
}
```

## Requirements

* PHP 5.5 (requires generator support)
* For testing purposes:
  * GNU Make
  * Docker with docker-compose, since test are designed to be run within a container

## Testing

Run `make test` to run tests on the library.

## Known issues

Because the first version of Zend Framework maintains compatibility with php 5.2, the base library does not use late
static binding in its `factory` static method. Using it to initialize the auto pager will instead return an instance of
the base class.
