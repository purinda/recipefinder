# Fridge Test - News Ltd.

## Design decisions
    - Repository pattern is used in order to abstract out the datastorage. All objects behave as isolated entities without having to know about the database backend used.
      As a result storage method used can be easily switched just by introducing a new type of obj repositories and modifying the StorageProvider. Specially in this test
      we deal with two types of data storage formats, CSV and JSON.
    - Specification pattern is used for modular single-responsibility validation purposes.
    -

## Mistakes

# How to run the application & tests

## The App

## Tests
