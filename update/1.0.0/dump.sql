--
-- Структура таблицы `prefix_property`
--

CREATE TABLE `prefix_property` (
  `id` int(11) NOT NULL,
  `target_type` varchar(50) NOT NULL,
  `type` enum('int','float','varchar','text','checkbox','select','tags','video_link') NOT NULL DEFAULT 'text',
  `code` varchar(50) NOT NULL,
  `title` varchar(250) NOT NULL,
  `date_create` datetime NOT NULL,
  `sort` int(11) NOT NULL,
  `validate_rules` varchar(500) DEFAULT NULL,
  `params` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_property_select`
--

CREATE TABLE `prefix_property_select` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `target_type` varchar(50) NOT NULL,
  `value` varchar(250) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_property_target`
--

CREATE TABLE `prefix_property_target` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `date_create` datetime NOT NULL,
  `date_update` datetime DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '1',
  `params` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_property_value`
--

CREATE TABLE `prefix_property_value` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `property_type` varchar(30) NOT NULL,
  `target_type` varchar(50) NOT NULL,
  `target_id` int(11) NOT NULL,
  `value_int` int(11) DEFAULT NULL,
  `value_float` float(11,2) DEFAULT NULL,
  `value_varchar` varchar(250) DEFAULT NULL,
  `value_text` text,
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_property_value_select`
--

CREATE TABLE `prefix_property_value_select` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `target_type` varchar(50) NOT NULL,
  `target_id` int(11) NOT NULL,
  `select_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `prefix_property_value_tag`
--

CREATE TABLE `prefix_property_value_tag` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `target_type` varchar(50) NOT NULL,
  `target_id` int(11) NOT NULL,
  `text` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы таблицы `prefix_property`
--
ALTER TABLE `prefix_property`
  ADD PRIMARY KEY (`id`),
  ADD KEY `target_type` (`target_type`),
  ADD KEY `code` (`code`),
  ADD KEY `type` (`type`),
  ADD KEY `date_create` (`date_create`),
  ADD KEY `sort` (`sort`);

--
-- Индексы таблицы `prefix_property_select`
--
ALTER TABLE `prefix_property_select`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`),
  ADD KEY `target_type` (`target_type`),
  ADD KEY `sort` (`sort`);

--
-- Индексы таблицы `prefix_property_target`
--
ALTER TABLE `prefix_property_target`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `date_create` (`date_create`),
  ADD KEY `date_update` (`date_update`),
  ADD KEY `state` (`state`);

--
-- Индексы таблицы `prefix_property_value`
--
ALTER TABLE `prefix_property_value`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`),
  ADD KEY `target_type` (`target_type`),
  ADD KEY `target_id` (`target_id`),
  ADD KEY `value_int` (`value_int`),
  ADD KEY `property_type` (`property_type`),
  ADD KEY `value_float` (`value_float`),
  ADD KEY `value_varchar` (`value_varchar`);

--
-- Индексы таблицы `prefix_property_value_select`
--
ALTER TABLE `prefix_property_value_select`
  ADD PRIMARY KEY (`id`),
  ADD KEY `target_type` (`target_type`),
  ADD KEY `target_id` (`target_id`),
  ADD KEY `property_id` (`property_id`),
  ADD KEY `select_id` (`select_id`);

--
-- Индексы таблицы `prefix_property_value_tag`
--
ALTER TABLE `prefix_property_value_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `target_type` (`target_type`),
  ADD KEY `target_id` (`target_id`),
  ADD KEY `text` (`text`),
  ADD KEY `property_id` (`property_id`);

--
-- AUTO_INCREMENT для таблицы `prefix_property`
--
ALTER TABLE `prefix_property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `prefix_property_select`
--
ALTER TABLE `prefix_property_select`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `prefix_property_target`
--
ALTER TABLE `prefix_property_target`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `prefix_property_value`
--
ALTER TABLE `prefix_property_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `prefix_property_value_select`
--
ALTER TABLE `prefix_property_value_select`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `prefix_property_value_tag`
--
ALTER TABLE `prefix_property_value_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;