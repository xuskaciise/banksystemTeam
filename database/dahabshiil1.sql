-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2023 at 03:02 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dahabshiil1`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `account_statment` (IN `account_no_` VARCHAR(100) CHARSET utf8)   BEGIN
IF NOT EXISTS(SELECT account.account_id FROM account WHERE account.account_no=account_no_)THEN
SELECT 'exsist' as msg;
ELSE
CREATE TEMPORARY TABLE tb SELECT IFNULL(d.amount,0)  deposit_amount,IFNULL(w.amount,0) withdro_amount, IFNULL(acc.amout ,0)debit_amount,IFNULL(ac.amout ,0) credit_amount,'' Blance FROM account a LEFT JOIN deposit d ON d.accout_id=a.account_no LEFT JOIN withdrow w on w.account_id=a.account_no LEFT JOIN account_to_account acc ON acc.debit_amount=a.account_no LEFT JOIN account_to_account ac ON ac.credit_account=a.account_no WHERE a.account_no=account_no_ GROUP BY w.amount;

 SELECT * FROM tb
 
 UNION 
 SELECT SUM(tb.deposit_amount),SUM(tb.withdro_amount),SUM(tb.debit_amount),SUM(tb.credit_amount),getBlance(account_no_) FROM tb;
END IF;



 




END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `account_to_account_register` (IN `amount_p` DECIMAL, IN `debit_account_p` VARCHAR(200) CHARSET hebrew, IN `credit_account_p` INT, IN `write_amount_p` VARCHAR(100) CHARSET utf8, IN `withdrow_person_p` VARCHAR(100) CHARSET utf8, IN `descrption_p` VARCHAR(100) CHARSET utf8, IN `branch_p` INT, IN `user_id_p` VARCHAR(100) CHARSET utf8)   BEGIN
 SET @limit=( SELECT b.limit_amount  FROM account_to_account a LEFT JOIN account acc ON a.credit_account=acc.account_no LEFT JOIN branch b ON a.branch_id=b.id  WHERE acc.branch_id=branch_p GROUP BY b.id);
IF(amount_p>@limit)THEN
SELECT 'limit' as msg ,@limit as limits;
ELSEIF (SELECT getBlance(credit_account_p)<amount_p)THEN
SELECT 'deny' as msg;
ELSEIF  NOT EXISTS(SELECT * FROM account a WHERE a.account_no=debit_account_p)THEN
SELECT "invalid" as msg;
ELSEIF(debit_account_p=credit_account_p)THEN
SELECT 'same' as msg;
ELSEIF(amount_p<=0)THEN
SELECT 'amount' as msg;

ELSE
INSERT INTO `account_to_account`( `amout`,`debit_amount`, `credit_account`, `transfred_person`, `write_amount`, `description`, `branch_id`, `user_id` ) VALUES
(amount_p,debit_account_p,credit_account_p, withdrow_person_p,write_amount_p,descrption_p,branch_p,user_id_p);
SELECT 'register' as msg;
 END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `branch_sp` (IN `name_` VARCHAR(200), IN `address_` VARCHAR(200), IN `manager_` VARCHAR(200), IN `limit_amount_` VARCHAR(200), IN `user_id_` VARCHAR(100))   BEGIN
IF EXISTS(SELECT id FROM branch b WHERE b.name=name_ AND b.address=address_)THEN
SELECT 'deny'as messege;
ELSE INSERT INTO `branch`(`name`, `address`, `manager`, `limit_amount`, `user_id`)VALUES(name_,address_,manager_,limit_amount_,user_id_);
 SELECT 'save' as messege;



END IF;








END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_chequeNo_sp` (IN `chequeNo_sp` VARCHAR(250) CHARSET utf8mb4, IN `account_no_sp` VARCHAR(250) CHARSET utf8mb4, IN `user_id` VARCHAR(250) CHARSET utf8mb4)   BEGIN
IF EXISTS(SELECT chequeno.chequeNo FROM chequeno WHERE chequeno.chequeNo=chequeNo_sp AND chequeno.account_no=account_no_sp)THEN
SELECT 'deny' as meg;
ELSE
INSERT INTO `chequeno`(`chequeNo`, `account_no`,`user_id`) 
VALUES (chequeNo_sp,account_no_sp,user_id);
SELECT 'saved' as msg;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_stock_sp` (IN `stockNo_sp` VARCHAR(250) CHARSET utf8mb4, IN `manger_id_sp` VARCHAR(250) CHARSET utf8mb4, IN `manager_user_sp` VARCHAR(250) CHARSET utf8mb4, IN `created_user_sp` VARCHAR(250) CHARSET utf8mb4, IN `blance_sp` DECIMAL)   BEGIN
IF EXISTS(SELECT stock.stock_no FROM stock WHERE stock.stock_no=stockNo_sp)THEN
SELECT 'deny' as meg;
ELSE
INSERT INTO `stock`(`stock_no`, `manager_id`, `manager_user`, `created_user`, `blance`)
VALUES(stockNo_sp,manger_id_sp,manager_user_sp,created_user_sp,blance_sp);
SELECT 'saved' as msg;

END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deposit_report_p` (IN `account_no_` VARCHAR(100), IN `branch_id_` VARCHAR(100), IN `user_id_` VARCHAR(100) CHARSET utf8, IN `from_` DATE, IN `to_` DATE)   BEGIN
IF(to_='0000-00-00')THEN
SET to_=date(now());
END IF;
IF (account_no_='')THEN
SET account_no_='%';
END IF;
IF (branch_id_='')THEN
SET branch_id_='%';
END IF;
IF (user_id_='')THEN
SET user_id_='%';
END IF;

 CREATE TEMPORARY TABLE tb  SELECT d.`id`, d.`accout_id`, d.`amount` amount, d.`write_amount`, d.`transacted_person`,b.name, u.username, date(d.`date`) date FROM deposit d LEFT JOIN branch b ON d.branch_id=b.id LEFT JOIN users u on d.userid=u.id WHERE d.accout_id LIKE account_no_ AND d.branch_id LIKE branch_id_ AND d.userid LIKE user_id_ AND date(d.date) BETWEEN from_ AND to_ ;
 
