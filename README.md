Gamepoint
======

## Requirements
- Git 
- Docker

---

## Installation
Clone the project into a folder:
```
$ git clone https://github.com/kaspervrind/gamepointdemo.git
```

Start the application (as a deamon proces `-d`):
```
$ docker-compose up -d
```

---

## Service 1: Import the CSV data
1. Copy the csv data to the `tmp` folder in the project
2. Import the data with:

```
$ docker-compose exec demo /app/bin/console app:import-payment-data /app/tmp/[ your CSV data file]
```

Default will the current data be overwritten


## Export the database content

## Service 2: Show the data
Open the page http://localhost in your browser


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
o Non-EURcurrenciesareconvertedtoEURbasedoncurrent exchange rate. Hardcoding the exchange rates is an acceptable approach.

### Notes
In your implementation, you can assume:
- Values in the country column conform to specs of ISO 3166-1 Alpha-2
- Values in the currency column conform to spec of ISO 4217 Bonus points
- Your solution is able to be reused and / or extended for future similar / broader use cases. ( Think modular )
- Your solution is scalable and thus can handle a CSV containing tens of thousands entries, with minimal performance loss.
- Exchange rate fetched from Public API / composer package. Expected delivery format
- Two directories, one for each service, named however you prefer. Additional directories (e.g. for a shared service) are fine.
- A dump (.sql or alternative extension, depending on choice) for Service 1 table.
- Feel free to add a .README for any rationales, comments or instructions. Good luck!

