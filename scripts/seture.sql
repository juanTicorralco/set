-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-02-2023 a las 03:29:13
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `seture`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id_category` int(11) NOT NULL,
  `name_category` text DEFAULT NULL,
  `title_list_category` text DEFAULT NULL,
  `url_category` text DEFAULT NULL,
  `image_category` text DEFAULT NULL,
  `icon_category` text DEFAULT NULL,
  `views_category` int(11) NOT NULL DEFAULT 0,
  `date_created_category` date DEFAULT NULL,
  `date_updated_category` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id_category`, `name_category`, `title_list_category`, `url_category`, `image_category`, `icon_category`, `views_category`, `date_created_category`, `date_updated_category`) VALUES
(1, 'Consumer Electric', '[\"Electronic\",\"Accessories and Parts\"]', 'consumer-electric', 'comsumer-electric.jpg', 'icon-laundry', 0, '2020-07-14', '2020-07-14 05:00:00'),
(2, 'Clothing and Apparel', '[\"Mens\",\"Womens\",\"Kids\"]', 'clothing-apparel', 'clothing-apparel.jpg', 'icon-shirt', 0, '2020-07-14', '2020-07-14 05:00:00'),
(3, 'Home, Garden and Kitchen', '[\"Home\",\"Garden\",\"Kitchen\"]', 'home-kitchen', 'home-kitchen.jpg', 'icon-lampshade', 0, '2020-07-14', '2020-07-14 05:00:00'),
(4, 'Health and Beauty', '[\"Health\",\"Beauty\"]', 'health-beauty', 'health-beauty.jpg', 'icon-heart-pulse', 0, '2020-07-14', '2020-07-14 05:00:00'),
(5, 'Jewelry and Watches', '[\"Jewelry\",\"Watches\"]', 'jewelry-watches', 'jewelry-watches.jpg', 'icon-diamond2', 0, '2020-07-14', '2020-07-14 05:00:00'),
(6, 'Computer and Technology', '[\"Computer\",\"Technology\"]', 'computer-technology', 'computer-technology.jpg', 'icon-desktop', 0, '2020-07-14', '2020-07-14 05:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comisiones`
--

CREATE TABLE `comisiones` (
  `id_comision` int(11) NOT NULL,
  `id_user_comision` int(11) DEFAULT NULL,
  `id_product_comision` int(11) DEFAULT NULL,
  `name_product_comision` text DEFAULT NULL,
  `precio_adquisicion_comision` int(11) DEFAULT NULL,
  `precio_venta_comision` int(11) DEFAULT NULL,
  `precio_comision` int(11) DEFAULT NULL,
  `date_create_comision` date DEFAULT NULL,
  `date_update_comision` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disputes`
--

CREATE TABLE `disputes` (
  `id_dispute` int(11) NOT NULL,
  `id_order_dispute` int(11) DEFAULT NULL,
  `stage_dispute` text DEFAULT NULL,
  `id_user_dispute` int(11) DEFAULT NULL,
  `id_store_dispute` int(11) DEFAULT NULL,
  `content_dispute` text DEFAULT NULL,
  `answer_dispute` text DEFAULT NULL,
  `date_created_dispute` date DEFAULT NULL,
  `date_updated_dispute` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `id_message` int(11) NOT NULL,
  `id_product_message` int(11) DEFAULT NULL,
  `id_user_message` int(11) DEFAULT NULL,
  `id_store_message` int(11) DEFAULT NULL,
  `content_message` text DEFAULT NULL,
  `answer_message` text DEFAULT NULL,
  `date_created_message` date DEFAULT NULL,
  `date_updated_message` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `newsletter`
--

CREATE TABLE `newsletter` (
  `id_newsletter` int(11) NOT NULL,
  `email_newsletter` varchar(100) CHARACTER SET armscii8 COLLATE armscii8_general_ci DEFAULT NULL,
  `name_newsletter` varchar(200) DEFAULT NULL,
  `date_create_newsletter` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `id_store_order` int(11) DEFAULT NULL,
  `id_user_order` int(11) DEFAULT NULL,
  `id_product_order` int(11) DEFAULT NULL,
  `details_order` text DEFAULT NULL,
  `name_vendor_order` text DEFAULT NULL,
  `quantity_order` int(11) DEFAULT 0,
  `price_order` float DEFAULT 0,
  `stars_order` text DEFAULT NULL,
  `email_order` text DEFAULT NULL,
  `country_order` text DEFAULT NULL,
  `city_order` text DEFAULT NULL,
  `phone_order` text DEFAULT NULL,
  `address_order` text DEFAULT NULL,
  `notes_order` text DEFAULT NULL,
  `process_order` text DEFAULT NULL,
  `status_order` text DEFAULT NULL,
  `date_created_order` date DEFAULT NULL,
  `date_updated_order` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id_product` int(11) NOT NULL,
  `approval_product` text DEFAULT NULL,
  `feedback_product` varchar(50) DEFAULT NULL,
  `state_product` text DEFAULT NULL,
  `id_store_product` int(11) DEFAULT NULL,
  `id_category_product` int(11) DEFAULT NULL,
  `id_subcategory_product` int(11) DEFAULT NULL,
  `title_list_product` text DEFAULT NULL,
  `name_product` text DEFAULT NULL,
  `url_product` text DEFAULT NULL,
  `image_product` text DEFAULT NULL,
  `price_product` varchar(100) DEFAULT '0',
  `stars_product` text DEFAULT NULL,
  `compra_product` int(11) DEFAULT NULL,
  `venta_product` int(11) DEFAULT NULL,
  `comission_product` int(11) DEFAULT NULL,
  `ready_product` int(11) DEFAULT NULL,
  `shipping_product` int(11) DEFAULT 0,
  `stock_product` int(11) DEFAULT 0,
  `delivery_time_product` int(11) DEFAULT 0,
  `offer_product` text DEFAULT NULL,
  `description_product` text DEFAULT NULL,
  `summary_product` text DEFAULT NULL,
  `details_product` text DEFAULT NULL,
  `specifications_product` text DEFAULT NULL,
  `gallery_product` text DEFAULT NULL,
  `video_product` text DEFAULT NULL,
  `top_banner_product` text DEFAULT NULL,
  `default_banner_product` text DEFAULT NULL,
  `horizontal_slider_product` text DEFAULT NULL,
  `vertical_slider_product` text DEFAULT NULL,
  `reviews_product` text DEFAULT NULL,
  `tags_product` text DEFAULT NULL,
  `sales_product` int(11) DEFAULT 0,
  `views_product` int(11) DEFAULT 0,
  `starStart_product` int(11) DEFAULT NULL,
  `win_product` int(11) DEFAULT NULL,
  `date_create_product` date DEFAULT NULL,
  `date_update_product` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales`
--

CREATE TABLE `sales` (
  `id_sale` int(11) NOT NULL,
  `id_order_sale` int(11) DEFAULT NULL,
  `id_store_sale` int(11) DEFAULT NULL,
  `name_product_sale` text DEFAULT NULL,
  `unit_price_sale` float DEFAULT 0,
  `commision_sale` float DEFAULT 0,
  `payment_method_sale` text DEFAULT NULL,
  `id_payment_sale` text DEFAULT NULL,
  `status_sale` text DEFAULT NULL,
  `date_created_sale` date DEFAULT NULL,
  `date_updated_sale` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stores`
--

CREATE TABLE `stores` (
  `id_store` int(11) NOT NULL,
  `id_user_store` int(11) DEFAULT NULL,
  `name_store` text DEFAULT NULL,
  `url_store` text DEFAULT NULL,
  `logo_store` text DEFAULT NULL,
  `cover_store` text DEFAULT NULL,
  `about_store` text DEFAULT NULL,
  `abstract_store` text DEFAULT NULL,
  `email_store` text DEFAULT NULL,
  `country_store` text DEFAULT NULL,
  `city_store` text DEFAULT NULL,
  `address_store` text DEFAULT NULL,
  `map_store` text DEFAULT NULL,
  `phone_store` text DEFAULT NULL,
  `socialnetwork_store` text DEFAULT NULL,
  `products_store` text DEFAULT NULL,
  `date_created_store` date DEFAULT NULL,
  `date_updated_store` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategories`
--

CREATE TABLE `subcategories` (
  `id_subcategory` int(11) NOT NULL,
  `id_category_subcategory` int(11) NOT NULL DEFAULT 0,
  `title_list_subcategory` text DEFAULT NULL,
  `name_subcategory` text DEFAULT NULL,
  `url_subcategory` text DEFAULT NULL,
  `image_subcategory` text DEFAULT NULL,
  `views_subcategory` int(11) NOT NULL DEFAULT 0,
  `date_created_subcategory` date DEFAULT NULL,
  `date_update_subcategory` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `subcategories`
--

INSERT INTO `subcategories` (`id_subcategory`, `id_category_subcategory`, `title_list_subcategory`, `name_subcategory`, `url_subcategory`, `image_subcategory`, `views_subcategory`, `date_created_subcategory`, `date_update_subcategory`) VALUES
(1, 1, 'Electronic', 'Home Audio and Theathers', 'home-audio-theathers', 'home-audio-theathers.jpg', 22, '2020-07-14', '2021-09-01 06:23:02'),
(2, 1, 'Electronic', 'TV and Videos', 'tv-videos', 'tv-videos.jpg', 7, '2020-07-14', '2021-09-01 06:23:02'),
(3, 1, 'Electronic', 'Camera, Photos and Videos', 'camera-photos-videos', 'camera-photos-videos.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(4, 1, 'Electronic', 'Cellphones and Accessories', 'cellphones-accessories', 'cellphones-accessories.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(5, 1, 'Electronic', 'Headphones', 'headphones', 'headphones.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(6, 1, 'Electronic', 'Video games', 'video-games', 'video-games.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(7, 1, 'Electronic', 'Wireless Speakers', 'wireless-speakers', 'wireless-speakers.jpg', 6, '2020-07-14', '2021-09-01 06:23:02'),
(8, 1, 'Electronic', 'Office Electronic', 'office-electronic', 'office-electronic.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(9, 1, 'Accessories and Parts', 'Digital Cables', 'digital-cables', 'digital-cables.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(10, 1, 'Accessories and Parts', 'Audio and Video Cables', 'audio-video-cables', 'audio-video-cables.jpg', 2, '2020-07-14', '2021-09-01 06:23:02'),
(11, 1, 'Accessories and Parts', 'Batteries', 'batteries', 'batteries.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(12, 2, 'Mens', 'Sportswear man', 'sportswear-man', 'sportswear-man.jpg', 4, '2020-07-14', '2021-09-01 06:23:02'),
(13, 2, 'Mens', 'Elegant clothes man', 'elegant-clothes-man', 'elegant-clothes-man.jpg', 10, '2020-07-14', '2021-09-01 06:23:02'),
(14, 2, 'Mens', 'Classic clothes man', 'classic-clothes-man', 'classic-clothes-man.jpg', 3, '2020-07-14', '2021-09-01 06:23:02'),
(15, 2, 'Womens', 'Sportswear woman', 'sportswear-woman', 'sportswear-woman.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(16, 2, 'Womens', 'Elegant clothes woman', 'elegant-clothes-woman', 'elegant-clothes-woman.jpg', 1, '2020-07-14', '2021-09-01 06:23:02'),
(17, 2, 'Womens', 'Classic clothes woman', 'classic-clothes-woman', 'classic-clothes-woman.jpg', 4, '2020-07-14', '2021-09-01 06:23:02'),
(18, 2, 'Kids', 'Sportswear kids', 'sportswear-kids', 'sportswear-kids.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(19, 2, 'Kids', 'Elegant clothes kids', 'elegant-clothes-kids', 'elegant-clothes-kids.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(20, 2, 'Kids', 'Classic clothes kids', 'classic-clothes-kids', 'classic-clothes-kids.jpg', 5, '2020-07-14', '2021-09-01 06:23:02'),
(21, 3, 'Home', 'Cookware', 'cookware', 'cookware.jpg', 2, '2020-07-14', '2021-09-01 06:23:02'),
(22, 3, 'Home', 'Decoration', 'decoration', 'decoration.jpg', 1, '2020-07-14', '2021-09-01 06:23:02'),
(23, 3, 'Home', 'Furniture', 'furniture', 'furniture.jpg', 7, '2020-07-14', '2021-09-01 06:23:02'),
(24, 3, 'Garden', 'Garden Tools', 'garden-tools', 'garden-tools.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(25, 3, 'Garden', 'Garden Equipments', 'garden-equipments', 'garden-equipments.jpg', 1, '2020-07-14', '2021-09-01 06:23:02'),
(26, 3, 'Garden', 'Powers and Hand Tools', 'powers-hand-tools', 'powers-hand-tools.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(27, 3, 'Garden', 'Utensil and Gadget', 'utensil-gadget', 'utensil-gadget.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(28, 3, 'Kitchen', 'Kitchen Equipments', 'kitchen-equipments', 'kitchen-equipments.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(29, 3, 'Kitchen', 'Kitchen Utensil', 'kitchen-utensil', 'kitchen-utensil.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(30, 4, 'Health', 'Yoga Instrument', 'yoga-Instrument', 'yoga-Instrument.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(31, 4, 'Health', 'Passive Gymnastics', 'passive-gymnastics', 'passive-gymnastics.jpg', 1, '2020-07-14', '2021-09-01 06:23:02'),
(32, 4, 'Health', 'Gym Equipment', 'gym-equipment', 'gym-equipment.jpg', 1, '2020-07-14', '2021-09-01 06:23:02'),
(33, 4, 'Beauty', 'Hair Care', 'hair-care', 'hair-care.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(34, 4, 'Beauty', 'Makeup', 'makeup', 'makeup.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(35, 4, 'Beauty', 'Perfume', 'perfume', 'perfume.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(36, 5, 'Jewelry', 'Necklace', 'necklace', 'necklace.jpg', 24, '2020-07-14', '2021-09-01 06:23:02'),
(37, 5, 'Jewelry', 'Pendant', 'pendant', 'pendant.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(38, 5, 'Jewelry', 'Ring', 'ring', 'ring.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(39, 5, 'Watches', 'Sport Watch', 'sport-watch', 'sport-watch.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(40, 5, 'Watches', 'Womens Watch', 'womens-watch', 'womens-watch.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(41, 5, 'Watches', 'Mens Watch', 'mens-watch', 'mens-watch.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(42, 6, 'Computer', 'Desktop PC', 'desktop-pc', 'desktop-pc.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(43, 6, 'Computer', 'Laptop', 'laptop', 'laptop.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(44, 6, 'Computer', 'Audio and Video', 'audio-video', 'audio-video.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(45, 6, 'Technology', 'Smartphones', 'smartphones', 'smartphones.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(46, 6, 'Technology', 'Tablets', 'tablets', 'tablets.jpg', 0, '2020-07-14', '2021-09-01 06:23:02'),
(47, 6, 'Technology', 'Wireless Speaker', 'wireless-speaker', 'wireless-speaker.jpg', 0, '2020-07-14', '2021-09-01 06:23:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `rol_user` text DEFAULT NULL,
  `picture_user` text DEFAULT NULL,
  `displayname_user` text DEFAULT NULL,
  `username_user` text DEFAULT NULL,
  `password_user` text DEFAULT NULL,
  `email_user` text DEFAULT NULL,
  `map_user` text DEFAULT NULL,
  `country_user` text DEFAULT NULL,
  `city_user` text DEFAULT NULL,
  `phone_user` text DEFAULT NULL,
  `address_user` text DEFAULT NULL,
  `token_user` text DEFAULT NULL,
  `token_exp_user` text DEFAULT NULL,
  `method_user` text DEFAULT NULL,
  `wishlist_user` text DEFAULT NULL,
  `verificated_user` int(11) NOT NULL DEFAULT 0,
  `date_created_user` date DEFAULT NULL,
  `date_updated_user` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`);

--
-- Indices de la tabla `comisiones`
--
ALTER TABLE `comisiones`
  ADD PRIMARY KEY (`id_comision`),
  ADD KEY `id_product_comision` (`id_product_comision`),
  ADD KEY `id_user_comision` (`id_user_comision`);

--
-- Indices de la tabla `disputes`
--
ALTER TABLE `disputes`
  ADD PRIMARY KEY (`id_dispute`),
  ADD KEY `id_order_dispute` (`id_order_dispute`),
  ADD KEY `id_store_dispute` (`id_store_dispute`),
  ADD KEY `id_user_dispute` (`id_user_dispute`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `id_product_message` (`id_product_message`),
  ADD KEY `id_store_message` (`id_store_message`),
  ADD KEY `id_user_message` (`id_user_message`);

--
-- Indices de la tabla `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id_newsletter`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_product_order` (`id_product_order`),
  ADD KEY `id_store_order` (`id_store_order`),
  ADD KEY `id_user_order` (`id_user_order`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `id_category_product` (`id_category_product`),
  ADD KEY `id_subcategory_product` (`id_subcategory_product`),
  ADD KEY `id_store_product` (`id_store_product`);

--
-- Indices de la tabla `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id_sale`),
  ADD KEY `id_order_sale` (`id_order_sale`),
  ADD KEY `sales_ibfk_1` (`id_store_sale`);

--
-- Indices de la tabla `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id_store`),
  ADD KEY `id_user_store` (`id_user_store`);

--
-- Indices de la tabla `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id_subcategory`),
  ADD KEY `id_category_subcategory` (`id_category_subcategory`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `comisiones`
--
ALTER TABLE `comisiones`
  MODIFY `id_comision` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `disputes`
--
ALTER TABLE `disputes`
  MODIFY `id_dispute` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id_newsletter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `sales`
--
ALTER TABLE `sales`
  MODIFY `id_sale` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `stores`
--
ALTER TABLE `stores`
  MODIFY `id_store` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id_subcategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comisiones`
--
ALTER TABLE `comisiones`
  ADD CONSTRAINT `comisiones_ibfk_1` FOREIGN KEY (`id_product_comision`) REFERENCES `products` (`id_product`),
  ADD CONSTRAINT `comisiones_ibfk_2` FOREIGN KEY (`id_user_comision`) REFERENCES `users` (`id_user`);

--
-- Filtros para la tabla `disputes`
--
ALTER TABLE `disputes`
  ADD CONSTRAINT `disputes_ibfk_1` FOREIGN KEY (`id_order_dispute`) REFERENCES `orders` (`id_order`),
  ADD CONSTRAINT `disputes_ibfk_2` FOREIGN KEY (`id_store_dispute`) REFERENCES `stores` (`id_store`),
  ADD CONSTRAINT `disputes_ibfk_3` FOREIGN KEY (`id_user_dispute`) REFERENCES `users` (`id_user`);

--
-- Filtros para la tabla `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`id_product_message`) REFERENCES `products` (`id_product`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`id_store_message`) REFERENCES `stores` (`id_store`),
  ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`id_user_message`) REFERENCES `users` (`id_user`);

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_product_order`) REFERENCES `products` (`id_product`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`id_store_order`) REFERENCES `stores` (`id_store`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`id_user_order`) REFERENCES `users` (`id_user`);

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`id_category_product`) REFERENCES `categories` (`id_category`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`id_subcategory_product`) REFERENCES `subcategories` (`id_subcategory`),
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`id_store_product`) REFERENCES `stores` (`id_store`);

--
-- Filtros para la tabla `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `stores_ibfk_1` FOREIGN KEY (`id_user_store`) REFERENCES `users` (`id_user`);

--
-- Filtros para la tabla `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`id_category_subcategory`) REFERENCES `categories` (`id_category`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