SELECT * FROM tb

UNION 
SELECT '','', SUM(amount),'','','','',''

FROM tb;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `deposit_sp` (IN `accountNo_p` VARCHAR(200) CHARSET utf8, IN `amount_p` VARCHAR(200) CHARSET utf8, IN `write_amount_p` VARCHAR(200) CHARSET utf8, IN `person_p` VARCHAR(200) CHARSET utf8, IN `branch_id_p` INT, IN `user_id_p` VARCHAR(100) CHARSET utf8)   BEGIN
SET @limit=(SELECT b.limit_amount FROM deposit d RIGHT JOIN branch b ON d.branch_id=b.id  WHERE b.id=branch_id_p GROUP BY b.id);
IF(amount_p>@limit)THEN
SELECT 'limit' as msg ,@limit as limits;
ELSE
INSERT INTO `deposit`(`accout_id`, `amount`, `write_amount`, `transacted_person`, `branch_id`, `userid`) VALUES(accountNo_p,amount_p,write_amount_p,person_p,branch_id_p,user_id_p);
SELECT 'saved' as msg;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `employee_sp` (IN `id_` VARCHAR(100), IN `first_` VARCHAR(200), IN `last_` VARCHAR(200), IN `contect_` VARCHAR(200), IN `email_` VARCHAR(200), IN `image_` VARCHAR(200), IN `cv_` VARCHAR(200), IN `address_` VARCHAR(200), IN `title_` VARCHAR(200), IN `document_` VARCHAR(200), IN `issue_date_` VARCHAR(200), IN `expire_date_` VARCHAR(200), IN `branch_id_` INT, IN `user_id_` VARCHAR(200))   BEGIN
IF EXISTS(SELECT id FROM employee e WHERE e.First=first_ AND e.Last=last_ AND e.contect=contect_)THEN
SELECT 'deny'as messege;
ELSE
INSERT INTO `employee`(`id`,`First`, `Last`, `contect`, `email`, `image`, `cv`, `address`, `title`, `docoment`, `issu_date`, `expire_date`, `branch_id`, `user_id`) VALUES(id_,first_,last_,contect_,email_,image_,cv_,address_,title_,document_,issue_date_,expire_date_,branch_id_,user_id_);
 SELECT 'save' as messege;



END IF;








END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAccountInformation` (IN `account_no_p` INT)   BEGIN



IF NOT EXISTS(SELECT * FROM account a WHERE a.account_no=account_no_p)THEN
SELECT "invalid" as msg;

ELSE
SELECT * FROM account WHERE account.account_no=account_no_p;

END IF;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_user_authorites` (IN `_user_id` VARCHAR(250) CHARSET utf8)   BEGIN
SELECT c.id category_id,c.name category_name ,c.role,sa.id action_id,sa.name action_name,sl.id link_id,sl.name link_name FROM `user_authority` ua LEFT JOIN system_actions sa ON ua.action_id=sa.id LEFT JOIN system_links sl on sa.link_id=sl.id LEFT JOIN category c ON sl.category_id=c.id WHERE ua.user_id=_user_id ORDER BY c.role ,sa.id ,sa.id;



