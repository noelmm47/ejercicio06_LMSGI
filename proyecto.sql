-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: bbdd
-- Tiempo de generación: 22-04-2026 a las 18:34:19
-- Versión del servidor: 5.7.44
-- Versión de PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `AUTORES`
--

CREATE TABLE `AUTORES` (
  `ID` int(11) NOT NULL,
  `AUTOR` varchar(200) COLLATE utf8_bin NOT NULL,
  `FECHA_NACIMIENTO` date NOT NULL,
  `LUGAR_NACIMIENTO` varchar(200) COLLATE utf8_bin NOT NULL,
  `FECHA_DEFUNCION` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `AUTORES`
--

INSERT INTO `AUTORES` (`ID`, `AUTOR`, `FECHA_NACIMIENTO`, `LUGAR_NACIMIENTO`, `FECHA_DEFUNCION`) VALUES
(1, 'J. R. R. Tolkien', '1892-01-03', 'Bloemfontein', '1973-09-02'),
(2, 'Ernest Hemingway', '1899-07-21', 'Oak Park', '1961-07-02'),
(3, 'C. S. Lewis', '1898-11-29', 'Belfast', '1963-11-22'),
(4, 'Susan E. Hinton', '1948-07-22', 'Tulsa', NULL),
(5, 'J. K. Rowling', '1965-07-31', 'Yate', NULL),
(6, 'George R. R. Martin', '1948-09-20', 'Bayonne', NULL),
(7, 'Fred Uhlman', '1901-01-19', 'Stuttgart', '1985-04-11'),
(8, 'Joël Dicker', '1985-06-16', 'Ginebra', NULL),
(9, 'Mary Ann Shaffer', '1934-12-13', 'Martinsburg', '2008-02-16'),
(10, 'Patricia García-Rojo', '1984-09-24', 'Jaén', NULL),
(11, 'Mark Haddon', '1962-10-28', 'Northampton', NULL),
(12, 'Berlie Doherty', '1943-11-06', 'Knotty Ash', NULL),
(13, 'Jane Austen', '1775-12-16', 'Steventon', '1817-07-18'),
(14, 'Mitch Albom', '1958-05-23', 'Passaic', NULL),
(15, 'David Lozano', '1974-10-30', 'Zaragoza', NULL),
(16, 'María Menéndez-Ponte', '1962-01-01', 'Coruña', NULL),
(17, 'Gabriel García Márquez', '1927-03-06', 'Aracataca', '2014-04-17'),
(18, 'Patrick Rothfuss', '1973-06-06', 'Madison', NULL),
(19, 'Michael Ende', '1929-11-12', 'Garmisch-Partenkirchen', '1995-08-28'),
(20, 'Brandon Sanderson', '1975-12-19', 'Lincoln', NULL),
(21, 'Philip K. Dick', '1928-12-16', 'Illinois', '1982-03-02'),
(22, 'Carlos Ruiz Zafón', '1964-09-25', 'Barcelona', '2020-06-19'),
(23, 'Laura Gallego', '1977-10-11', 'Cuart de Poblet', NULL),
(24, 'R. L. Stevenson', '1850-11-13', 'Edimburgo', '1894-12-03'),
(25, 'Roald Dahl', '1916-09-13', 'Llandaff', '1990-11-23'),
(26, 'Scott Fitzgerald', '1986-09-26', 'Minnesota', '1940-12-21'),
(27, 'Ray Bradbury ', '1920-08-22', 'Illinois', '2012-06-05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CLIENTES`
--

CREATE TABLE `CLIENTES` (
  `ID` int(11) NOT NULL,
  `NOMBRE` varchar(100) COLLATE utf8_bin NOT NULL,
  `APELLIDOS` varchar(200) COLLATE utf8_bin NOT NULL,
  `DNI` varchar(10) COLLATE utf8_bin NOT NULL,
  `DIRECCION` text COLLATE utf8_bin NOT NULL,
  `POBLACION` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `CLIENTES`
--

INSERT INTO `CLIENTES` (`ID`, `NOMBRE`, `APELLIDOS`, `DNI`, `DIRECCION`, `POBLACION`) VALUES
(1, 'Lorena', 'FernÃ¡ndez', '09098098X', 'Calle Sol', 'Haiti'),
(2, 'Gonzalo', 'Sanchez', '33333333Z', 'c/asdfg', 'Grado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `LIBROS`
--

CREATE TABLE `LIBROS` (
  `ID` int(2) NOT NULL,
  `TITULO` varchar(63) COLLATE utf8_bin DEFAULT NULL,
  `AUTOR_ID` int(2) DEFAULT NULL,
  `GENERO` varchar(17) COLLATE utf8_bin DEFAULT NULL,
  `EDITORIAL` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `PAGINAS` int(3) DEFAULT NULL,
  `AÑO` date DEFAULT NULL,
  `PRECIO` decimal(4,2) DEFAULT NULL,
  `ESTADO` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT 'Disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `LIBROS`
--

INSERT INTO `LIBROS` (`ID`, `TITULO`, `AUTOR_ID`, `GENERO`, `EDITORIAL`, `PAGINAS`, `AÑO`, `PRECIO`, `ESTADO`) VALUES
(1, 'El Señor de los anillos: La comunidad del anillo', 1, 'Fantástico', 'Minotauro', 488, '1954-01-01', 18.00, 'Disponible'),
(2, 'El viejo y el mar', 2, 'Novela', 'Debolsillo', 208, '1952-01-01', 10.95, 'Disponible'),
(3, 'Las Crónicas de Narnia: El león, la bruja y el armario', 3, 'Fantástico', 'Destino', 240, '1950-01-01', 15.00, 'Disponible'),
(4, 'Rebeldes', 4, 'Drama', 'Alfaguara', 224, '1967-01-01', 12.00, 'Disponible'),
(5, 'Harry Potter y la prisionero de Azkaban', 5, 'Fantástico', 'Salamandra', 264, '1999-01-01', 18.00, 'Disponible'),
(6, 'Canción de hielo y fuego: Juego de Tronos', 6, 'Fantástico', 'Planeta', 800, '1996-01-01', 20.00, 'Disponible'),
(7, 'Reencuentro', 7, 'Drama', 'Tusquets', 128, '1971-01-01', 10.00, 'Disponible'),
(8, 'La verdad sobre el caso Harry Quebert', 8, 'Policíaco', 'Alfaguara', 672, '2012-01-01', 12.95, 'Disponible'),
(9, 'La sociedad literaria y el pastel de piel de patata de Guernsey', 9, 'Novela epistolar', 'Salamandra', 274, '2007-01-01', 10.00, 'Disponible'),
(10, 'El mar', 10, 'Fantástico', 'SM', 260, '2015-01-01', 12.95, 'Disponible'),
(11, 'El curioso incidente del perro a medianoche', 11, 'Novela', 'Salamandra', 270, '2003-01-01', 10.00, 'Disponible'),
(12, 'La hija del mar', 12, 'Fantástico', 'SM', 112, '1996-01-01', 10.00, 'Disponible'),
(13, 'Orgullo y prejuicio', 13, 'Novela', 'Penguin', 448, '1813-01-01', 12.00, 'Disponible'),
(14, 'Martes con mi viejo profesor', 14, 'Novela biográfica', 'Maeva', 143, '1997-01-01', 13.00, 'Disponible'),
(15, 'Desconocidos', 15, 'Policíaco', 'Edebé', 221, '2018-01-01', 12.00, 'Disponible'),
(16, 'Nunca seré tu héroe', 16, 'Novela', 'SM', 192, '1998-01-01', 10.95, 'Disponible'),
(17, 'Crónica de una muerte anunciada', 17, 'Policíaco', 'Debolsillo', 156, '1981-01-01', 9.95, 'Disponible'),
(18, 'El nombre del viento', 18, 'Fantástico', 'Debolsillo', 880, '2007-01-01', 22.00, 'Disponible'),
(19, 'La historia interminable', 19, 'Fantástico', 'Alfaguara', 496, '1979-01-01', 15.00, 'Disponible'),
(20, 'La ley de la calle', 4, 'Drama', 'Alfaguara', 112, '1975-01-01', 10.00, 'Disponible'),
(21, 'Nacidos de la bruma: El imperio final', 20, 'Fantástico', 'Nova', 841, '2006-01-01', 20.00, 'Disponible'),
(22, '¿Sueñan los androides con ovejas eléctricas?', 21, 'Ciencia ficción', 'Minotauro', 272, '1968-01-01', 10.00, 'Disponible'),
(23, 'El príncipe de la niebla', 22, 'Fantástico', 'Edebé', 240, '1993-01-01', 14.00, 'Disponible'),
(24, 'La leyenda del rey errante', 23, 'Fantástico', 'SM', 560, '2004-01-01', 21.00, 'Disponible'),
(25, 'La isla del tesoro', 24, 'Aventuras', 'Edelvives', 288, '1883-01-01', 24.90, 'Disponible'),
(26, 'Matilda', 25, 'Infantil', 'Loqueleo', 288, '1988-01-01', 10.00, 'Disponible'),
(27, 'El gran Gatsby', 26, 'Drama', 'Austral', 224, '1925-01-01', 11.50, 'Disponible'),
(28, 'Fahrenheit 451', 27, 'Ciencia ficción', 'Debolsillo', 192, '1953-01-01', 12.50, 'Disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PELICULAS`
--

CREATE TABLE `PELICULAS` (
  `ID` int(2) NOT NULL,
  `TITULO` varchar(63) COLLATE utf8_bin DEFAULT NULL,
  `AÑO_ESTRENO` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `DIRECTOR` varchar(25) COLLATE utf8_bin DEFAULT NULL,
  `ACTORES` varchar(112) COLLATE utf8_bin DEFAULT NULL,
  `GENERO` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `TIPO_ADAPTACION` varchar(8) COLLATE utf8_bin DEFAULT NULL,
  `ADAPTACION_ID` int(2) DEFAULT NULL,
  `ESTADO` varchar(10) COLLATE utf8_bin NOT NULL DEFAULT 'Disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `PELICULAS`
--

INSERT INTO `PELICULAS` (`ID`, `TITULO`, `AÑO_ESTRENO`, `DIRECTOR`, `ACTORES`, `GENERO`, `TIPO_ADAPTACION`, `ADAPTACION_ID`, `ESTADO`) VALUES
(1, 'El editor de libros', '2016-01-01', 'Michael Grandage', 'Colin Firth, Jude Law, Nicole Kidman', 'Biografía', 'Película', NULL, 'Reservado'),
(2, 'La historia interminable', '1984-01-01', 'Wolfgang Petersen', 'Barret Oliver, Noah Hathaway, Moses Gunn', 'Fantasía', 'Película', 19, 'Disponible'),
(3, 'La ladrona de libros', '2013-01-01', 'Brian Percival', 'Sophie Nélisse, Geoffrey Rush, Emily Watson, Nico Liersch', 'Drama', 'Película', NULL, 'Disponible'),
(4, 'La bruja novata', '1971-01-01', 'Robert Stevenson', 'Angela Lansbury, David Tomlinson, Roddy McDowall', 'Fantasía', 'Película', NULL, 'Disponible'),
(5, 'Harry Potter y el prisionero de Azkaban', '2004-01-01', 'Alfonso Cuarón', 'Daniel Radcliffe, Rupert Grint, Emma Watson', 'Fantasía', 'Película', 5, 'Disponible'),
(6, 'El señor de los anillos: La comunidad del anillo', '2001-01-01', 'Peter Jackson', 'Elijah Wood, Ian McKellen, Viggo Mortensen', 'Fantasía', 'Película', 1, 'Disponible'),
(7, 'Charlie y la fábrica de chocolate', '2005-01-01', 'Tim Burton', 'Johnny Depp, Freddie Highmore, David Kelly, Deep Roy', 'Fantasía', 'Película', NULL, 'Disponible'),
(8, 'Las Crónicas de Narnia: El león, la bruja y el armario', '2005-01-01', 'Andrew Adamson', 'Georgie Henley, William Moseley, Skandar Keynes, Anna Popplewell, Tilda Swinton', 'Fantasía', 'Película', NULL, 'Disponible'),
(9, 'Rebeldes', '1983-01-01', 'Francis Ford Coppola', 'C. Thomas Howell, Matt Dillon, Ralph Macchio, Diane Lane, Rob Lowe, Patrick Swayze, Emilio Estévez, Tom Cruise', 'Drama', 'Película', 4, 'Disponible'),
(10, 'Juego de Tronos: Temporada 1', '2011-01-01', 'David Benioff, D.B. Weiss', 'Emilia Clarke, Kit Harington, Lena Headey, Peter Dinklage, Maisie Williams, Nikolaj Coster-Waldau, Sophie Turner', 'Fantasía', 'Serie', 6, 'Disponible'),
(11, 'La verdad sobre el caso Harry Quebert', '2018-01-01', 'Jean-Jacques Annaud', 'Patrick Dempsey, Ben Schnetzer, Kristine Froseth, Damon Wayans Jr.', 'Policíaco', 'Serie', 8, 'Disponible'),
(12, 'La sociedad literaria y el pastel de piel de patata de Guernsey', '2018-01-01', 'Mike Newell', 'Lily James, Michiel Huisman, Glen Powell, Jessica Brown Findlay, Matthew Goode', 'Drama', 'Película', 9, 'Disponible'),
(13, 'Orgullo y prejuicio', '2005-01-01', 'Joe Wright', 'Keira Knightley, Matthew Macfadyen, Brenda Blethyn, Donald Sutherland', 'Romance', 'Película', 13, 'Disponible'),
(14, 'Orgullo y prejuicio', '1995-01-01', 'Simon Langton', 'Colin Firth, Jennifer Ehle, David Bamber, Crispin Bonham-carter, Anna Chancellor', 'Romance', 'Serie', 13, 'Disponible'),
(15, 'Crónica de una muerte anunciada', '1987-01-01', 'Francesco Rosi', 'Anthony Delon, Rupert Everett, Lucía Bosé, Ornella Muti, Gian Maria Volonté', 'Drama', 'Película', NULL, 'Disponible'),
(16, 'La ley de la calle', '1983-01-01', 'Francis Ford Coppola', 'Matt Dillon, Mickey Rourke, Diane Lane, Dennis Hopper, Nicolas Cage', 'Drama', 'Película', 20, 'Disponible'),
(17, 'Blade Runner', '1982-01-01', 'Ridley Scott', 'Harrison Ford, Rutger Hauer, Sean Young, Daryl Hannah, Edward James Olmos', 'Ciencia ficción', 'Película', 22, 'Disponible'),
(18, 'La isla del tesoro', '1934-01-01', 'Victor Fleming', 'Jackie Cooper, Wallace Beery, Lewis Stone, Lionel Barrymore, Otto Kruger', 'Aventuras', 'Película', 25, 'Disponible'),
(19, 'La isla del tesoro', '1950-01-01', 'Byron Haskin', 'Bobby Driscoll, Robert Newton, Basil Sydney, Walter Fitzgerald, Denis O\'Dea', 'Aventuras', 'Película', 25, 'Disponible'),
(20, 'La isla del tesoro', '1990-01-01', 'Fraser Clarke Heston', 'Charlton Heston, Christian Bale, Oliver Reed, Christopher Lee, Richard Johnson', 'Aventuras', 'Serie', 25, 'Disponible'),
(21, 'Matilda', '1996-01-01', 'Danny DeVito', 'Mara Wilson, Danny DeVito, Rhea Perlman, Embeth Davidtz, Pam Ferris', 'Infantil', 'Película', NULL, 'Disponible'),
(22, 'Un mundo de fantasía', '1971-01-01', 'Mel Stuart', 'Gene Wilder, Jack Albertson, Peter Ostrum, Roy Kinnear, Michael Bollner', 'Infantil', 'Película', NULL, 'Disponible'),
(23, 'Por quién doblan las campanas', '1943-01-01', 'Sam Wood', 'Gary Cooper, Ingrid Bergman, Akim Tamiroff, Arturo de Córdova, Vladimir Sokoloff', 'Drama', 'Película', NULL, 'Disponible'),
(24, 'Harry Potter y el cáliz de fuego', '2005-01-01', 'Mike Newell', 'Daniel Radcliffe, Rupert Grint, Emma Watson, Robbie Coltrane, Michael Gambon', 'Fantasía', 'Película', NULL, 'Disponible'),
(25, 'El gran Gatsby', '1949-01-01', 'Elliott Nugent', 'Alan Ladd, Betty Field, Macdonald Carey, Ruth Hussey, Barry Sullivan', 'Drama', 'Película', 27, 'Disponible'),
(26, 'El gran Gatsby', '1974-01-01', 'Jack Clayton', 'Robert Redford, Mia Farrow, Bruce Dern, Karen Black, Scott Wilson', 'Drama', 'Película', 27, 'Disponible'),
(27, 'El gran Gatsby', '2000-01-01', 'Robert Markowitz', 'Mira Sorvino, Toby Stephens, Paul Rudd, Martin Donovan, Francie Swift', 'Drama', 'Serie', 27, 'Disponible'),
(28, 'El gran Gatsby', '2013-01-01', 'Baz Luhrmann', 'Leonardo DiCaprio, Tobey Maguire, Carey Mulligan, Joel Edgerton, Isla Fisher', 'Drama', 'Película', 27, 'Disponible'),
(29, 'Fahrenheit 451', '1966-01-01', 'François Truffaut', 'Julie Christie, Oskar Werner, Cyril Cusack, Anton Diffring, Jeremy Spenser, Ann Bell', 'Ciencia ficción', 'Película', 26, 'Disponible'),
(30, 'Fahrenheit 451', '2018-01-01', 'Ramin Bahrani', 'Michael B. Jordan, Michael Shannon, Sofia Boutella, Laura Harrier, Lilly Singh', 'Ciencia ficción', 'Película', 26, 'Disponible');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `RESERVAS`
--

CREATE TABLE `RESERVAS` (
  `ID` int(11) NOT NULL,
  `ID_LIBRO` int(11) DEFAULT NULL,
  `ID_PELICULA` int(11) DEFAULT NULL,
  `FECHA_RESERVA` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `RESERVAS`
--

INSERT INTO `RESERVAS` (`ID`, `ID_LIBRO`, `ID_PELICULA`, `FECHA_RESERVA`) VALUES
(1, 4, 16, '2026-01-28'),
(1, NULL, 1, '2026-04-15'),
(1, NULL, 3, '2026-04-15'),
(1, NULL, 3, '2026-04-15'),
(1, NULL, 1, '2026-04-20'),
(1, NULL, 1, '2026-04-20'),
(1, NULL, 1, '2026-04-20'),
(1, NULL, 1, '2026-04-20'),
(2, NULL, 12, '2026-04-20'),
(1, NULL, 11, '2026-04-20'),
(2, NULL, 11, '2026-04-20'),
(2, NULL, 11, '2026-04-20'),
(2, NULL, 7, '2026-04-20'),
(1, NULL, 1, '2026-04-21'),
(1, NULL, 1, '2026-04-21'),
(1, NULL, 1, '2026-04-21'),
(1, NULL, 1, '2026-04-21'),
(1, 1, NULL, '2026-04-21'),
(1, NULL, 1, '2026-04-21'),
(2, NULL, 1, '2026-04-21'),
(2, NULL, 1, '2026-04-21'),
(2, NULL, 1, '2026-04-21'),
(1, NULL, 1, '2026-04-21'),
(2, NULL, 1, '2026-04-21'),
(2, NULL, 13, '2026-04-21'),
(1, NULL, 2, '2026-04-21'),
(2, NULL, 2, '2026-04-21'),
(2, NULL, 2, '2026-04-21'),
(2, NULL, 5, '2026-04-21'),
(1, NULL, 28, '2026-04-21'),
(2, NULL, 1, '2026-04-21'),
(2, NULL, 1, '2026-04-21'),
(1, 1, NULL, '2026-04-21'),
(2, NULL, 3, '2026-04-22'),
(2, NULL, 3, '2026-04-22'),
(2, NULL, 3, '2026-04-22'),
(2, NULL, 3, '2026-04-22'),
(1, 28, NULL, '2026-04-22'),
(2, 10, NULL, '2026-04-22'),
(2, NULL, 2, '2026-04-22'),
(2, NULL, 2, '2026-04-22'),
(2, NULL, 2, '2026-04-22'),
(2, 11, NULL, '2026-04-22'),
(2, 8, NULL, '2026-04-22'),
(2, 3, NULL, '2026-04-22'),
(2, 5, NULL, '2026-04-22'),
(2, 5, NULL, '2026-04-22'),
(2, 5, NULL, '2026-04-22'),
(2, 5, NULL, '2026-04-22'),
(2, 5, NULL, '2026-04-22'),
(2, 5, NULL, '2026-04-22'),
(1, 4, NULL, '2026-04-22'),
(2, NULL, 1, '2026-04-22'),
(1, 6, NULL, '2026-04-22'),
(1, 1, NULL, '2026-04-22'),
(1, 2, NULL, '2026-04-22'),
(2, 1, NULL, '2026-04-22'),
(1, NULL, 1, '2026-04-22'),
(1, NULL, 1, '2026-04-22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USUARIOS`
--

CREATE TABLE `USUARIOS` (
  `ID` int(11) NOT NULL,
  `USER` varchar(20) COLLATE utf8_bin NOT NULL,
  `PASS` varchar(256) COLLATE utf8_bin NOT NULL,
  `NAME` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `USUARIOS`
--

INSERT INTO `USUARIOS` (`ID`, `USER`, `PASS`, `NAME`) VALUES
(1, 'admin', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Administrador'),
(2, 'lorena', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Lorena'),
(3, 'noel', '1f52f85774b71b2e058195d7da19946327faafd980c0b686dee20c10ca358d8e', 'Noel');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `AUTORES`
--
ALTER TABLE `AUTORES`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `CLIENTES`
--
ALTER TABLE `CLIENTES`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `LIBROS`
--
ALTER TABLE `LIBROS`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_LIBROS_AUTORES` (`AUTOR_ID`);

--
-- Indices de la tabla `PELICULAS`
--
ALTER TABLE `PELICULAS`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_PELICULAS_LIBROS` (`ADAPTACION_ID`);

--
-- Indices de la tabla `RESERVAS`
--
ALTER TABLE `RESERVAS`
  ADD KEY `FK_RESERVAS_CLIENTES` (`ID`),
  ADD KEY `FK_RESERVAS_PELICULAS` (`ID_PELICULA`),
  ADD KEY `FK_RESERVAS_LIBROS` (`ID_LIBRO`);

--
-- Indices de la tabla `USUARIOS`
--
ALTER TABLE `USUARIOS`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `AUTORES`
--
ALTER TABLE `AUTORES`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `CLIENTES`
--
ALTER TABLE `CLIENTES`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `LIBROS`
--
ALTER TABLE `LIBROS`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `PELICULAS`
--
ALTER TABLE `PELICULAS`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `USUARIOS`
--
ALTER TABLE `USUARIOS`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `LIBROS`
--
ALTER TABLE `LIBROS`
  ADD CONSTRAINT `FK_LIBROS_AUTORES` FOREIGN KEY (`AUTOR_ID`) REFERENCES `AUTORES` (`ID`);

--
-- Filtros para la tabla `PELICULAS`
--
ALTER TABLE `PELICULAS`
  ADD CONSTRAINT `FK_PELICULAS_LIBROS` FOREIGN KEY (`ADAPTACION_ID`) REFERENCES `LIBROS` (`ID`);

--
-- Filtros para la tabla `RESERVAS`
--
ALTER TABLE `RESERVAS`
  ADD CONSTRAINT `FK_RESERVAS_CLIENTES` FOREIGN KEY (`ID`) REFERENCES `CLIENTES` (`ID`),
  ADD CONSTRAINT `FK_RESERVAS_LIBROS` FOREIGN KEY (`ID_LIBRO`) REFERENCES `LIBROS` (`ID`),
  ADD CONSTRAINT `FK_RESERVAS_PELICULAS` FOREIGN KEY (`ID_PELICULA`) REFERENCES `PELICULAS` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
