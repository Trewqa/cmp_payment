# CMP Payment

[Read this text in English clicking here](readme.md)

Este proyecto utiliza la **API IAB TCF v2.2** para obligar a los usuarios que navegan por tu sitio a aceptar los consentimientos de tu CMP o **pagar** para navegar sin aceptarlos.

## Requisitos

- **CMP basado en IAB TCF v2.2** (Sirdata, Complianz, etc.)
- Sitio web en **PHP** (Wordpress u otro CMS basado en PHP).
- Soporte de bases de datos **MySQL** y **MariaDB**.

## Autores

- [@Trewqa](https://www.github.com/trewqa)

## Instalación

### Archivos
Sube la carpeta `cmp_payment` al **directorio raíz** del sitio web.

Por lo general, el directorio raíz es `/public_html/`. La carpeta debería estar disponible en `/public_html/cmp_payment/` o `https://miweb.com/cmp_payment/`.

### Base de datos
Para instalar CMP Payment, primero debes **crear una tabla** que contenga los códigos de acceso para los usuarios que pagan.
Puedes hacer esto desde phpMyAdmin o desde tu cliente MySQL/MariaDB favorito.
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
Modifica las siguientes líneas con los datos de acceso a la base de datos donde has creado la tabla `cmp_payment_tokens`.
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
Puedes modificar todos los textos e idiomas en este archivo.

Puedes cambiar la variable `$language` a `english` para inglés o `spanish` para español.

**Debes modificar también el correo electrónico de contacto** en caso de problemas.
```php
$language = "english"; // Change this according to the desired language ("spanish" or "english")

$email = "contact@example.com"; // Change this with your contact email
```

### Uso
Agregue este fragmento de código después de la etiqueta `<body>` en su sitio.
```php
<?php include __DIR__.'/cmp_payment/cmp_payment.php'; ?>
```

#### Wordpress
Por lo general, la etiqueta `<body>` está en su archivo `header.php` del theme.


## Consideraciones Importantes

Después de realizar el pago, PayPal notifica inmediatamente el pago, pero en algunos casos puede tardar unos minutos en notificar el pago, por lo que hasta entonces el código no se reflejará en la base de datos.

## Contribuciones

¡Las contribuciones son siempre bienvenidas!

Si crees que puedes aportar mejoras a este proyecto, ¡no dudes en hacer una solicitud de extracción!


## Licencia

Este proyecto utiliza la Licencia Pública General de GNU (GPL), versión 3.0. De acuerdo con la GPL, puedes usar, estudiar, modificar y distribuir el software, pero debes incluir la atribución al autor original cuando distribuyas el código o versiones modificadas.

Para más detalles, consulta el archivo [LICENSE](LICENSE) incluido en este repositorio.