END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_user_menu` (IN `_user_id` VARCHAR(250) CHARSET utf8)   BEGIN
SELECT c.id category_id,c.name category_name ,c.role,  c.icon,sl.id link_id,sl.name link_name,sl.link FROM `user_authority` ua LEFT JOIN system_actions sa ON ua.action_id=sa.id LEFT JOIN system_links sl on sa.link_id=sl.id LEFT JOIN category c ON sl.category_id=c.id 
WHERE ua.user_id=_user_id GROUP BY sl.id
ORDER BY c.role ,sa.id ,sa.id;



END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `login` (IN `username_` VARCHAR(100) CHARSET utf8, IN `password_` VARCHAR(100) CHARSET utf8)   BEGIN

IF NOT EXISTS(SELECT * FROM  users u WHERE u.username=username_ AND u.password=password_)THEN
SELECT 'deny' as msg;
ELSEIF EXISTS(SELECT * FROM users u WHERE u.username=username_ AND u.password=password_ AND u.type="Disable")THEN
SELECT 'locked' as msg;

ELSE
SELECT * FROM users u WHERE u.username=username_ AND u.password=password_;
END IF;




END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `searchAccount` (IN `phone_sp` VARCHAR(250) CHARSET utf8)   BEGIN
IF NOT EXISTS(SELECT * FROM account a WHERE a.phone LIKE CONCAT('%',phone_sp,'%'))THEN
SELECT "invalid" as msg;

ELSE
SELECT * FROM account WHERE account.phone LIKE CONCAT('%',phone_sp,'%');

END IF;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `transfer_report_p` (IN `account_no_` VARCHAR(100), IN `branch_id_` VARCHAR(100), IN `user_id_` VARCHAR(100) CHARSET utf8, IN `from_` DATE, IN `to_` DATE)   BEGIN
IF(to_='0000-00-00')THEN
SET to_=date(now());
END IF;
IF (account_no_='')THEN
SET account_no_='%';
END IF;
IF (branch_id_='')THEN
SET branch_id_='%';
END IF;
IF (user_id_='')THEN
SET user_id_='%';
END IF;

 CREATE TEMPORARY TABLE tb
 
 SELECT a.id debit_id ,a.amout amount ,ac.account_no debit_ac,ac.name debit_name,acc.account_no credit_ac,acc.name credit_name,b.name branch_name,date(a.date)date ,u.username  FROM account_to_account a LEFT JOIN account ac ON a.debit_amount=ac.account_no LEFT JOIN account acc ON a.credit_account=acc.account_no LEFT JOIN branch b ON a.branch_id=b.id  LEFT JOIN users u ON a.user_id=u.id
 WHERE ac.account_no  LIKE account_no_ AND a.branch_id LIKE branch_id_ AND a.user_id LIKE user_id_ AND date(a.date) BETWEEN from_ AND to_ ;

SELECT *  FROM tb
UNION
SELECT '',SUM(amount) as total,'','','','','','',''

FROM tb;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `users` (IN `id_p` VARCHAR(200), IN `username_p` VARCHAR(100) CHARSET utf8, IN `passwoword_p` VARCHAR(100) CHARSET utf8, IN `image_p` VARCHAR(100) CHARSET utf8, IN `type_p` VARCHAR(100) CHARSET utf8, IN `status_p` VARCHAR(100) CHARSET utf8, IN `user_id_p` VARCHAR(100) CHARSET utf8)   BEGIN
IF EXISTS(SELECT id FROM users WHERE users.username=username_p)THEN
SELECT 'exsist' as msg;
ELSE
INSERT INTO `users`(`id`, `username`,`password`, `image`, `type`,`status`, `user_id`) VALUES(id_p,username_p,md5(passwoword_p),image_p,type_p,user_id_p);
SELECT 'register' as msg;
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `WithdrowAccountInfo` (IN `account_no_p` INT)   BEGIN
IF NOT EXISTS(SELECT * FROM account a WHERE a.account_no=account_no_p)THEN
SELECT "invalid" as msg;

ELSE
SELECT  `account_no`, `name`,  `image`, `signature_img`, `branch_id`,( getBlance(account_no_p)) as blance FROM account WHERE account.account_id=`account_no_p`;
END IF;


END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `withdrow_register` (IN `amount_p` DECIMAL, IN `account_id_p` VARCHAR(200), IN `write_amount_p` VARCHAR(100), IN `withdrow_person_p` VARCHAR(100), IN `descrption_p` VARCHAR(100), IN `check_no_p` VARCHAR(100), IN `branch_p` INT, IN `user_id_p` VARCHAR(100))   BEGIN
IF (SELECT getBlance(account_id_p)<amount_p)THEN
SELECT 'deny' as msg;
ELSEIF(amount_p<=0)THEN
SELECT 'amount' as msg;

ELSE

INSERT INTO `withdrow`(`amount`, `account_id`, `write_amount`, `withdrow_persson`, `description`, `check_no`, `branch_id`, `user_id`) VALUES(amount_p,account_id_p,write_amount_p,                                               withdrow_person_p,descrption_p,check_no_p,branch_p,user_id_p);
SELECT 'register' as msg;
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `withdrow_report_p` (IN `account_no_` VARCHAR(100), IN `branch_id_` VARCHAR(100), IN `user_id_` VARCHAR(100) CHARSET utf8, IN `from_` DATE, IN `to_` DATE)   BEGIN
IF(to_='0000-00-00')THEN
SET to_=date(now());
END IF;
IF (account_no_='')THEN
SET account_no_='%';
END IF;
IF (branch_id_='')THEN
SET branch_id_='%';
END IF;
IF (user_id_='')THEN
SET user_id_='%';
END IF;

 CREATE TEMPORARY TABLE tb SELECT w.id,w.amount amount,w.account_id,w.write_amount,
w.withdrow_persson,
w.description,w.check_no,
b.name,u.username,date(w.date) FROM withdrow w LEFT JOIN branch b ON w.branch_id=b.id LEFT JOIN users u ON w.user_id=u.id WHERE w.account_id LIKE account_no_ AND w.branch_id LIKE branch_id_ AND w.user_id LIKE user_id_ AND date(w.date) BETWEEN from_ AND to_ ;

SELECT *  FROM tb
UNION
SELECT '',SUM(amount),'','','','','','','',''
FROM tb;


END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `getBlance` (`account_no_` VARCHAR(200) CHARSET utf8) RETURNS DECIMAL(10,2)  BEGIN
SET @blance=0.00;
set @deposit=(SELECT SUM(deposit.amount)FROM deposit WHERE deposit.accout_id=account_no_);

SET @withdrow=(SELECT SUM(withdrow.amount) FROM withdrow WHERE withdrow.account_id=account_no_);

SET @debit_accout=(SELECT SUM(a.amout) FROM account_to_account a WHERE a.debit_amount=account_no_);

SET @credit_ccount=(SELECT SUM(a.amout) FROM account_to_account a WHERE a.credit_account=account_no_);


SET @debit=ifnull(@deposit,0.00)+ifnull(@debit_accout,0.00);
SET @credit=ifnull(@withdrow,0.00)+ifnull(@credit_ccount,0.00);

SET @blance=@debit-@credit;
RETURN  @blance;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `account_id` int(11) NOT NULL,
  `account_no` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  `type` varchar(150) NOT NULL,
  `sex` varchar(150) NOT NULL,
  `phone` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address` varchar(150) NOT NULL,
  `document_no` varchar(150) NOT NULL,
  `document_img` varchar(150) NOT NULL,
  `issue_date` varchar(150) NOT NULL,
  `expire_date` varchar(150) NOT NULL,
  `image` mediumtext NOT NULL,
  `signature_img` varchar(150) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `next_of_kind_name` varchar(150) NOT NULL,
  `next_of_kind_number` varchar(150) NOT NULL,
  `relationship` varchar(150) NOT NULL,
  `user_id` varchar(150) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_id`, `account_no`, `name`, `type`, `sex`, `phone`, `email`, `address`, `document_no`, `document_img`, `issue_date`, `expire_date`, `image`, `signature_img`, `branch_id`, `next_of_kind_name`, `next_of_kind_number`, `relationship`, `user_id`, `date`) VALUES
(1, 'SAL0001', 'hussein isse ali', 'Current', 'Male', '0615844908', 'xuska@gmail.com', 'yaaqshiid', '000233', 'SAL0001.png', '2023-11-14', '2023-11-15', 'SAL0001.png', 'SAL0001.png', 27, 'Luul Mohamed', '0618891225', 'Hooyo', 'USER005', '2023-11-14 19:18:40'),
(2, 'SAL0002', 'Luul Mohamed Diini', 'Current', 'Femele', '06188912225', 'luul@gmail.com', 'yaaqshiid', '9908889', '.png', '2023-11-15', '2023-11-15', '.png', '.png', 27, 'Shukri Abdullhi', '0615503163', 'yaaqshiid', 'USER005', '2023-11-14 19:22:35'),
(3, 'SAL0002', 'Luul Mohamed Diini', 'Current', 'Femele', '06188912225', 'luul@gmail.com', 'yaaqshiid', '9908889', 'SAL0003.png', '2023-11-15', '2023-11-15', 'SAL0003.png', 'SAL0003.png', 27, 'Shukri Abdullhi', '0615503163', 'yaaqshiid', 'USER005', '2023-11-14 19:23:39'),
(4, 'SAL0003', 'ilka dhaqis', 'Current', 'Male', '0615844908', 'xuska@gmail.com', 'yaaqshiid', '000233', 'SAL0003.png', '2023-11-15', '2023-11-16', 'SAL0003.png', 'SAL0003.png', 0, 'Luul Mohamed', '0618891225', 'Hooyo', 'USER005', '2023-11-14 19:44:22');

-- --------------------------------------------------------

--
-- Table structure for table `account_to_account`
--

CREATE TABLE `account_to_account` (
  `id` int(11) NOT NULL,
  `amout` varchar(200) DEFAULT NULL,
  `debit_amount` varchar(100) DEFAULT NULL,
  `credit_account` varchar(100) DEFAULT NULL,
  `transfred_person` varchar(100) NOT NULL,
  `write_amount` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `manager` varchar(100) NOT NULL,
  `limit_amount` varchar(100) DEFAULT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `name`, `address`, `manager`, `limit_amount`, `user_id`, `date`) VALUES
(27, 'Holwadaag', 'Kaaraan', '', '50000', 'xuska122', '2023-02-16 13:43:00'),
(54, 'Hilwaa suuq yarha', 'Kaaraan', '', '90000000', 'USER005', '2023-03-13 13:40:16'),
(55, 'Holwadaag', 'Kaaraan', '', '50000', 'xuska122', '2023-02-16 13:43:00'),
(56, 'Hilwaa suuq yarha', 'Kaaraan', '', '90000000', 'USER005', '2023-03-13 13:40:16'),
(57, 'Holwadaag', 'Kaaraan', '', '50000', 'xuska122', '2023-02-16 13:43:00'),
(58, 'Hilwaa suuq yarha', 'Kaaraan', '', '90000000', 'USER005', '2023-03-13 13:40:16'),
(59, 'Holwadaag', 'Kaaraan', '', '50000', 'xuska122', '2023-02-16 13:43:00'),
(60, 'Hilwaa suuq yarha', 'Kaaraan', '', '90000000', 'USER005', '2023-03-13 13:40:16'),
(61, 'Holwadaag', 'Kaaraan', '', '50000', 'xuska122', '2023-02-16 13:43:00'),
(62, 'Hilwaa suuq yarha', 'Kaaraan', '', '90000000', 'USER005', '2023-03-13 13:40:16'),
(63, 'Holwadaag', 'Kaaraan', '', '50000', 'xuska122', '2023-02-16 13:43:00'),
(64, 'Hilwaa suuq yarha', 'Kaaraan', '', '90000000', 'USER005', '2023-03-13 13:40:16'),
(65, 'Holwadaag', 'Kaaraan', '', '50000', 'xuska122', '2023-02-16 13:43:00'),
(66, 'Hilwaa suuq yarha', 'Kaaraan', '', '90000000', 'USER005', '2023-03-13 13:40:16'),
(67, 'Holwadaag', 'Kaaraan', '', '50000', 'xuska122', '2023-02-16 13:43:00'),
(68, 'Hilwaa suuq yarha', 'Kaaraan', '', '90000000', 'USER005', '2023-03-13 13:40:16'),
(69, 'Holwadaag', 'Kaaraan', '', '50000', 'xuska122', '2023-02-16 13:43:00'),
(70, 'Hilwaa suuq yarha', 'Kaaraan', '', '90000000', 'USER005', '2023-03-13 13:40:16'),
(71, 'Holwadaag', 'Kaaraan', '', '50000', 'xuska122', '2023-02-16 13:43:00'),
(72, 'Hilwaa suuq yarha', 'Kaaraan', '', '90000000', 'USER005', '2023-03-13 13:40:16'),
(73, 'Holwadaag', 'Kaaraan', '', '50000', 'xuska122', '2023-02-16 13:43:00'),
(74, 'Hilwaa suuq yarha', 'Kaaraan', '', '90000000', 'USER005', '2023-03-13 13:40:16'),
(75, 'Holwadaag', 'Kaaraan', '', '50000', 'xuska122', '2023-02-16 13:43:00'),
(76, 'Hilwaa suuq yarha', 'Kaaraan', '', '90000000', 'USER005', '2023-03-13 13:40:16'),
(77, 'Holwadaag', 'Kaaraan', '', '50000', 'xuska122', '2023-02-16 13:43:00'),
(78, 'Hilwaa suuq yarha', 'Kaaraan', '', '90000000', 'USER005', '2023-03-13 13:40:16'),
(79, 'Holwadaag', 'Kaaraan', '', '50000', 'xuska122', '2023-02-16 13:43:00'),
(80, 'Hilwaa suuq yarha', 'Kaaraan', '', '90000000', 'USER005', '2023-03-13 13:40:16'),
(81, 'Holwadaag', 'Kaaraan', '', '50000', 'xuska122', '2023-02-16 13:43:00'),
(82, 'Hilwaa suuq yarha', 'Kaaraan', '', '90000000', 'USER005', '2023-03-13 13:40:16'),
(83, 'Holwadaag', 'Kaaraan', '', '50000', 'xuska122', '2023-02-16 13:43:00'),
(84, 'Hilwaa suuq yarha', 'Kaaraan', '', '90000000', 'USER005', '2023-03-13 13:40:16');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `icon`, `role`, `date`) VALUES
(1, 'SuperAdmin', 'fas fa-user', 'SuperAdmin', '2023-02-21 14:35:34'),
(2, 'Cashier', 'fas fa-users', 'Cashier', '2023-02-21 17:39:41'),
(3, 'Dashboard', 'fas fa-tachometer-alt', 'Dashboard', '2023-02-22 14:40:03');

-- --------------------------------------------------------

--
-- Table structure for table `chequeno`
--

CREATE TABLE `chequeno` (
  `id` int(11) NOT NULL,
  `chequeNo` varchar(250) NOT NULL,
  `account_no` varchar(250) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chequeno`
