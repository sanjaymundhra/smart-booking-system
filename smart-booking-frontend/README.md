### **Smart Booking System**

### **Backend Requirements**

* PHP 8.1+
* Composer
* MySQL 5.7+
* Mailpit (for local email testing)

### **Frontend Requirements**

* Node.js 22+
* npm

### Clone the Repo

git clone git@github.com:sanjaymundhra/smart-booking-system.git
cd smart-booking

### BackEnd Setup (Laravel))

##### Install dependencies

```
Install dependencies
```

##### Create .env File

```
cp .env.example .env
```

##### Set up database details in .env

```
DB_DATABASE=smartbooking
DB_USERNAME=root
DB_PASSWORD=
```

##### Configure Mailpit (recommended for local Email testing)

```
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@smartbooking.test"
MAIL_FROM_NAME="Smart Booking"
```

##### Set up queue worker to database in .env

```
QUEUE_CONNECTION=database
```

##### Database Setup (Mysql)

```
CREATE DATABASE smartbooking;
```

##### Run migrations + seeders

```

php artisan migrate --seed
```

##### Start Queue Worker

```
php artisan queue:work

```

##### Start Mailpit (local email testing)

```
Run below commands in terminal

sudo sh < <(curl -sL https://raw.githubusercontent.com/axllent/mailpit/develop/install.sh)

/usr/local/bin/mailpit

```

Mailpit starts at  [http://localhost:8025]()

##### Start Backend Server

```
php artisan serve
```

Server starts at [http://127.0.0.1:8000/api]()

### Frontend Setup (Vue + Vite)

```
cd smart-booking-frontend
```

##### Install dependencies:

```
npm install
```

##### Start frontend dev server

npm run dev

Forntend runs at  [http://localhost:5173/]()
