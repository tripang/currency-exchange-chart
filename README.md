# Test task

График изменения стоимости валюты

* Symfony 4.2
* PHP 7.3
* MySQL
* AMCHARTS 4


Клонировать проект:

    cd projects/
    git clone https://github.com/tripang/currency-exchange-chart.git
    cd currency-exchange-chart
    composer install

Изменить db_user, db_password, path to db и db_name.
Найти и править данные в .env:

    DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"

Обновить базу данных:

    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate

Выгрузить и разархивировать историю курса валют:

    wget "https://www.ecb.europa.eu/stats/eurofxref/eurofxref-hist.zip"
    unzip eurofxref-hist.zip

Сохранить историю курса валют в базу данных:

    php bin/console app:load-rates-history
    rm eurofxref-hist.zip eurofxref-hist.csv

Запустить сервер:

    php bin/console server:run

Смотрить график: http://localhost:8000/currency-exchange/show

Для обновления курса валют необходимо запускать команду.

    php bin/console app:update-rate
    
Добавьте эту команду в крон или запустите для теста вручную.
    
# English version

Currency Exchange Chart

* Symfony 4.2
* PHP 7.3
* MySQL
* AMCHARTS 4


Clone the project:

    cd projects/
    git clone https://github.com/tripang/currency-exchange-chart.git
    cd currency-exchange-chart
    composer install

db_user, db_password, path to db and db_name should be changed.
Find and customize this inside .env:

    DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"

Update DB:

    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate

Download and unzip rates History:

    wget "https://www.ecb.europa.eu/stats/eurofxref/eurofxref-hist.zip"
    unzip eurofxref-hist.zip

Save rates history to Database:

    php bin/console app:load-rates-history
    rm eurofxref-hist.zip eurofxref-hist.csv

Run the server:

    php bin/console server:run

See the chart: http://localhost:8000/currency-exchange/show

This command should be run ones a day to get new rates.
Add it to the cron on the server or execute manually for the tests: 

    php bin/console app:update-rate