--

INSERT INTO `chequeno` (`id`, `chequeNo`, `account_no`, `user_id`, `date`) VALUES
(1, 'CH000001', 'SAL0001', 'USER005', '2023-11-14 19:36:12'),
(2, 'CH000002', 'SAL0001', 'USER005', '2023-11-14 19:42:06'),
(3, 'CH000003', 'SAL0003', 'USER005', '2023-11-14 19:44:36');

-- --------------------------------------------------------

--
-- Table structure for table `deposit`
--

CREATE TABLE `deposit` (
  `id` int(11) NOT NULL,
  `accout_id` int(11) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `write_amount` varchar(11) NOT NULL,
  `transacted_person` varchar(200) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `userid` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deposit`
--

INSERT INTO `deposit` (`id`, `accout_id`, `amount`, `write_amount`, `transacted_person`, `branch_id`, `userid`, `date`) VALUES
(1, 0, '357', 'THREE HUNDR', 'Abdirahman Hassan', 27, 'USER005', '2023-11-15 13:47:33');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` varchar(100) NOT NULL,
  `First` varchar(200) DEFAULT NULL,
  `Last` varchar(200) DEFAULT NULL,
  `contect` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `cv` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `docoment` varchar(200) DEFAULT NULL,
  `issu_date` varchar(200) DEFAULT NULL,
  `expire_date` varchar(200) DEFAULT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `First`, `Last`, `contect`, `email`, `image`, `cv`, `address`, `title`, `docoment`, `issu_date`, `expire_date`, `user_id`, `date`) VALUES
