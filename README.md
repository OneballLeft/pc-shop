# TechPC Store - Custom PC Sales Website

A complete e-commerce website for selling custom-built computers, featuring user authentication, dynamic product catalog, shopping cart functionality, and modern responsive design.

## Project Overview

TechPC Store is a full-featured website built with HTML, CSS, PHP, and JavaScript that represents a business selling custom-built PCs. The website includes 9 pages with complete functionality for browsing products, user authentication, and managing purchases.

## Technologies Used

- **HTML5** - Structure and content
- **CSS3** - Modern/minimal styling with responsive design
- **PHP** - Server-side logic and database interactions
- **MySQL** - Database management
- **JavaScript** - Interactive elements and form validation

## Features

### User Authentication
- User registration with validation
- Secure login system with password hashing
- Session management
- User dashboard with account information

### Product Management
- Dynamic product catalog from database
- Category filtering
- Product detail pages with specifications
- Stock availability tracking
- Featured products on homepage

### Shopping Cart
- Add/remove items from cart
- Update quantities
- Cart persistence per user
- Simple checkout system

### Additional Features
- Contact form with database storage
- About page with company information
- Responsive navigation with mobile menu
- Modern, clean UI design
- Interactive JavaScript elements
- Form validation
- Auto-dismissing alerts

## Pages (9 Total)

1. **index.php** - Home page with featured products and company highlights
2. **products.php** - Product catalog with category filtering
3. **product-detail.php** - Individual product details and add to cart
4. **login.php** - User login
5. **register.php** - User registration
6. **cart.php** - Shopping cart management
7. **dashboard.php** - User dashboard with order history
8. **about.php** - About the company
9. **contact.php** - Contact form

## Project Structure

```
web_design_project/
├── index.php                 # Home page (entry point)
├── README.md                 # Project documentation
├── .htaccess                 # Apache configuration
└── src/                      # Source files directory
    ├── products.php          # Product catalog
    ├── product-detail.php    # Product details
    ├── login.php             # Login page
    ├── register.php          # Registration page
    ├── cart.php              # Shopping cart
    ├── dashboard.php         # User dashboard
    ├── about.php             # About page
    ├── contact.php           # Contact page
    ├── logout.php            # Logout handler
    ├── database.sql          # Database schema and sample data
    ├── css/
    │   └── style.css        # Main stylesheet
    ├── js/
    │   └── main.js          # JavaScript functionality
    └── includes/
        ├── config.php       # Database configuration
        ├── header.php       # Header component
        └── footer.php       # Footer component
```

## Installation Instructions

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher / MariaDB
- PHP mysqli extension
- Apache/Nginx web server (optional)
- phpMyAdmin (optional, for database management)

### Setup Steps

1. **Clone or Download the Project**
   ```bash
   cd /path/to/your/projects
   # Project files should be in this directory
   ```

2. **Enable PHP mysqli Extension**

   Check if mysqli is installed:
   ```bash
   php -m | grep mysqli
   ```

   If not installed, enable it in your php.ini file:
   ```bash
   php --ini  # Find your php.ini location
   ```

   Edit php.ini and uncomment (remove the `;` before):
   ```ini
   extension=mysqli
   extension=pdo_mysql
   ```

   Verify installation:
   ```bash
   php -m | grep -E "(mysqli|pdo_mysql)"
   ```

3. **Start MySQL/MariaDB Service**
   ```bash
   # For systemd-based systems (Arch, Ubuntu, etc.)
   sudo systemctl start mysql    # or mariadb
   sudo systemctl enable mysql   # Start on boot
   ```

4. **Create Database and User**

   Open MariaDB/MySQL as root:
   ```bash
   sudo mariadb
   # or: sudo mysql
   ```

   Run these commands in the database console:
   ```sql
   CREATE DATABASE pc_store;
   CREATE USER 'pc_user'@'localhost' IDENTIFIED BY 'your_password';
   GRANT ALL PRIVILEGES ON pc_store.* TO 'pc_user'@'localhost';
   FLUSH PRIVILEGES;
   USE pc_store;
   SOURCE /full/path/to/web_design_project/src/database.sql;
   EXIT;
   ```

   Replace `/full/path/to/web_design_project/` with your actual project path.

