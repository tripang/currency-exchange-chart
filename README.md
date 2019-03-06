# currency-exchange-chart

Clone the project

    cd projects/
    git clone https://github.com/tripang/currency-exchange-chart.git
    cd currency-exchange-chart
    composer install

db_user, db_password, path to db and db_name should be changed. Find and customize this inside .env:

    DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"

Update DB:

    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate

Download and unzip Historical reference rates

    wget "https://www.ecb.europa.eu/stats/eurofxref/eurofxref-hist.zip"
    unzip eurofxref-hist.zip

Save rates history to Database:

    php bin/console app:load-rates-history
    rm eurofxref-hist.zip eurofxref-hist.csv

Run the server

    php bin/console server:run

See the chart: http://localhost:8000/currency-exchange/show
