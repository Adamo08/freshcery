# Food Ordering E-commerce Store

**Food Ordering E-commerce Store** is a comprehensive e-commerce platform built with PHP, MySQL, Bootstrap, and PDO. This project provides users with the ability to browse products by categories, add items to a cart, and proceed to checkout. It also features a fully functional admin panel for managing products, categories, and orders, with integration for PayPal sandbox for payment processing.

## Features

- **User Features:**
  - Browse products by categories.
  - Add products to the shopping cart.
  - Proceed to checkout and complete purchases using PayPal.
  
- **Admin Features:**
  - Manage products (add, update, delete).
  - Manage categories (add, update, delete).
  - View and manage orders.
  - Update the status of orders.
  - Admin login and authentication.


## Technologies Used

- **Backend:**
  - PHP
  - MySQL
  - PDO for database access
  
- **Frontend:**
  - Bootstrap
  - HTML/CSS
  - JavaScript/jQuery/Ajax
  
- **Payment Integration:**
  - PayPal Sandbox for payment processing

## Installation

1. Clone the repository:
    ```bash
   git clone https://github.com/yourusername/food-ordering-ecommerce-store.git
2. Navigate to the project directory:
    ```bash
    cd food-ordering-ecommerce-store
3. Configuring & Setting the database :
    - Create a MySQL database by importing the provided SQL schema in ```database/base.sql``` .
    - Open config/config.php and update the database connection settings with your MySQL credentials (the ```DB_HOST``` constant).
4. Set up PayPal SDK:
    - Open ```charge.php``` and update the ```PayPal client ID``` and currency in the PayPal SDK script URL:
      
      ```bash
      <!-- PayPal SDK -->
      <script src="https://www.paypal.com/sdk/js?client-id=your-paypal-client-id&currency=USD"></script>
    - Replace your-paypal-client-id with your actual PayPal client ID. The currency code USD can be changed to your preferred currency code.

## License
Groceries Organic Store is licensed under The MIT License (MIT). Which means that you can use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the final products. But you always need to state that [Teguh Rianto](https://github.com/teguhrianto) is the original author of this template.

## Demo
[See DEMO](https://groceries.teguhrianto.my.id)

