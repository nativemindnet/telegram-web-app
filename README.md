# Buro

Buro is a cutting-edge Web App designed for Telegram, focusing on the Thailand market. It seamlessly integrates marketplace functionalities for buying and selling goods, along with apartment rental services.

## Features

- **Marketplace Integration**: Buy and sell goods with ease.
- **Apartment Rental Services**: Find and offer apartments for rent.
- **Localized for Thailand**: Tailored for the Thai market, with support for local languages and currencies.
- **Telegram Integration**: Fully integrated with Telegram for ease of use and accessibility.

## Technology Stack
- **Back-end**: PHP
- **Database**: MySQL

## Getting Started

**1. Clone the Repository**
   ```
   git clone https://github.com/nativemindnet/telegram-web-app.git
   ```
**2. Create Database connection file**
   ```
      <?php
         $server = "<server address/localhost>";
         $login = "<database user>";
         $pass = "<database password>";
         $name_db = "<database table name>";
         
         $link = mysqli_connect($server, $login, $pass, $name_db);
         if ($link === false) {
         	die("Connection failed: " . mysqli_connect_error());
         }
         
         mysqli_query($link, "SET NAMES utf8");
      ?>
   ```

## Contributing

We welcome contributions! Please read our contributing guidelines in `CONTRIBUTING.md` to get started.

## License

This project is licensed under the MIT License - see the `LICENSE` file for details.

## Contact

For any queries or feedback, feel free to contact us.

---

Buro - Bringing the convenience of online marketplace and rental services to your Telegram!
