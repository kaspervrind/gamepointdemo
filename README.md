Gamepoint
======

## Requirements
- Git https://git-scm.com/
- Docker https://www.docker.com/

---

## Installation
Clone the project into a folder:
```bash
git clone https://github.com/kaspervrind/gamepointdemo.git
```

Start the application (as a deamon proces `-d`):
```bash
docker-compose up -d
```

---

## Service 1: Import the CSV data
1. Copy the csv data to the `tmp` folder in the project
2. Import the data with:
```bash
docker-compose exec demo /app/bin/console app:import-payment-data [ your CSV data file]
```

## Export the database content
To export the database to an database dump run:
```bash
docker-compose exec demo /app/docker/demo/dump-database.sh
```

The postgres dump will be exported to the file `tmp/dump.sql`

## Service 2: Show the data
Open the page http://localhost in your browser

## Bonus: get the exchange rates from a public API
```bash
docker-compose exec demo /app/bin/console app:update-exchange-rates 
```

---

## Notes
The test coverage is not complete and is missing application tests. I have done this assignment in my spare time wich is scarce.
I wanted to challenge myself, so I used postgres as a database.
I've used MySQL, MariaDb, Oracle and MsSql in the past, so it was fun to experiment with a different kind of database.
Same for PHP 8, I haven't used it for work, but it's great 🚀

The docker demo container is not finished, it needs hardening and some more love but it performs.
I'm more of a Nginx fan but it was a small test to use apache again.
I wanted to move apache out of the demo container and put it in a reverse proxy but skipped this due to time.

The front-end can use some love. The twig template is not really modular.

---

## Folders
I couldn't separate the files into 2 folders because I used the Symfony framework so here is a list of files used for the 2 assignments:

Assignment 1 import the data:
* src/Command/ImportPaymentDataCommand.php
* src/Entity/Payment.php
* src/Serializer/PaymentDenormalizer.php
* config/services.yaml

Assignment 2 display the data:
* src/Controller/PaymentController.php
* src/Entity/Payment.php
* src/Repository/PaymentRepository.php
* templates/base.html.twig
* templates/payments.html.twig

Bonus: Exchange rate fetched from Public API / composer package.
* src/Command/UpdateExchangeRatesCommand.php
* src/DataFixtures/CurrencyConversionFixture.php
* src/Repository/CurrencyConversionRepository.php
* config/services.yaml

**This project is for demonstration purposes only 😀**

---



## Assignment
The provided CSV file "payments.csv" contains payments made by a variety of users, in a variety of countries.
Your challenge, if you choose to accept it, consists of two services:

### Service 1
Create a PHP script that reads the CSV file, parses it's contents and uploads these entries to a database table.
You have full freedom over the decision on database and table structure - Use whichever Server / DBMS / QL you desire. The typical choice is wamp / xampp, which comes with Apache and MySQL.

### Service 2
Create a PHP script which queries this table, retrieves it's contents, and provides a simple HTML overview of the following:
- Total revenue per currency
- Total revenue per user
- Total revenue per day
- - Non-EUR currencies are converted to EUR based on current exchange rate. Hardcoding the exchange rates is an acceptable approach.

### Notes
In your implementation, you can assume:
- Values in the country column conform to specs of ISO 3166-1 Alpha-2
- Values in the currency column conform to spec of ISO 4217 Bonus points
- Your solution is able to be reused and / or extended for future similar / broader use cases. ( Think modular )
- Your solution is scalable and thus can handle a CSV containing tens of thousands entries, with minimal performance loss.
- Exchange rate fetched from Public API / composer package. 

### Expected delivery format
- Two directories, one for each service, named however you prefer. Additional directories (e.g. for a shared service) are fine.
- A dump (.sql or alternative extension, depending on choice) for Service 1 table.
- Feel free to add a .README for any rationales, comments or instructions. Good luck!

