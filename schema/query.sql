
--
-- Table structure for table `mob_rating`
--

CREATE TABLE `mob_rating` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `star` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_dt` int(11) DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_dt` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `mob_review`
--

CREATE TABLE `mob_review` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `comments` text,
  `order_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_dt` int(11) DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_dt` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `mob_user_address`
--

CREATE TABLE `mob_user_address` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `is_default` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_dt` int(11) DEFAULT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_dt` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for table `mob_rating`
--
ALTER TABLE `mob_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mob_review`
--
ALTER TABLE `mob_review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mob_user_address`
--
ALTER TABLE `mob_user_address`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mob_rating`
--
ALTER TABLE `mob_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `mob_review`
--
ALTER TABLE `mob_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `mob_user_address`
--
ALTER TABLE `mob_user_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;