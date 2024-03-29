# Banking Application README

This is a small banking application developed in PHP using the Laravel framework. The application facilitates various operations related to managing bank accounts. Below are the main functionalities provided by the application:

## Functionalities

1. **Registration**
   - Allows users to create a new account with an email ID and password.

2. **Login**
   - Enables users to log in to their accounts securely.

3. **Inbox/Home**
   - Displays account information such as balance, transaction history, etc.

4. **Cash Deposit**
   - Enables users to deposit a certain amount into their logged-in account.

5. **Cash Withdrawal**
   - Allows users to withdraw a certain amount from their logged-in account.

6. **Cash Transfer**
   - Facilitates transferring a certain amount from the logged-in account to another account using an email ID.

7. **Account Statement**
   - Provides users with a statement of their account transactions.

8. **Logout**
   - Allows users to securely log out of their accounts.

## Installation

To set up the application locally, follow these steps:

1. Clone this repository to your local machine.
2. Navigate to the project directory.
3. Install dependencies using Composer: `composer install`.
4. Configure your environment variables by copying the `.env.example` file to `.env` and updating it with your database and other relevant configuration details.
5. Generate a new application key: `php artisan key:generate`.
6. Create new database, name it as `banking`
7. Run database migrations: `php artisan migrate`.
8. Start the development server: `php artisan serve`.
9. Access the application in your web browser at the specified address.

## Contributing

Contributions to this project are welcome. Feel free to fork the repository, make improvements, and submit pull requests.

## License

This project is licensed under the [MIT License](LICENSE).
