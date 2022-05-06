-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.24-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for database_2032178
CREATE DATABASE IF NOT EXISTS `database_2032178` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `database_2032178`;

-- Dumping structure for table database_2032178.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `cus_id` char(36) NOT NULL DEFAULT uuid(),
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `address` varchar(25) NOT NULL,
  `province` varchar(25) DEFAULT NULL,
  `postalcode` varchar(7) NOT NULL,
  `city` varchar(25) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` mediumblob NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`cus_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for procedure database_2032178.customer_delete
DELIMITER //
CREATE PROCEDURE `customer_delete`(
	IN `p_cus_id` CHAR(36)
)
BEGIN

	# Anubha Dubey 				12-04-2022			2032187 				Create stored procedure to delete customer record based om customer id
	
	DELETE FROM customers WHERE cus_id=p_cus_id;
END//
DELIMITER ;

-- Dumping structure for procedure database_2032178.customer_insert
DELIMITER //
CREATE PROCEDURE `customer_insert`(
	IN `p_firstname` VARCHAR(20),
	IN `p_lastname` VARCHAR(20),
	IN `p_address` VARCHAR(25),
	IN `p_province` VARCHAR(25),
	IN `p_postalcode` INT,
	IN `p_city` VARCHAR(7),
	IN `p_username` VARCHAR(15),
	IN `p_password` VARCHAR(255),
	IN `p_picture` MEDIUMBLOB
)
BEGIN

	# Anubha Dubey 							2032187 								Create stored procedure to insert into customers
	
	INSERT INTO customers
	(cus_id, firstname, lastname, address, province, postalcode, city, username, password, picture, created, modified)
	VALUES ('uuid()', p_firstname, p_lastname, p_address,p_province , p_postalcode, p_city, p_username, p_password, p_picture , NOW(), NOW())	;

END//
DELIMITER ;

-- Dumping structure for procedure database_2032178.customer_login
DELIMITER //
CREATE PROCEDURE `customer_login`(
	IN `p_username` VARCHAR(15)
)
BEGIN
	#ANUBHA DUBEY( 2032178) 		22-04-2022			CREATE STORED PROCEDURE FOR LOGIN
	SELECT password
	FROM customers
	WHERE username=p_username;
END//
DELIMITER ;

-- Dumping structure for procedure database_2032178.customer_select
DELIMITER //
CREATE PROCEDURE `customer_select`(
	IN `p_cus_id` CHAR(36)
)
BEGIN
	# Anubha Dubey 		 12-04-2022					2032187 					Create stored procedure to show customer details based on a particular customer id
	SELECT * FROM customers WHERE cus_id=p_cus_id;
END//
DELIMITER ;

-- Dumping structure for procedure database_2032178.customer_select_all
DELIMITER //
CREATE PROCEDURE `customer_select_all`()
BEGIN
	
	# Anubha Dubey 			12-04-2022				2032187 								Create stored procedure to select all from customers
	SELECT * FROM customers;

END//
DELIMITER ;

-- Dumping structure for procedure database_2032178.customer_update
DELIMITER //
CREATE PROCEDURE `customer_update`(
	IN `p_firstname` VARCHAR(20),
	IN `p_lastname` VARCHAR(20),
	IN `p_address` VARCHAR(25),
	IN `p_province` VARCHAR(25),
	IN `p_postalcode` VARCHAR(7),
	IN `p_city` VARCHAR(25),
	IN `p_username` VARCHAR(15),
	IN `p_password` VARCHAR(255),
	IN `p_picture` MEDIUMBLOB
)
BEGIN

	# Anubha Dubey 	    12-04-2022						2032187 					Create stored procedure to update customer record in customers

	UPDATE customers
	SET
		cus_id='uuid()',
		firstname= p_firstname,
		lastname=p_lastname,
		address=p_address,
		province=p_province,
		postalcode=p_postalcode,
		city=p_city,
		username=p_username,
		password=p_password,
		picture=NULL,
		created=NOW(),
		modified=NOW()
	WHERE cus_id='uuid()';
END//
DELIMITER ;