('Empl001', 'Kamaal Hamed', 'Alas', '0615844908', 'kamaal@gmail.com', 'Empl001.png', 'Empl001.png', 'calikamiin', 'oparation manager', '8827727266', '2023-02-13', '2023-03-25', 'xuska122', '2023-02-13 09:32:13'),
('Empl002', 'Adnaan', 'ALI ', '0615844908', 'xuseenyareciise@gmail.com', 'Empl002.png', 'Empl002.png', 'Hodan', 'Branch Manager', '8839933893939', '2023-02-16', '2023-02-28', 'xuska122', '2023-02-16 05:49:39'),
('Empl003', 'wng Khaasim', 'ss', '33', '33@gmail.com', 'Empl003.png', 'Empl003.png', 'ss', 'ss', 'ss', '2023-04-06', '2023-04-06', 'USER005', '2023-04-06 09:32:44'),
('Empl004', 'wng Khaasim', 'ss', '33', '33@gmail.com', 'Empl004.png', 'Empl004.png', 'ss', 'ss', 'ss', '2023-04-06', '2023-04-06', 'USER005', '2023-04-06 09:32:49'),
('Empl005', 'hussein', 'iise', '0615844908', 'xuseenyareciise@gmail.com', 'Empl005.png', 'Empl005.png', 'yaaqshiid', 'xuska', '778777888', '2023-03-23', '2023-04-23', '<br />\r\n<b>Notice</b>:  Undefined variable: _SESSION in <b>C:xampphtdocsSIUBANKapplicationviewsemplo', '2023-04-22 22:18:20');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `stock_no` varchar(250) DEFAULT NULL,
  `manager_id` varchar(250) DEFAULT NULL,
  `manager_user` varchar(250) DEFAULT NULL,
  `created_user` varchar(250) DEFAULT NULL,
  `blance` decimal(10,0) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `stock_no`, `manager_id`, `manager_user`, `created_user`, `blance`, `date`) VALUES
