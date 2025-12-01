-- Create payments table to store all payment transactions
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(100) NOT NULL UNIQUE,
  `eid` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) DEFAULT 'BDT',
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `payment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `validated_date` timestamp NULL,
  `validation_response` longtext,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`eid`) REFERENCES `employer` (`id`),
  INDEX `idx_transaction_id` (`transaction_id`),
  INDEX `idx_eid` (`eid`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create job_payments table to link jobs with payments
CREATE TABLE IF NOT EXISTS `job_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `eid` int(11) NOT NULL,
  `job_type` varchar(50) NOT NULL DEFAULT 'white_collar',
  `amount` decimal(10,2) NOT NULL,
  `payment_status` varchar(50) NOT NULL DEFAULT 'pending',
  `admin_status` varchar(50) NOT NULL DEFAULT 'pending',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin_confirmed_date` timestamp NULL,
  `admin_notes` longtext,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`pid`) REFERENCES `post` (`id`),
  FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`),
  FOREIGN KEY (`eid`) REFERENCES `employer` (`id`),
  INDEX `idx_pid` (`pid`),
  INDEX `idx_payment_id` (`payment_id`),
  INDEX `idx_payment_status` (`payment_status`),
  INDEX `idx_admin_status` (`admin_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Add columns to post table to track payment status
ALTER TABLE `post` ADD COLUMN `payment_id` int(11) NULL DEFAULT NULL AFTER `status`;
ALTER TABLE `post` ADD COLUMN `payment_status` varchar(50) NOT NULL DEFAULT 'unpaid' AFTER `payment_id`;