-- Dumping structure for table database_2032178.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `odr_id` char(36) NOT NULL DEFAULT uuid(),
  `prod_id` char(36) NOT NULL DEFAULT uuid(),
  `cus_id` char(36) NOT NULL DEFAULT uuid(),
  `qty_sold` decimal(3,0) NOT NULL,
  `sold_price` decimal(3,0) NOT NULL,
  `comments` varchar(200) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp(),
  `subtotal` decimal(5,2) NOT NULL,
  `taxes_amount` decimal(5,2) NOT NULL,
  `total` decimal(5,2) NOT NULL,
  PRIMARY KEY (`odr_id`),
  KEY `FK_orders_products` (`prod_id`),
  KEY `FK_orders_customers` (`cus_id`),
  CONSTRAINT `FK_orders_customers` FOREIGN KEY (`cus_id`) REFERENCES `customers` (`cus_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_orders_products` FOREIGN KEY (`prod_id`) REFERENCES `products` (`prod_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for procedure database_2032178.orders_delete
DELIMITER //
CREATE PROCEDURE `orders_delete`(
	IN `p_odr_id` CHAR(36)
)
BEGIN

	# Anubha Dubey 				12-04-2022			2032187 				Create stored procedure to delete ORDER record based om ORDER id
	
	DELETE FROM customers WHERE odr_id=p_odr_id;
	
END//
DELIMITER ;

-- Dumping structure for procedure database_2032178.orders_insert
DELIMITER //
CREATE PROCEDURE `orders_insert`(
	IN `p_prod_id` CHAR(36),
	IN `p_qty_sold` DECIMAL(3,0),
	IN `p_sold_price` DECIMAL(3,0),
	IN `p_comments` VARCHAR(200),
	IN `p_cus_id` CHAR(36)
)
BEGIN
#ANUBHA DUBEY(2032178) 		22-04-2022			CREATE STORED PROCEDURE TO INSERT ORDERS IN ORDERS TABLE
	INSERT INTO orders
	(odr_id, prod_id, qty_sold, sold_price, comments, created, modified, cus_id)
	VALUES ('uuid()', p_prod_id, p_qty_sold, p_sold_price, p_comments, NOW(), NOW(), p_cus_id);
END//
DELIMITER ;

-- Dumping structure for procedure database_2032178.orders_search
DELIMITER //
CREATE PROCEDURE `orders_search`(
	IN `p_date` INT,
	IN `p_cus_id` INT
)
BEGIN
	#ANUBHA DUBEY(2032178) 		22-04-2022			CREATE STORED PROCEDURE FOR SEARCHING ORDERS FROM ORDERS TABLE
	IF p_date IS NOT NULL then 
		SELECT * FROM orders_view ov WHERE ov.created = p_date;
	ELSE
		SELECT * FROM orders_view ov WHERE ov.cus_id = p_cus_id;
	END IF;
END//
DELIMITER ;

-- Dumping structure for procedure database_2032178.orders_select
DELIMITER //
CREATE PROCEDURE `orders_select`(
	IN `p_odr_id` CHAR(36)
)
BEGIN
	# Anubha Dubey 			12-04-2022					2032187 					Create stored procedure to show order details based on a particular order id
	SELECT * FROM customers WHERE odr_id=p_odr_id;
END//
DELIMITER ;

-- Dumping structure for procedure database_2032178.orders_select_all
DELIMITER //
CREATE PROCEDURE `orders_select_all`()
BEGIN
# Anubha Dubey 			12-04-2022					2032187 					Create stored procedure to show all orders
	SELECT * FROM orders;

END//
DELIMITER ;

-- Dumping structure for procedure database_2032178.orders_update
DELIMITER //
CREATE PROCEDURE `orders_update`(
	IN `p_prod_id` CHAR(36),
	IN `p_qty_sold` DECIMAL(3,0),
	IN `p_sold_price` DECIMAL(3,0),
	IN `p_comments` VARCHAR(200),
	IN `p_cus_id` CHAR(36)
)
BEGIN
#ANUBHA DUBEY(2032178) 		22-04-2022			CREATE STORED PROCEDURE FOR UPDATING ORDERS IN ORDERS TABLE
	UPDATE orders
	SET
		odr_id='uuid()',
		prod_id=p_prod_id,
		qty_sold=p_qty_sold,
		sold_price=p_sold_price,
		comments=p_comments,
		created=NOW(),
		modified=NOW(),
		cus_id=p_cus_id
	WHERE odr_id='uuid()';
END//
DELIMITER ;

-- Dumping structure for view database_2032178.orders_view
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `orders_view` (
	`odr_id` CHAR(36) NOT NULL COLLATE 'utf8mb4_general_ci',
	`qty_sold` DECIMAL(3,0) NOT NULL,
	`sold_price` DECIMAL(3,0) NOT NULL,
	`comments` VARCHAR(200) NULL COLLATE 'utf8mb4_general_ci',
	`cus_id` CHAR(36) NOT NULL COLLATE 'utf8mb4_general_ci',
	`prod_id` CHAR(36) NOT NULL COLLATE 'utf8mb4_general_ci',
	`created` DATETIME NOT NULL,
	`modified` DATETIME NOT NULL,
	`firstname` VARCHAR(20) NOT NULL COLLATE 'utf8mb4_general_ci',
	`lastname` VARCHAR(20) NOT NULL COLLATE 'utf8mb4_general_ci',
	`address` VARCHAR(25) NOT NULL COLLATE 'utf8mb4_general_ci',
	`city` VARCHAR(25) NOT NULL COLLATE 'utf8mb4_general_ci',
	`province` VARCHAR(25) NULL COLLATE 'utf8mb4_general_ci',
	`postalcode` VARCHAR(7) NOT NULL COLLATE 'utf8mb4_general_ci',
	`username` VARCHAR(15) NOT NULL COLLATE 'utf8mb4_general_ci',
	`password` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
	`picture` MEDIUMBLOB NOT NULL,
	`prod_desc` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_general_ci',
	`cost_price` DECIMAL(5,2) NULL
) ENGINE=MyISAM;

-- Dumping structure for table database_2032178.products
CREATE TABLE IF NOT EXISTS `products` (
  `prod_id` char(36) NOT NULL DEFAULT uuid(),
  `prod_code` varchar(12) NOT NULL,
  `prod_desc` varchar(100) NOT NULL,
  `retail_price` decimal(5,2) NOT NULL,
  `cost_price` decimal(5,2) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`prod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for procedure database_2032178.products_delete
DELIMITER //
CREATE PROCEDURE `products_delete`(
	IN `p_prod_id` CHAR(36)
)
BEGIN

	# Anubha Dubey 				12-04-2022			2032187 				Create stored procedure to delete PRODUCT record based om PRODUCT id
	
	DELETE FROM customers WHERE prod_id=p_prod_id;
	
END//
DELIMITER ;

-- Dumping structure for procedure database_2032178.products_insert
DELIMITER //
CREATE PROCEDURE `products_insert`(
	IN `p_prod_code` VARCHAR(12),
	IN `p_prod_desc` VARCHAR(100),
	IN `p_retail_price` DECIMAL(5,2),
	IN `p_cost_price` DECIMAL(5,2)
)
BEGIN
#ANUBHA DUBEY(2032178) 		22-04-2022			CREATE STORED PROCEDURE FOR INSERT PRODUCTS IN PRODUCTS TABLE
	INSERT INTO products
	(prod_id, prod_code, prod_desc, retail_price, cost_price, created, modified)
	VALUES ('uuid()', p_prod_code, p_prod_desc, p_retail_price, p_cost_price, NOW(), NOW());
END//
DELIMITER ;

-- Dumping structure for procedure database_2032178.products_select
DELIMITER //
CREATE PROCEDURE `products_select`(
	IN `p_prod_id` CHAR(36)
)
BEGIN
#ANUBHA DUBEY(2032178) 		22-04-2022			CREATE STORED PROCEDURE TO SELECT PRODUCTS FROM PRODUCTS TABLE BASED ON PRODUCT ID 
	select * FROM products WHERE prod_id=p_prod_id;
END//
DELIMITER ;

-- Dumping structure for procedure database_2032178.products_select_all
DELIMITER //
CREATE PROCEDURE `products_select_all`()
BEGIN
#ANUBHA DUBEY(2032178) 		22-04-2022			CREATE STORED PROCEDURE TO SHOW ALL PRODUCTS IN PRODUCTS TABLE
	SELECT * FROM products;
END//
DELIMITER ;

-- Dumping structure for procedure database_2032178.products_update
DELIMITER //
CREATE PROCEDURE `products_update`(
	IN `p_prod_code` VARCHAR(12),
	IN `p_prod_desc` VARCHAR(100),
	IN `p_retail_price` DECIMAL(5,2),
	IN `p_cost_price` DECIMAL(5,2)
)
BEGIN
#ANUBHA DUBEY(2032178) 		22-04-2022			CREATE STORED PROCEDURE TO UPDATE PRODUCTS IN PRODUCTS TABLE
	UPDATE products
	SET
		prod_id='uuid()',
		prod_code=p_prod_code,
		prod_desc=p_prod_desc,
		retail_price=p_retail_price,
		cost_price=p_cost_price,
		created=NOW(),
		modified=NOW()
	WHERE prod_id='uuid()';
END//
DELIMITER ;

-- Dumping structure for table database_2032178.test
CREATE TABLE IF NOT EXISTS `test` (
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for procedure database_2032178.testing
DELIMITER //
CREATE PROCEDURE `testing`()
BEGIN

END//
DELIMITER ;

-- Dumping structure for view database_2032178.orders_view
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `orders_view`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `orders_view` AS #ANUBHA DUBEY(2032178) 		22-04-2022			CREATE STORED PROCEDURE FOR VIEWING ORDERS

SELECT 	o.odr_id, o.qty_sold, o.sold_price, o.comments, o.cus_id, o.prod_id, o.created, o.modified, 
			c.firstname, c.lastname, c.address, c.city, c.province, c.postalcode, c.username, c.password , c.picture, 
			p.prod_desc, p.cost_price
FROM orders o JOIN customers c ON o.cus_id = c.cus_id JOIN products p ON p.prod_id = o.prod_id GROUP BY o.odr_id ORDER BY o.created DESC ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
