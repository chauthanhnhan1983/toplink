

--
-- Table structure for table `toplink_feeds`
--

DROP TABLE IF EXISTS `toplink_feeds`;
CREATE TABLE `toplink_feeds` (
  `feed_id` int NOT NULL AUTO_INCREMENT,
  `reference_id` varchar(25) NOT NULL,
  `author_id` varchar(25) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `extraced_url` varchar(150) NOT NULL,
  `social_type` varchar(20) NOT NULL,
  PRIMARY KEY (`feed_id`)
);


--
-- Table structure for table `toplink_shareddomain`
--

DROP TABLE IF EXISTS `toplink_shareddomain`;

CREATE TABLE `toplink_shareddomain` (
  `domain_id` int NOT NULL AUTO_INCREMENT,
  `domain_url` varchar(150) NOT NULL,
  `counting` int NOT NULL,
  PRIMARY KEY (`domain_id`)
) ;


--
-- Table structure for table `toplink_sharedlinks`
--

DROP TABLE IF EXISTS `toplink_sharedlinks`;
CREATE TABLE `toplink_sharedlinks` (
  `link_id` int NOT NULL AUTO_INCREMENT,
  `link_url` varchar(150) NOT NULL,
  `counting` int NOT NULL,
  PRIMARY KEY (`link_id`)
) ;


--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255)   NOT NULL,
  `email` varchar(255)   NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255)   NOT NULL,
  `remember_token` varchar(100)   DEFAULT NULL,
  `twitter_id` varchar(40)  DEFAULT NULL,
  `twitter_username` varchar(80)  NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ;
