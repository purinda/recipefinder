# Fridge Test - News Ltd.

## Design decisions
* Repository pattern is used in order to abstract out the datastorage for demonstration purposes. All objects behave as isolated entities without having to know about the database backend used. As a result storage method used can be easily switched just by introducing a new type of obj repositories and modifying the StorageProvider. This pattern becomes extremely handy in real world situations where type of data can be different but business rules can still work backend-agnostically. Only queries have to be redone in the repository.
* Specification pattern is used for modular single-responsibility validation purposes. Which is used from CSV row data validation to ingredient used-by-date validation. The pattern is used to demonstrate that business rules can be encapsulated specification object while providing an application wide validation functionality. So when rules change you only have to update the object specification.

## What can be improved
* Specification pattern implementation can be improved with chainable logic operators.
* Test cases could be done better with automatic object resolution to support repository pattern implementation.

# Installation
```
composer install
```

# How to run the application
Go to the directory where project files are and then

```
php artisan serve --host=0.0.0.0 --port=8080
```

## Tests
```
phpunit --debug
```

# References
http://csv.thephpleague.com/examples/
http://huyrua.wordpress.com/2010/07/13/entity-framework-4-poco-repository-and-specification-pattern/