(1, 'Stock0001', 'Empl001', 'USER001', 'USER005', 30000, '2023-11-17 13:59:47');

-- --------------------------------------------------------

--
-- Table structure for table `system_actions`
--

CREATE TABLE `system_actions` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `action` varchar(250) NOT NULL,
  `link_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_actions`
--

INSERT INTO `system_actions` (`id`, `name`, `action`, `link_id`, `date`) VALUES
(2, 'User Register', 'Addusers', 10, '2023-02-21 14:59:10'),
(3, 'Update User', 'UpdateUser', 10, '2023-02-21 15:00:06'),
(4, 'Delete User', 'DeleteData', 10, '2023-02-21 15:00:55'),
(5, 'Account Register', 'addAccount', 1, '2023-02-21 15:03:35'),
(6, 'Update Account', 'UpdateData', 1, '2023-02-21 15:05:11'),
(7, 'Delete Account', 'DeleteData', 1, '2023-02-21 15:05:37'),
(8, 'Branch Register', 'AddBranch', 2, '2023-02-21 15:06:09'),
(9, 'Update Branch', 'UpdateData', 2, '2023-02-21 15:07:20'),
(10, 'Delete Branch', 'DeleteData', 2, '2023-02-21 15:07:47'),
(11, 'Employee Register', 'Addemployee', 9, '2023-02-22 12:36:13'),
(12, 'Update Employee', 'UpdateData', 9, '2023-02-22 12:36:20'),
(13, 'Delete Employee', 'DeleteData', 9, '2023-02-22 12:36:24'),
(14, 'Deposit Amount', 'DepositAmount', 5, '2023-02-21 15:11:24'),
(15, 'Withdrow Amount', 'WithdrowAmount', 17, '2023-02-21 15:12:34'),
(16, 'Dashboard', 'ReadAllDashboard', 4, '2023-02-21 15:13:39'),
(17, 'Deposit Repot List', 'DepositReport', 7, '2023-02-21 15:15:32'),
(18, 'Withdrow Report List', 'WithdrowReport', 8, '2023-02-21 15:16:49'),
(19, 'Print Deposit Report', 'PrintOneTransactin', 18, '2023-02-21 15:19:01'),
(20, 'Print Withdrow Report', 'PrintOneTransactin', 19, '2023-02-21 15:20:50'),
(21, 'Withdrow Amount', 'WithdrowAmount', 17, '2023-02-21 16:37:09'),
(22, 'Transfer Register', 'account_to_account_register', 3, '2023-02-21 16:39:21'),
(23, 'Cateegory Register', 'AddCategory', 11, '2023-02-21 16:40:45'),
(24, 'Delete Category', 'DeleteData', 11, '2023-02-21 16:41:14'),
(25, 'Update Category', 'UpdateData', 11, '2023-02-21 16:41:37'),
(26, 'Register System Links', 'AddLinks', 12, '2023-02-21 16:42:28'),
(27, 'Delete System Links', 'DeleteData', 12, '2023-02-21 16:43:02'),
(28, 'Update System Links', 'UpdateData', 12, '2023-02-21 16:43:29'),
(29, 'Register System Actions', 'AddActions', 13, '2023-02-21 16:44:34'),
(30, 'Delete System Actions', 'DeleteData', 13, '2023-02-21 16:44:57'),
(31, 'Print Employee', 'ReadAllEmployees', 15, '2023-02-21 16:47:40'),
(32, 'Register Authontication', 'AuthorizeUser', 20, '2023-02-25 21:54:01');

