# Archiv PHP - User Profile Management System

A simple and elegant PHP-based user profile management system with a modern interface.

## Features

- **User Profile Creation**: Create new user profiles with comprehensive information
- **Profile Viewing**: Browse all user profiles in a grid layout
- **Detailed Profile Pages**: View complete user information on dedicated profile pages
- **Secure Password Storage**: Passwords are hashed using PHP's password_hash()
- **Responsive Design**: Modern, gradient-based UI that works on all devices
- **Input Validation**: Basic validation and XSS protection using htmlspecialchars()

## User Profile Information

Each user profile includes:
- Username (required)
- Email (required)
- Password (required, securely hashed)
- First Name
- Last Name
- Bio
- Phone
- Address
- City
- Country
- Profile Picture (URL)
- Date of Birth

## Installation

### Prerequisites
- PHP 7.0 or higher
- MySQL 5.6 or higher
- Web server (Apache/Nginx)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/mo3200taha/archiv_php.git
   cd archiv_php
   ```

2. **Create the database**
   - Import the `database.sql` file into your MySQL server:
   ```bash
   mysql -u root -p < database.sql
   ```
   
   Or manually run the SQL commands in your MySQL client.

3. **Configure database connection**
   - Edit `config.php` and update the database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'archiv_php');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   ```

4. **Deploy to web server**
   - Copy all files to your web server's document root (e.g., `/var/www/html/` or `htdocs/`)
   
5. **Access the application**
   - Open your browser and navigate to `http://localhost/archiv_php/`

## Usage

### Creating a User Profile
1. Navigate to the home page (`index.php`)
2. Fill in the user profile form
   - Username, Email, and Password are required
   - Other fields are optional
3. Click "Create Profile" to save

### Viewing Profiles
1. Click "View Profiles" in the navigation
2. Browse all user profiles in the grid layout
3. Click "View Details" on any profile to see complete information

### Profile Details
- View comprehensive user information
- See profile picture (if provided)
- Access all user details in an organized layout

## File Structure

```
archiv_php/
├── config.php              # Database configuration
├── database.sql            # Database schema
├── User.php                # User class with CRUD operations
├── index.php               # User profile creation page
├── view_profile.php        # List all user profiles
├── profile_detail.php      # Detailed profile view
└── README.md              # This file
```

## Security Features

- **Password Hashing**: All passwords are hashed using PHP's `password_hash()` with bcrypt
- **XSS Protection**: User input is sanitized using `htmlspecialchars()`
- **Prepared Statements**: PDO prepared statements prevent SQL injection
- **Input Validation**: Required fields are validated before database insertion

## Technologies Used

- **Backend**: PHP with PDO
- **Database**: MySQL
- **Frontend**: HTML5, CSS3 (with gradient styling)
- **Design**: Responsive grid layout

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open source and available under the MIT License.

## Author

mo3200taha

## Support

For issues and questions, please open an issue on GitHub.