5. **Configure Database Connection**

   Open `src/includes/config.php` and update the credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'pc_user');           // User we created
   define('DB_PASS', 'your_password');     // Password you set
   define('DB_NAME', 'pc_store');
   ```

6. **Set Permissions (Linux/Mac)**
   ```bash
   chmod 755 /path/to/web_design_project
   chmod 644 /path/to/web_design_project/*.php
   ```

7. **Start the PHP Development Server**
   ```bash
   cd /path/to/web_design_project
   php -S localhost:8080
   ```

   Alternative - Using XAMPP/WAMP:
   - Start Apache and MySQL services
   - Access via `http://localhost/web_design_project/`

8. **Access the Website**
   - Open your browser and navigate to:
     - `http://localhost:8080/` (PHP built-in server)
     - `http://localhost/web_design_project/` (Apache/Nginx)

### Troubleshooting

**mysqli_connect() error:**
- Ensure mysqli extension is enabled in php.ini
- Check that MySQL/MariaDB service is running: `systemctl status mysql`

**Access denied for user 'root'@'localhost':**
- Use the database user created in step 4 (pc_user)
- Verify credentials in `includes/config.php`

**Port already in use:**
- Use a different port: `php -S localhost:8081`

**Database connection failed:**
- Verify MySQL/MariaDB is running
- Check database name and user privileges
- Ensure database.sql was imported successfully

## Database Schema

The website uses 5 main tables:

### users
- `id` - Primary key
- `username` - Unique username
- `email` - Unique email address
- `password` - Hashed password
- `full_name` - User's full name
- `created_at` - Registration timestamp

### products
- `id` - Primary key
- `name` - Product name
- `description` - Product description
- `specifications` - Technical specifications
- `price` - Product price
- `image` - Image filename
- `category` - Product category (Gaming, Office, Professional)
- `stock` - Available quantity
- `featured` - Featured product flag
- `created_at` - Creation timestamp

### cart
- `id` - Primary key
- `user_id` - Foreign key to users
- `product_id` - Foreign key to products
- `quantity` - Item quantity
- `added_at` - Addition timestamp

### orders
- `id` - Primary key
- `user_id` - Foreign key to users
- `total_amount` - Order total
- `status` - Order status
- `created_at` - Order timestamp

### contact_messages
- `id` - Primary key
- `name` - Sender name
- `email` - Sender email
- `subject` - Message subject
- `message` - Message content
- `created_at` - Submission timestamp

## Sample Data

The database includes 8 sample products:
- Gaming PC Pro ($2,999.99)
- Office Workstation ($1,299.99)
- Creator Studio ($3,499.99)
- Budget Gaming ($899.99)
- Mini PC Compact ($799.99)
- Extreme Workstation ($7,999.99)
- Student Special ($499.99)
- Streaming Beast ($2,299.99)

## Usage Guide

### For Customers

1. **Browse Products**
   - Visit the home page to see featured products
   - Navigate to Products page to view all items
   - Filter by category (Gaming, Office, Professional)

2. **Create Account**
   - Click "Sign Up" in the navigation
   - Fill out registration form
   - Login with your credentials

3. **Shopping**
   - Click on product to view details
   - Add items to cart (requires login)
   - Manage quantities in cart
   - Proceed to checkout

4. **View Orders**
   - Access Dashboard to see order history
   - View account information
   - Check cart items count

### For Administrators

To manage products, users, and orders:
- Access the database directly through phpMyAdmin
- Or create an admin panel (future enhancement)

## Security Features

- Password hashing using PHP's `password_hash()`
- SQL injection prevention with `mysqli_real_escape_string()`
- Session-based authentication
- Input validation on both client and server side
- CSRF protection through session management

## Design Features

### Modern/Minimal Design
- Clean typography using system fonts
- Subtle shadows and rounded corners
- Minimalist color palette (navy, blue, red accents)
- Ample whitespace
- Smooth transitions and animations

### Responsive Design
- Mobile-first approach
- Hamburger menu for mobile devices
- Flexible grid layouts
- Responsive typography
- Touch-friendly buttons

### Interactive Elements
- Mobile menu toggle
- Form validation with real-time feedback
- Smooth scrolling
- Product card hover effects
- Auto-dismissing alerts
- Scroll-to-top button
- Quantity input controls

## Future Enhancements

Potential features to add:
- Admin panel for product management
- Advanced search functionality
- Product reviews and ratings
- Wishlist functionality
- Email notifications
- Payment gateway integration
- Order tracking system
- Image upload for products
- Multi-image gallery for products
- Password reset functionality
- User profile editing
- Advanced filtering (price range, specifications)

## Browser Compatibility

Tested and compatible with:
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Credits

**Developer:** Web Design Project
**Purpose:** Educational/Portfolio Project
**Year:** 2025

## License

This project is created for educational purposes.

## Support

For issues or questions about this project:
- Review the code comments
- Check database connection settings
- Verify PHP and MySQL versions
- Ensure all files are in correct directories

## Contact

For more information about this project, please refer to the contact page of the website.