-- --------------------------------------------------------

--
-- Stand-in structure for view `system_authority`
-- (See below for the actual view)
--
CREATE TABLE `system_authority` (
`id` int(11)
,`category` varchar(100)
,`icon` varchar(100)
,`role` varchar(100)
,`link_id` int(11)
,`name` varchar(250)
,`action_id` int(11)
,`action_name` varchar(250)
);

-- --------------------------------------------------------

--
-- Table structure for table `system_links`
--

CREATE TABLE `system_links` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `link` varchar(250) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_links`
--

INSERT INTO `system_links` (`id`, `name`, `link`, `category_id`, `date`) VALUES
(1, 'Account', 'account.php', 1, '2023-02-21 14:37:13'),
(2, 'Branch', 'branch.php', 1, '2023-02-21 14:37:32'),
(3, 'Transfer', 'account_to_account.php', 1, '2023-02-21 14:38:23'),
(4, 'Dashboard', 'dashboard.php', 3, '2023-04-06 09:07:34'),
(5, 'Deposit', 'deposit.php', 1, '2023-02-21 14:38:49'),
(6, 'Withdrow', 'withdrow.php', 1, '2023-02-21 14:39:00'),
(7, 'Deposit Report', 'deposit_report.php', 1, '2023-02-21 14:39:19'),
(8, 'Withdrow Report', 'withdrow_report.php', 1, '2023-02-21 14:39:31'),
(9, 'Employee', 'employee.php', 1, '2023-02-21 14:39:47'),
(10, 'Users', 'users.php', 1, '2023-02-21 14:40:05'),
(11, 'Category', 'category.php', 1, '2023-02-21 14:40:51'),
(12, 'Sytem Links', 'system_links.php', 1, '2023-02-21 14:41:07'),
(13, 'System Actions', 'system_actions.php', 1, '2023-02-21 14:41:18'),
(14, 'Account', 'account.php', 2, '2023-02-21 14:43:16'),
(15, 'Employee', 'employee.php', 2, '2023-02-21 14:43:26'),
(16, 'Deposit', 'deposit.php', 2, '2023-02-21 14:45:44'),
(17, 'Withdrow', 'withdrow.php', 2, '2023-02-21 14:45:53'),
(18, 'Deposit Report', 'deposit_report.php', 2, '2023-02-21 14:47:30'),
(19, 'Withdrow Report', 'withdrow_report.php', 2, '2023-02-21 15:19:56'),
(20, 'User Authority', 'user_authority.php', 1, '2023-02-25 21:52:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(100) NOT NULL,
  `username` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `type` varchar(100) NOT NULL,
  `status` varchar(200) NOT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `image`, `type`, `status`, `user_id`, `date`) VALUES
('USER001', 'cadnaan', 'cadnaan5844908', 'USER001.png', 'Student', 'Active', 'xusk122', '2023-11-11 15:21:30'),
('USER003', 'cadnaan', 'admin123', 'USER003.png', 'Student', 'Active', 'xusk122', '2023-11-11 15:21:44'),
('USER005', 'samiir', '12345', 'USER005.png', 'Admin', 'Active', 'xusk122', '2023-11-11 15:17:09');

-- --------------------------------------------------------

--
-- Table structure for table `user_authority`
--

CREATE TABLE `user_authority` (
  `id` int(11) NOT NULL,
  `user_id` varchar(25) NOT NULL,
  `action_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_authority`
--

INSERT INTO `user_authority` (`id`, `user_id`, `action_id`, `date`) VALUES
(786, 'USER005', 31, '2023-04-22 22:14:42'),
(788, 'USER005', 15, '2023-04-22 22:14:42'),
(789, 'USER005', 19, '2023-04-22 22:14:43'),
(790, 'USER005', 20, '2023-04-22 22:14:43'),
(791, 'USER005', 16, '2023-04-22 22:14:43'),
(792, 'USER005', 5, '2023-04-22 22:14:43'),
(793, 'USER005', 6, '2023-04-22 22:14:43'),
(794, 'USER005', 7, '2023-04-22 22:14:43'),
(795, 'USER005', 8, '2023-04-22 22:14:43'),
(796, 'USER005', 9, '2023-04-22 22:14:43'),
(797, 'USER005', 10, '2023-04-22 22:14:43'),
(798, 'USER005', 22, '2023-04-22 22:14:43'),
(799, 'USER005', 14, '2023-04-22 22:14:43'),
(801, 'USER005', 17, '2023-04-22 22:14:43'),
(802, 'USER005', 18, '2023-04-22 22:14:43'),
(803, 'USER005', 11, '2023-04-22 22:14:43'),
(804, 'USER005', 12, '2023-04-22 22:14:44'),
(805, 'USER005', 13, '2023-04-22 22:14:44'),
(806, 'USER005', 2, '2023-04-22 22:14:44'),
(807, 'USER005', 3, '2023-04-22 22:14:44'),
(808, 'USER005', 4, '2023-04-22 22:14:44'),
(809, 'USER005', 23, '2023-04-22 22:14:44'),
(810, 'USER005', 24, '2023-04-22 22:14:44'),
(811, 'USER005', 25, '2023-04-22 22:14:44'),
(812, 'USER005', 26, '2023-04-22 22:14:44'),
(813, 'USER005', 27, '2023-04-22 22:14:44'),
(814, 'USER005', 28, '2023-04-22 22:14:44'),
(815, 'USER005', 29, '2023-04-22 22:14:44'),
(816, 'USER005', 30, '2023-04-22 22:14:44'),
(817, 'USER005', 32, '2023-04-22 22:14:44'),
(856, '12', 31, '2023-06-18 21:17:41'),
(858, '12', 15, '2023-06-18 21:17:41'),
(859, '12', 19, '2023-06-18 21:17:41'),
(860, '12', 20, '2023-06-18 21:17:41'),
(861, '12', 16, '2023-06-18 21:17:41'),
(862, '12', 5, '2023-06-18 21:17:41'),
(863, '12', 6, '2023-06-18 21:17:41'),
(864, '12', 7, '2023-06-18 21:17:41'),
(865, '12', 8, '2023-06-18 21:17:41'),
(866, '12', 9, '2023-06-18 21:17:41'),
(867, '12', 10, '2023-06-18 21:17:41'),
(868, '12', 22, '2023-06-18 21:17:41'),
(869, '12', 14, '2023-06-18 21:17:41'),
(870, '12', 17, '2023-06-18 21:17:41'),
(871, '12', 18, '2023-06-18 21:17:41'),
(872, '12', 11, '2023-06-18 21:17:41'),
(873, '12', 12, '2023-06-18 21:17:41'),
(874, '12', 13, '2023-06-18 21:17:41'),
(875, '12', 2, '2023-06-18 21:17:41'),
(876, '12', 3, '2023-06-18 21:17:42'),
(877, '12', 4, '2023-06-18 21:17:42'),
(878, '12', 23, '2023-06-18 21:17:42'),
(879, '12', 24, '2023-06-18 21:17:42'),
(880, '12', 25, '2023-06-18 21:17:42'),
(881, '12', 26, '2023-06-18 21:17:42'),
(882, '12', 27, '2023-06-18 21:17:42'),
(883, '12', 28, '2023-06-18 21:17:42'),
(884, '12', 29, '2023-06-18 21:17:42'),
(885, '12', 30, '2023-06-18 21:17:42'),
(886, '12', 32, '2023-06-18 21:17:42'),
(887, 'USER003', 2, '2023-07-25 09:04:30'),
(888, 'USER003', 3, '2023-07-25 09:04:30'),
(898, 'USER001', 2, '2023-07-25 09:07:17'),
(899, 'USER001', 3, '2023-07-25 09:07:17');

-- --------------------------------------------------------

--
-- Table structure for table `withdrow`
--

CREATE TABLE `withdrow` (
  `id` int(11) NOT NULL,
  `amount` varchar(100) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `write_amount` varchar(200) NOT NULL,
  `withdrow_persson` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `check_no` varchar(200) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure for view `system_authority`
--
DROP TABLE IF EXISTS `system_authority`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `system_authority`  AS SELECT `c`.`id` AS `id`, `c`.`name` AS `category`, `c`.`icon` AS `icon`, `c`.`role` AS `role`, `sl`.`id` AS `link_id`, `sl`.`name` AS `name`, `sa`.`id` AS `action_id`, `sa`.`name` AS `action_name` FROM ((`category` `c` left join `system_links` `sl` on(`c`.`id` = `sl`.`category_id`)) left join `system_actions` `sa` on(`sl`.`id` = `sa`.`link_id`)) ORDER BY `c`.`role` ASC, `sl`.`id` ASC, `sa`.`id` ASC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `account_to_account`
--
ALTER TABLE `account_to_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chequeno`
--
ALTER TABLE `chequeno`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit`
--
ALTER TABLE `deposit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_no` (`accout_id`),
  ADD KEY `user_id` (`userid`),
  ADD KEY `branch_id` (`branch_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_actions`
--
ALTER TABLE `system_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `link_id` (`link_id`);

--
-- Indexes for table `system_links`
--
ALTER TABLE `system_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_authority`
--
ALTER TABLE `user_authority`
  ADD PRIMARY KEY (`id`),
  ADD KEY `action_id` (`action_id`);

--
-- Indexes for table `withdrow`
--
ALTER TABLE `withdrow`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `usrer_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `account_to_account`
--
ALTER TABLE `account_to_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chequeno`
--
ALTER TABLE `chequeno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `deposit`
--
ALTER TABLE `deposit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_actions`
--
ALTER TABLE `system_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `system_links`
--
ALTER TABLE `system_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_authority`
--
ALTER TABLE `user_authority`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=901;

--
-- AUTO_INCREMENT for table `withdrow`
--
ALTER TABLE `withdrow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deposit`
--
ALTER TABLE `deposit`
  ADD CONSTRAINT `branch_id` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `system_actions`
--
ALTER TABLE `system_actions`
  ADD CONSTRAINT `link_id` FOREIGN KEY (`link_id`) REFERENCES `system_links` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `user_authority`
--
ALTER TABLE `user_authority`
  ADD CONSTRAINT `action_id` FOREIGN KEY (`action_id`) REFERENCES `system_actions` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
