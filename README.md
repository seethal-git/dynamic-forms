# Laravel Dynamic Forms

## Prerequisites
Before starting, ensure you have the following installed on your machine:
- PHP 8.2 or higher
- Composer
- Laravel CLI
- Git

## Setup Instructions

### Clone the Repository
Clone the project repository using Git:

git clone [<repository-url>](https://github.com/Manojk-1989/role-management.git)

### Navigate to the Project Directory
Change your current directory to the project directory:

cd <project-directory>

### Install Dependencies
Install the project dependencies using Composer:

composer install

### Setup Environment Variables
Create a `.env` file by copying the example environment file:

cp .env.example .env

Generate a new application key:

php artisan key:generate

### Run Database Migrations (Optional)
If your project requires database setup, run the migrations:
php artisan migrate


### Run Seeder 
php artisan migrate:refresh --seed

### Serve the Application
Start the Laravel development server:

php artisan serve

The application should now be running at `http://localhost:8000`.

## Dynamic Form Creation

### Admin Login using username:admin@gmail.com,password:admin@123
1. After successful login we will go to Dashboard.
2. Use the Create Dynamic Form Menu for Form creation.
3. Note: Uncomment the email notification job code in the FormController, and ensure valid Mailtrap credentials are set in the .env file. Run 'php artisan queue:work' to process queued jobs.
4. Created forms get listed on the Forms List
5. In the Forms List we have the provision to edit and Delete the created form
6. Public have the provision to view the created form
7. click on the created form we will see a form
8. Submit data on the form 
9. Response will be saved



## License
This project is licensed under the MIT License. See the LICENSE file for details.

---

Replace `<repository-url>` and `<project-directory>` with the actual URL of the repository and the name of your project directory respectively. Adjust any other configuration details as necessary for your specific project.
