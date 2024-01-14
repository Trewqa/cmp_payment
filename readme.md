# CMP Payment

[Lee este texto en español pulsando aquí](readme_es.md)

This project uses the **IAB TCF v2.2 API** to force users browsing your site to accept your CMP consents or **pay** to browse without accepting them.

## Requirements

* **CMP based on IAB TCF v2.2** (**Sirdata**, Complianz, etc...)
* **PHP** website (**Wordpress** or other PHP-based CMS).
* **MySQL** and **MariaDB** databases support.
## Authors

- [@Trewqa](https://www.github.com/trewqa)


## Installation

### Files
Upload `cmp_payment` folder to the website **root folder**.

Usually the root folder is `/public_html/`. The folder should be available in `/public_html/cmp_payment/` or `https://mywebsite.com/cmp_payment/`.

### Database
To install CMP Payment, you must first **create a table** containing the access codes for paying users.
You can do this from phpMyAdmin or from your favorite MySQL/MariaDB client.
```sql
CREATE TABLE `cmp_payment_tokens` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`token` VARCHAR(255) NOT NULL DEFAULT '' COLLATE 'utf8mb4_general_ci',
	`email_paypal` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
	`expire_datetime` DATETIME NOT NULL,
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `token` (`token`) USING BTREE
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB;
```

### Files configuration

* **db.php**
Modify the following lines with the access data to the database where you have created the `cmp_payment_tokens` table.
```php
$host = '127.0.0.1';
$user = 'mysql_user';
$password = 'mysql_password';
$database = 'mysql_database';
```

Modify the following lines with your PayPal email.

```php
$paypal_email = "email@example.com";
```

* **lang.php**
You can modify all texts and language in this file.

You can change the `$language` variable to `english` for English or `spanish` for Spanish.

You **must also modify the contact email** in case of problems.
```php
$language = "english"; // Change this according to the desired language ("spanish" or "english")

$email = "contact@example.com"; // Change this with your contact email
```

### Usage
Add this code snippet after `<body>` tag on your site.
```php
<?php include $_SERVER['DOCUMENT_ROOT'].'/cmp_payment/cmp_payment.php'; ?>
```

#### Wordpress
Usually `<body>` tag is on your `header.php` theme file.

## Images

### Mobile
![image](https://github.com/Trewqa/cmp_payment/assets/3149775/5944568f-094b-427d-9f06-21fc346f1d72)
![image](https://github.com/Trewqa/cmp_payment/assets/3149775/404dc086-7fe5-4b70-8a76-fc474d2deafd)

### PC
![image](https://github.com/Trewqa/cmp_payment/assets/3149775/d32395b7-3234-4ef2-9930-417dabe76496)


## Important Considerations

After making the payment, PayPal immediately notifies the payment, but in some cases it may take a few minutes to notify the payment, so until then the code will not be reflected in the database.

## Contributing

Contributions are always welcome!

If you think you can contribute improvements to this project, don't hesitate to make a pull request!


## Licence

This project uses the GNU General Public License (GPL), version 3.0. Under the GPL, you may use, study, modify, and distribute the software, but you must include attribution to the original author when you distribute code or modified versions.

For more details, see the [LICENSE](LICENSE) file included in this repository.
