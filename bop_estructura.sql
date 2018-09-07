/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : bop

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-07-04 22:42:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `usuarios`
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `idUsuarios` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  `usr` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `clave` varchar(200) NOT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL,
  `permisos_id` int(11) NOT NULL,
  `fecha_registro` date NOT NULL,
  PRIMARY KEY (`idUsuarios`),
  KEY `fk_usuarios_permissoes1_idx` (`permisos_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;



-- ----------------------------
-- Table structure for `articulos`
-- ----------------------------
DROP TABLE IF EXISTS `articulos`;
CREATE TABLE `articulos` (
  `idArticulo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `categoria` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT '1',
  `precioCompra` decimal(10,0) DEFAULT NULL,
  `precioVenta` decimal(10,0) DEFAULT NULL,
  `stockMinimo` int(11) DEFAULT NULL,
  `entrada` tinyint(1) DEFAULT NULL,
  `salida` tinyint(1) DEFAULT NULL,
  `tipo_modelo` text,
  `descripcion` varchar(300) DEFAULT NULL,
  `serie` varchar(100) DEFAULT NULL,
  `codigo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idArticulo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;



-- ----------------------------
-- Table structure for `articulos_laboratorio`
-- ----------------------------
DROP TABLE IF EXISTS `articulos_laboratorio`;
CREATE TABLE `articulos_laboratorio` (
  `idArticuloLaboratorio` int(11) NOT NULL AUTO_INCREMENT,
  `articulo` int(11) NOT NULL,
  `maquina` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT '0',
  `usuario` int(11) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `asignado` int(11) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT '1',
  `reparados` int(11) DEFAULT NULL,
  PRIMARY KEY (`idArticuloLaboratorio`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;


-- ----------------------------
-- Table structure for `articulos_maquinas`
-- ----------------------------
DROP TABLE IF EXISTS `articulos_maquinas`;
CREATE TABLE `articulos_maquinas` (
  `idArticuloMaquina` int(11) NOT NULL AUTO_INCREMENT,
  `articulo` int(11) NOT NULL,
  `maquina` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT '0',
  `usuario` int(11) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  PRIMARY KEY (`idArticuloMaquina`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;


-- ----------------------------
-- Table structure for `consola`
-- ----------------------------
DROP TABLE IF EXISTS `consola`;
CREATE TABLE `consola` (
  `idConsola` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` int(11) NOT NULL,
  `accion_id` int(11) NOT NULL,
  `accion` text NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `modulo` int(11) NOT NULL,
  PRIMARY KEY (`idConsola`)
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for `documentos`
-- ----------------------------
DROP TABLE IF EXISTS `documentos`;
CREATE TABLE `documentos` (
  `idDocumentos` int(11) NOT NULL AUTO_INCREMENT,
  `documento` varchar(150) DEFAULT NULL,
  `descripcion` text,
  `file` varchar(100) DEFAULT NULL,
  `path` varchar(300) DEFAULT NULL,
  `url` varchar(300) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `categoria` varchar(80) DEFAULT NULL,
  `tipo` varchar(15) DEFAULT NULL,
  `size` varchar(45) DEFAULT NULL,
  `sector` int(11) DEFAULT NULL,
  `referencia` int(11) DEFAULT NULL,
  PRIMARY KEY (`idDocumentos`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for `fallas`
-- ----------------------------
DROP TABLE IF EXISTS `fallas`;
CREATE TABLE `fallas` (
  `idFallas` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT 'logica',
  `estado` int(11) DEFAULT NULL,
  `gravedad` varchar(50) DEFAULT NULL,
  `articulo` text,
  PRIMARY KEY (`idFallas`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for `fallas_maquinas`
-- ----------------------------
DROP TABLE IF EXISTS `fallas_maquinas`;
CREATE TABLE `fallas_maquinas` (
  `idFallas_maquinas` int(11) NOT NULL AUTO_INCREMENT,
  `maquina` int(11) NOT NULL,
  `falla` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `estado` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `ticket` int(11) DEFAULT '0',
  PRIMARY KEY (`idFallas_maquinas`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for `falla_articulo`
-- ----------------------------
DROP TABLE IF EXISTS `falla_articulo`;
CREATE TABLE `falla_articulo` (
  `idFallasArticulos` int(11) NOT NULL AUTO_INCREMENT,
  `falla` int(11) NOT NULL,
  `articulo` int(11) NOT NULL,
  PRIMARY KEY (`idFallasArticulos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of falla_articulo
-- ----------------------------

-- ----------------------------
-- Table structure for `maquinas`
-- ----------------------------
DROP TABLE IF EXISTS `maquinas`;
CREATE TABLE `maquinas` (
  `idMaquina` int(11) NOT NULL AUTO_INCREMENT,
  `nro_egm` int(11) DEFAULT NULL,
  `fabricante` varchar(50) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `p_pago` varchar(10) DEFAULT NULL,
  `denom` varchar(6) DEFAULT NULL,
  `juego` varchar(200) DEFAULT NULL,
  `nro_serie` varchar(50) DEFAULT NULL,
  `programa` varchar(200) DEFAULT NULL,
  `credito` varchar(200) DEFAULT NULL,
  `estado` varchar(3) DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL,
  `ap_minima` varchar(50) DEFAULT NULL,
  `ap_maxima` varchar(50) DEFAULT NULL,
  `cant_lineas` varchar(50) DEFAULT NULL,
  `tipo_juego` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idMaquina`),
  KEY `idMaquina` (`idMaquina`)
) ENGINE=InnoDB AUTO_INCREMENT=1944 DEFAULT CHARSET=latin1;


-- ----------------------------
-- Table structure for `movimiento_articulo`
-- ----------------------------
DROP TABLE IF EXISTS `movimiento_articulo`;
CREATE TABLE `movimiento_articulo` (
  `idMovimiento_articulo` int(11) NOT NULL AUTO_INCREMENT,
  `articulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `movimiento` varchar(100) NOT NULL,
  `usuario` int(11) NOT NULL,
  `locacion` varchar(20) DEFAULT '',
  PRIMARY KEY (`idMovimiento_articulo`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;


-- ----------------------------
-- Table structure for `novedades`
-- ----------------------------
DROP TABLE IF EXISTS `novedades`;
CREATE TABLE `novedades` (
  `idNovedades` int(11) NOT NULL AUTO_INCREMENT,
  `texto` text,
  `referencia` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `f_proceso` datetime NOT NULL,
  `usuario` int(11) NOT NULL,
  `tipo` char(3) NOT NULL,
  PRIMARY KEY (`idNovedades`)
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for `permisos`
-- ----------------------------
DROP TABLE IF EXISTS `permisos`;
CREATE TABLE `permisos` (
  `idPermiso` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  `permisos` text,
  `estado` tinyint(1) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  PRIMARY KEY (`idPermiso`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Table structure for `persona`
-- ----------------------------
DROP TABLE IF EXISTS `persona`;
CREATE TABLE `persona` (
  `idPersona` int(11) NOT NULL AUTO_INCREMENT,
  `legajo` int(11) DEFAULT NULL,
  `cargo` varchar(200) DEFAULT '',
  `sector` int(11) DEFAULT '0',
  `tipo_documento` varchar(5) DEFAULT '',
  `nro_documento` varchar(15) DEFAULT '',
  `img` varchar(250) DEFAULT '',
  `f_alta` date DEFAULT NULL,
  `f_baja` date DEFAULT NULL,
  `nombre` varchar(200) DEFAULT '',
  `apellido` varchar(200) DEFAULT '',
  `familiar` varchar(200) DEFAULT '',
  `telefono` varchar(15) DEFAULT '',
  `celular` varchar(12) DEFAULT '',
  `celular_v` varchar(12) DEFAULT '',
  `celular_f` varchar(12) DEFAULT '',
  `email` varchar(200) DEFAULT '',
  PRIMARY KEY (`idPersona`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of persona
-- ----------------------------

-- ----------------------------
-- Table structure for `sector`
-- ----------------------------
DROP TABLE IF EXISTS `sector`;
CREATE TABLE `sector` (
  `idSector` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  PRIMARY KEY (`idSector`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sector
-- ----------------------------

-- ----------------------------
-- Table structure for `stock_bejerman`
-- ----------------------------
DROP TABLE IF EXISTS `stock_bejerman`;
CREATE TABLE `stock_bejerman` (
  `stkart_codgen` varchar(255) DEFAULT NULL,
  `skart_codEle1` varchar(255) DEFAULT NULL,
  `skart_codEle2` varchar(255) DEFAULT NULL,
  `skart_codEle3` varchar(255) DEFAULT NULL,
  `deposito` varchar(255) DEFAULT NULL,
  `cantidad` varchar(255) DEFAULT NULL,
  `f_carga_bejerman` varchar(255) DEFAULT NULL,
  `autor` varchar(255) DEFAULT NULL,
  `id_stock_bejerman` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_stock_bejerman`)
) ENGINE=InnoDB AUTO_INCREMENT=9389 DEFAULT CHARSET=latin1;



-- ----------------------------
-- Table structure for `ticket`
-- ----------------------------
DROP TABLE IF EXISTS `ticket`;
CREATE TABLE `ticket` (
  `idTicket` int(6) NOT NULL AUTO_INCREMENT,
  `solicita` int(6) NOT NULL DEFAULT '0',
  `idAsignado` int(6) NOT NULL DEFAULT '0',
  `referencia` int(6) NOT NULL DEFAULT '0',
  `descripcion` varchar(250) DEFAULT NULL,
  `prioridad` char(1) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1',
  `f_solicitud` datetime DEFAULT NULL,
  `f_respuesta` datetime DEFAULT NULL,
  `modulo` varchar(40) DEFAULT NULL,
  `submodulo` varchar(40) DEFAULT NULL,
  `categoria` varchar(500) DEFAULT NULL,
  `tipo` varchar(500) DEFAULT NULL,
  `f_cierre` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `f_proceso` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `f_atencion` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sector` int(6) DEFAULT NULL,
  PRIMARY KEY (`idTicket`)
) ENGINE=MyISAM AUTO_INCREMENT=63767 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

