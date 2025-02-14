# Laravel 11 E-Commerce API

This project is a **RESTful API** for an e-commerce platform, built using **Laravel 11**. It provides various endpoints for user authentication, product management, categories, and cart functionality.

## 🚀 Features
- **User Authentication**: Register, login, and logout using **Laravel Sanctum**.
- **Product Management**: Create, update, delete, and retrieve products.
- **Category Management**: Add, update, and remove product categories.
- **Shopping Cart**: Add/remove items, view cart contents, and proceed to checkout.
- **Secure API**: Uses authentication for protected routes.

## 🛠 Technologies Used
- **Laravel 11**
- **MySQL**
- **Laravel Sanctum** (for authentication)
- **RESTful API Architecture**

## 📌 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/your-repo-name.git
   cd your-repo-name
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Set up environment variables**
   ```bash
   cp .env.example .env
   ```
   Update your `.env` file with database credentials.

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Run migrations**
   ```bash
   php artisan migrate --seed
   ```

6. **Run the application**
   ```bash
   php artisan serve
   ```

## 🔗 API Endpoints
Refer to the **API Documentation** for a detailed list of available endpoints and request/response structures.

## 📜 License
This project is licensed under the MIT License.

---

Feel free to contribute or report issues in the repository! 🚀
