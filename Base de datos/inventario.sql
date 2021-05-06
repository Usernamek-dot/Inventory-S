-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2021 at 04:30 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventario`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `RP_categoriaProductos` ()  begin
SELECT
c.nombre as 'Categoria' , COUNT(pt.codigo) as 'CantidadProductos'
FROM
tblproductoterminado as pt
inner join tblcategoria as c on pt.categoria = c.codigo
GROUP BY c.nombre
ORDER BY c.codigo  DESC;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Rp_NumeroVentas` ()  begin

select COUNT(vp.factura_venta) as 'Numero_facturas',
    pt.nombre as 'producto', SUM(vp.cantidad) as 'Cantidad_producto'
from tblfacturventaproducto as vp
INNER JOIN tblproductoterminado as pt on  pt.codigo = vp.producto
GROUP BY vp.producto 
order by Cantidad_producto DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Rp_precioTotalProducto` (IN `p_mes` DATE)  begin
select sum(fvpt.cantidad * pt.precio) as 'preciototal' ,  pt.nombre as 'producto',
month(fv.fecha) as 'mes' 
from  tblfacturventaproducto as fvpt  inner join tblfacturaventa as fv ON fv.numero = fvpt.factura_venta
inner join tblproductoterminado as pt on fvpt.producto = pt.codigo
where  month(fv.fecha) = p_mes ;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Rp_recetasEnProduccion` ()  BEGIN
select p.fecha as 'FechaOrden' ,
u.documento as 'DocumentoEmpleado',
concat(u.nombres ,'  ', u.apellidos) as 'NombreEmpleado' , 
count(pr.cod_receta)  as 'CantidadUsadas' , pr.cod_receta as 'CodigoReceta' , pt.nombre as 'ProductoReceta'

from  tblreceta as r inner join tblproduccionreceta as pr ON r.codigo = pr.cod_receta
inner join tblproduccion as p on pr.cod_produccion = p.codigo
inner join tblusuario as u on p.usuario = u.documento
inner join tblproductoterminado as pt on  r.producto = pt.codigo



group by pr.cod_receta
order by p.fecha desc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RP_UsuarioInactivo` ()  begin
select u.documento,CONCAT (u.nombres, '  ' , u.apellidos ) as 'usuario',
 u.correo,u.telefono,u.direccion, m.nombre as 'municipio',et.nombre, tu.nombre 
as rol from tblusuario as u INNER JOIN tbltipousuario as tu ON u.tipo_usuario = tu.id 
INNER JOIN  tblestado as et ON u.estado=et.codigo inner join tblmunicipio as m ON u.municipio
 = m.codigo where  et.nombre= 'inactivo' GROUP BY m.nombre  ORDER BY documento ASC;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RP_usuariossinrol` ()  begin
SELECT
u.documento,
CONCAT (u.nombres, ' ' , u.apellidos ) as 'usuario',
u.correo,
u.telefono,
u.direccion,
u.clave,
tp.nombre as 'rol',
m.nombre as 'municipio',
u.estado
FROM
tblusuario as u
   left JOIN
tbltipousuario as tp ON u.tipo_usuario = tp.id
inner join
tblmunicipio as m ON u.municipio = m.codigo
WHERE u.tipo_usuario IS NULL;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ActualizarCategoria` (IN `p_codigo` INT(3), IN `p_nombre` VARCHAR(40))  begin

UPDATE  tblcategoria SET
codigo= p_codigo,
nombre=p_nombre
WHERE codigo=p_codigo;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ActualizarCliente` (IN `p_documento` VARCHAR(12), IN `p_nombres` VARCHAR(50), IN `p_apellidos` VARCHAR(60), IN `p_telefono` VARCHAR(20), IN `p_correo` VARCHAR(70), IN `p_direccion` VARCHAR(45), IN `p_municipio` VARCHAR(6))  begin
UPDATE tbl_cliente SET nombres=p_nombres,
apellidos= p_apellidos ,telefono=p_telefono,correo=p_correo,
direccion=p_direccion , municipio=p_municipio  WHERE documento=p_documento;
 end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ActualizarDepartamento` (IN `p_codigo` INT(3), IN `p_nombre` VARCHAR(60))  begin

UPDATE tbldepartamento SET 
codigo= p_codigo,
nombre=p_nombre
WHERE codigo=p_codigo;

End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ActualizarEstado` (IN `p_codigo` INT(1), IN `p_nombre` VARCHAR(8))  begin

UPDATE tblestado SET codigo= p_codigo ,nombre=p_nombre WHERE codigo=p_codigo;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ActualizarFacturacompra` (IN `p_numero` INT(3), IN `p_proveedor` VARCHAR(15), IN `p_formapago` INT(3), IN `p_fecha` DATE)  begin

UPDATE tblfacturacompra SET 
numero= p_numero,
proveedor=p_proveedor,
formapago=p_formapago,
fecha=p_fecha
WHERE numero=p_numero;

End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ActualizarFacturacompramateriaprima` (IN `p_materia_prima` VARCHAR(15), IN `p_factura_compra` INT(3), IN `p_cantidad` INT(4), IN `p_precio_unitario` INT(6))  begin

UPDATE tblfacturacompramateriaprima SET 
materia_prima= p_materia_prima,
factura_compra=p_fatura_compra,
cantidad=p_cantidad,
precio_unitario=p_precio_unitario

WHERE materia_prima=p_materia_prima;

End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ActualizarFacturaventa` (IN `p_numero` INT(3), IN `p_cliente` VARCHAR(12), IN `p_fecha` DATE, IN `p_forma_pago` INT(3))  begin

UPDATE tblfacturaventa SET 
numero= p_numero,
cliente=p_cliente,
fecha=p_fecha,
forma_pago=p_forma_pago

WHERE numero=p_numero;

End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ActualizarFacturventaproducto` (IN `p_factura_venta` INT(3), IN `p_producto` VARCHAR(15), IN `p_cantidad` INT(4), IN `p_precio_unitario` INT(6))  begin

UPDATE tblfacturaventaproducto SET 
factura_venta= p_factura_venta,
producto=p_producto,
cantidad=p_cantidad,
precio_unitario=p_precio_unitario

WHERE factura_venta=p_factura_venta;

End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ActualizarFormaPago` (IN `p_codigo` INT(3), IN `p_nombre` VARCHAR(35))  begin

UPDATE tblformapago SET codigo= p_codigo, nombre=p_nombre  WHERE codigo=p_codigo;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ActualizarMateriaPrima` (IN `p_codigo` VARCHAR(15), IN `p_nombre` VARCHAR(30), IN `p_unidad_medida` INT(2), IN `p_unidades_disponibles` INT(5), IN `p_fecha_vencimiento` DATE)  begin

UPDATE tblmateriaprima SET codigo=p_codigo,nombre=p_nombre, unidad_medida=p_unidad_medida, unidades_disponibles=p_unidades_disponibles, fecha_vencimiento= p_fecha_vencimiento  WHERE codigo=p_codigo;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ActualizarMateriaPrimaReceta` (IN `p_materia_prima` VARCHAR(15), IN `p_receta` INT(3), IN `p_cantidad` INT(4))  begin

UPDATE tblmateriaprimareceta SET materia_prima=p_materia_prima, receta=p_receta, cantidad=p_cantidad WHERE materia_prima=p_materia_prima and receta=p_receta;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ActualizarMunicipio` (IN `p_codigo` VARCHAR(6), IN `p_nombre` VARCHAR(60), IN `p_departamento` VARCHAR(3))  begin

UPDATE tblmunicipio SET codigo= p_codigo, nombre=p_nombre, tbl_departamento_codigo=p_departamento WHERE codigo=p_codigo;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ActualizarProduccion` (IN `p_codigo` INT(3), IN `p_fecha` DATE, IN `p_usuario` VARCHAR(12))  begin

UPDATE  tblproduccion SET codigo=p_codigo,fecha=p_fecha,usuario=p_usuario WHERE codigo=p_codigo;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ActualizarProduccionReceta` (IN `p_produccion` INT(3), IN `p_receta` INT(3), IN `p_cantidad` INT(4))  begin

UPDATE tblproduccionreceta SET cod_produccion=p_produccion, cod_receta=p_receta, cantidad=p_cantidad WHERE cod_produccion=p_produccion and cod_receta=p_receta;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ActualizarProducto` (IN `p_codigo` VARCHAR(15), IN `p_nombre` VARCHAR(30), IN `p_fecha_creacion` DATE, IN `p_fecha_vencimiento` DATE, IN `p_categoria` INT(3), IN `p_unidades_disponibles` INT(5), IN `p_unidad_medida` INT(2), IN `p_precio` INT)  begin
UPDATE tblproductoterminado SET codigo=p_codigo,nombre=p_nombre,fecha_creacion=p_fecha_creacion,
fecha_vencimiento=p_fecha_vencimiento,categoria=p_categoria,
unidades_disponibles=p_unidades_disponibles, 
unidad_medida = p_unidad_medida, precio = p_precio  WHERE codigo=p_codigo;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ActualizarProveedor` (IN `p_nit` VARCHAR(15), IN `p_nombre` VARCHAR(50), IN `p_apellido` VARCHAR(60), IN `p_direccion` VARCHAR(45), IN `p_telefono` VARCHAR(20), IN `p_correo` VARCHAR(70), IN `p_municipio` VARCHAR(6))  begin
UPDATE tblproveedor SET nit = p_nit, nombre=p_nombre ,apellido=p_apellido,direccion=p_direccion,telefono=p_telefono,correo=p_correo,municipio=p_municipio
WHERE nit=p_nit;
 end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ActualizarReceta` (IN `p_codigo` INT(3), IN `p_fecha` DATE, IN `p_producto` VARCHAR(15), IN `p_usuario` VARCHAR(12), IN `p_descripcion` VARCHAR(5000))  begin
UPDATE tblreceta SET fecha=p_fecha,producto=p_producto ,usuario=p_usuario,
descripcion=p_descripcion WHERE codigo= p_codigo;
 end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ActualizarTipoUsuario` (IN `p_id` INT(2), IN `p_nombre` VARCHAR(20))  begin
UPDATE tbltipousuario SET id= p_id , nombre= p_nombre  WHERE id=p_id;
 end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ActualizarUnidadMedida` (IN `p_codigo` INT(3), IN `p_nombre` VARCHAR(15))  begin
UPDATE tblunidadmedida SET codigo= p_codigo , nombre= p_nombre  WHERE codigo= p_codigo;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ActualizarUsuario` (IN `p_documento` VARCHAR(12), IN `p_nombres` VARCHAR(50), IN `p_apellidos` VARCHAR(60), IN `p_correo` VARCHAR(60), IN `p_telefono` VARCHAR(20), IN `p_direccion` VARCHAR(45), IN `p_clave` VARCHAR(10), IN `p_municipio` VARCHAR(6))  begin

UPDATE tblusuario SET documento= p_documento,nombres=p_nombres,
apellidos=p_apellidos, correo=p_correo, telefono=p_telefono,
direccion=p_direccion , clave=p_clave ,municipio=p_municipio  WHERE documento= p_documento;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarCategoria` (IN `p_codigo` INT(3), IN `p_nombre` VARCHAR(40))  begin


SELECT
codigo,
nombre
FROM
tblcategoria 
where codigo= p_codigo;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarCategorias` ()  begin


SELECT
codigo,
nombre
FROM
tblcategoria ;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarCliente` (IN `p_documento` VARCHAR(12), IN `p_nombres` VARCHAR(50), IN `p_apellidos` VARCHAR(60), IN `p_telefono` VARCHAR(20), IN `p_correo` VARCHAR(70), IN `p_direccion` VARCHAR(45), IN `p_municipio` VARCHAR(6))  begin
SELECT
cl.documento,
cl.nombres as 'nombres',
cl.apellidos as 'apellidos',
cl.correo,
cl.telefono,
cl.direccion,
m.nombre as 'municipio'
FROM
tbl_cliente as cl
inner join
tblmunicipio as m ON cl.municipio = m.codigo
where
documento=p_documento ;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarDepartamento` (IN `p_codigo` INT(3), IN `p_nombre` VARCHAR(60))  begin


SELECT
codigo,
nombre
FROM
tbldepartamento 
where codigo= p_codigo;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarDepartamentos` ()  begin


SELECT
codigo,
nombre
FROM
tbldepartamento;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarEstado` (IN `p_codigo` INT(1), IN `p_nombre` VARCHAR(8))  begin

SELECT * FROM
tblestado  where codigo = p_codigo;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarFacturacompra` (IN `p_numero` INT(3), IN `p_proveedor` VARCHAR(15), IN `p_formapago` INT(3), IN `p_fecha` DATE)  Begin

SELECT fa.numero , 
CONCAT(p.nombre, ' ' , p.apellido ) as 'proveedor' , 
fp.nombre as 'formapago' ,
fa.fecha  
FROM tblfacturacompra       as fa
INNER JOIN tblproveedor    as p   ON fa.proveedor = p.nit
INNER JOIN tblformapago   as fp  ON fa.forma_pago = fp.codigo
where numero= p_numero;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarFacturacompramateriaprima` (IN `p_materia_prima` VARCHAR(15), IN `p_factura_compra` INT(3), IN `p_cantidad` INT(4), IN `p_precio_unitario` INT(6))  begin
SELECT m.nombre, fm.factura_compra , fm.cantidad , fm.precio_unitario
FROM tblfacturacompramateriaprima as fm
INNER JOIN tblmateriaprima as m on fm.materia_prima = m.codigo
Where materia_prima = p_materia_prima;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarFacturacompramateriasprimas` ()  begin
SELECT m.nombre, fm.factura_compra , fm.cantidad , fm.precio_unitario
FROM tblfacturacompramateriaprima as fm
INNER JOIN tblmateriaprima as m on fm.materia_prima = m.codigo;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarFacturascompras` (IN `p_numero` INT(3), IN `p_proveedor` VARCHAR(15), IN `p_formapago` INT(3), IN `p_fecha` DATE)  begin

SELECT fa.numero , 
CONCAT(p.nombre, ' ' , p.apellido ) as 'proveedor' , 
fp.nombre as 'formapago' ,
fa.fecha  
FROM tblfacturacompra       as fa
INNER JOIN tblproveedor    as p   ON fa.proveedor = p.nit
INNER JOIN tblformapago   as fp  ON fa.forma_pago = fp.codigo
ORDER BY fa.numero ASC;    

End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarFacturasventas` ()  Begin

SELECT fv.numero ,
CONCAT(c.nombres, ' ' , c.apellidos ) as 'cliente' ,
fv.fecha,
fp.nombre
FROM tblfacturaventa as fv
INNER JOIN tbl_cliente  as c ON fv.cliente = c.documento
INNER JOIN tblformapago  as fp ON fv.forma_pago = fp.codigo
ORDER BY fv.numero ASC;

End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarFacturasventasproductos` ()  Begin

SELECT fvp.fatura_venta , 
pt.nombre as ‘producto’ ,
fvp.fecha , 
fvp.precio_unitario

FROM tblfacturventaproducto as fvp 
INNER JOIN tblfacturaventa as fv ON fvp.factura_venta = fv.numero  
INNER JOIN tblproductoterminado as pt on fvp.producto = pt.codigo
ORDER BY fv.numero ASC;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarFacturaventa` (IN `p_numero` INT(3), IN `p_cliente` VARCHAR(12), IN `p_fecha` DATE, IN `p_forma_pago` INT(3))  Begin

SELECT fv.numero ,
CONCAT(c.nombres, ' ' , c.apellidos ) as 'cliente' ,
fv.fecha,
fp.nombre
FROM tblfacturaventa as fv
INNER JOIN tbl_cliente  as c ON fv.cliente = c.documento
INNER JOIN tblformapago  as fp ON fv.forma_pago = fp.codigo
where numero= p_numero;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarFacturventaproducto` (IN `p_factura_venta` INT(3), IN `p_producto` VARCHAR(15), IN `p_cantidad` INT(4), IN `p_precio_unitario` INT(6))  Begin

SELECT fvp.fatura_venta , 
pt.nombre as ‘producto’ ,
fvp.fecha , 
fvp.precio_unitario

FROM tblfacturventaproducto as fvp 
INNER JOIN tblfacturaventa as fv ON fvp.factura_venta = fv.numero  
INNER JOIN tblproductoterminado as pt on fvp.producto = pt.codigo

where factura_venta= p_factura_venta;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarFormaPago` (IN `p_codigo` INT(3), IN `p_nombre` VARCHAR(35))  begin

SELECT * FROM tblformapago where codigo = p_codigo;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarMateriaPrima` (IN `p_codigo` VARCHAR(15), IN `p_nombre` VARCHAR(30), IN `p_unidad_medida` INT(2), IN `p_unidades_disponibles` INT(5), IN `p_fecha_vencimiento` DATE)  begin

SELECT mp.codigo as 'codigo', mp.nombre as 'nombre', mp.unidades_disponibles as 'cantidad', mp.fecha_vencimiento, um.nombre as 'unidad_medida'  FROM tblmateriaprima as mp INNER JOIN tblunidadmedida as um ON mp.unidad_medida=um.codigo 

WHERE codigo = p_codigo;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarMateriaPrimaReceta` (IN `p_materia_prima` VARCHAR(15), IN `p_receta` INT(3), IN `p_cantidad` INT(4))  begin

SELECT mp.nombre  as 'materia prima',mpr.receta as 'receta', mpr.cantidad 
FROM tblmateriaprimareceta as mpr INNER JOIN tblmateriaprima as mp ON mp.codigo=mpr.materia_prima 
WHERE materia_prima=p_materia_prima AND receta=p_receta;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarMunicipio` (IN `p_codigo` VARCHAR(6), IN `p_nombre` VARCHAR(60), IN `p_departamento` VARCHAR(3))  begin

SELECT mp.codigo, mp.nombre as ‘municipio’, dp.nombre as ‘departamento’ FROM tblmunicipio as mp INNER JOIN tbldepartamento as dp On mp.tbl_departamento_codigo=dp.codigo where mp.codigo = p_codigo;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarProduccion` (IN `p_codigo` INT(3), IN `p_fecha` DATE, IN `p_usuario` VARCHAR(12))  begin

SELECT pdc.codigo, pdc.fecha , CONCAT(u.nombres, ' ' , u.apellidos ) as 'empleado'
FROM tblproduccion as pdc INNER JOIN tblusuario as u ON u.documento = pdc.usuario

WHERE codigo = p_codigo;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarProduccionReceta` (IN `p_produccion` INT(3), IN `p_receta` INT(3), IN `p_cantidad` INT(4))  begin

SELECT * FROM tblproduccionreceta 

WHERE cod_produccion  = p_produccion and cod_receta=p_receta;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarProducto` (IN `p_codigo` VARCHAR(15), IN `p_nombre` VARCHAR(30), IN `p_fecha_creacion` DATE, IN `p_fecha_vencimiento` DATE, IN `p_categoria` INT(3), IN `p_unidades_disponibles` INT(5), IN `p_unidad_medida` INT(2))  begin
SELECT c.nombre as 'categoria',um.nombre as 'unidad_medida',pt.codigo,pt.nombre,
pt.unidades_disponibles,pt.fecha_vencimiento,pt.fecha_creacion FROM tblproductoterminado
 as pt INNER JOIN tblunidadmedida as um ON 
pt.unidad_medida = um.codigo INNER JOIN tblcategoria as c ON pt.categoria = c.codigo
where pt.codigo = p_codigo;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarProveedor` (IN `p_nit` VARCHAR(15), IN `p_nombre` VARCHAR(50), IN `p_apellido` VARCHAR(60), IN `p_direccion` VARCHAR(45), IN `p_telefono` VARCHAR(20), IN `p_correo` VARCHAR(70), IN `p_municipio` VARCHAR(6))  begin
SELECT
p.nit,
p.nombre as 'nombre',
p.apellido as 'apellido',
p.direccion,
p.telefono,
p.correo,
m.nombre as 'municipio'
FROM
tblproveedor as p INNER JOIN
tblmunicipio as m ON p.municipio = m.codigo 
where nit = p_nit;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarReceta` (IN `p_codigo` INT(3), IN `p_fecha` DATE, IN `p_producto` VARCHAR(15), IN `p_usuario` VARCHAR(12), IN `p_descripcion` VARCHAR(5000))  begin

SELECT 
    r.codigo,
    r.fecha,
    CONCAT(u.nombres, ' ', u.apellidos) as 'Empleado',
    p.nombre as 'producto',
    r.descripcion
FROM
    tblreceta as r
        INNER JOIN
    tblusuario as u ON r.usuario = u.documento
        INNER JOIN
    tblproductoterminado as p ON r.producto = p.codigo
where
    r.codigo = p_codigo;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarTipoUsuario` (IN `p_id` INT(2), IN `p_nombre` VARCHAR(20))  begin
SELECT * FROM tbltipousuario where id=p_id;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarUnidadMedida` (IN `p_codigo` INT(3), IN `p_nombre` VARCHAR(15))  begin
SELECT * FROM tblunidadmedida
where
codigo= p_codigo;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarUsuario` (IN `p_documento` VARCHAR(12), IN `p_nombres` VARCHAR(50), IN `p_apellidos` VARCHAR(60), IN `p_correo` VARCHAR(60), IN `p_telefono` VARCHAR(20), IN `p_direccion` VARCHAR(45), IN `p_clave` VARCHAR(10), IN `p_municipio` VARCHAR(6))  begin

SELECT
u.documento,
u.nombres as 'nombre',
u.apellidos as 'apellido',
u.correo,
u.telefono,
u.direccion,
u.clave,
tp.nombre as 'rol',
m.nombre as 'municipio',
u.estado as 'estado'
FROM
tblusuario as u
    left JOIN
tbltipousuario as tp ON u.tipo_usuario = tp.id
inner join
tblmunicipio as m ON u.municipio = m.codigo
where documento = p_documento;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarVariasFormaPago` ()  begin

SELECT * FROM tblformapago where codigo = p_codigo;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarVariasMateriasPrimas` ()  begin

SELECT mp.codigo as 'codigo', mp.nombre as 'nombre', mp.unidades_disponibles as 'cantidad', mp.fecha_vencimiento, um.nombre as 'unidad_medida'  FROM tblmateriaprima as mp INNER JOIN tblunidadmedida as um ON mp.unidad_medida=um.codigo;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarVariasMateriasPrimasRecetas` ()  begin

SELECT mp.nombre  as 'materia prima',rc.nombre as 'receta', mpr.cantidad 
FROM tblmateriaprimareceta as mpr INNER JOIN tblmateriaprima as mp ON mp.codigo=mpr.materia_prima;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarVariasOrdenesProduccion` ()  begin

SELECT pdc.codigo, pdc.fecha , CONCAT(u.nombres, ' ' , u.apellidos ) as 'empleado'
FROM tblproduccion as pdc INNER JOIN tblusuario as u ON u.documento = pdc.usuario;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarVariasRecetas` ()  begin
SELECT 
    r.codigo,
    r.fecha,
    CONCAT(u.nombres, ' ', u.apellidos) as 'Empleado',
    p.nombre as 'producto',
    r.descripcion
FROM
    tblreceta as r
        INNER JOIN
    tblusuario as u ON r.usuario = u.documento
        INNER JOIN
    tblproductoterminado as p ON r.producto = p.codigo;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarVariasUnidadesMedida` ()  begin
SELECT * FROM tblunidadmedida;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarVariosClientes` ()  begin
SELECT
cl.documento,
cl.nombres as 'nombres',
cl.apellidos as 'apellidos',
cl.correo,
cl.telefono,
cl.direccion,
m.nombre as 'municipio'
FROM
tbl_cliente as cl
inner join
tblmunicipio as m ON cl.municipio = m.codigo;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarVariosEstados` ()  begin

SELECT * FROM
tblestado  ;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarVariosMunicipios` ()  begin

SELECT mp.codigo, mp.nombre as ‘municipio’, dp.nombre as ‘departamento’ FROM tblmunicipio as mp INNER JOIN tbldepartamento as dp On mp.tbl_departamento_codigo=dp.codigo;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarVariosProduccionRecetas` ()  begin

SELECT * FROM tblproduccionreceta;


end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarVariosProductos` ()  begin
SELECT pt.codigo,pt.nombre,c.nombre as 'categoria',um.nombre as 'unidad_medida',
pt.unidades_disponibles,pt.fecha_vencimiento,pt.fecha_creacion FROM tblproductoterminado
 as pt INNER JOIN tblunidadmedida as um ON 
pt.unidad_medida = um.codigo INNER JOIN tblcategoria as c ON pt.categoria = c.codigo;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarVariosProveedores` ()  begin
SELECT
p.nit,
p.nombre as 'nombre',
p.apellido as 'apellido',
p.direccion,
p.telefono,
p.correo,
m.nombre as 'municipio'
FROM
tblproveedor as p INNER JOIN
tblmunicipio as m ON p.municipio = m.codigo ;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarVariosTiposUsuario` ()  begin
SELECT * FROM tbltipousuario;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ConsultarVariosUsuarios` ()  begin

SELECT
u.documento,
u.nombres as 'nombre',
u.apellidos as 'apellido',
u.correo,
u.telefono,
u.direccion,
u.clave,
tp.nombre as 'rol',
m.nombre as 'municipio',
e.nombre as 'estado'
FROM
tblusuario as u
    left JOIN
tbltipousuario as tp ON u.tipo_usuario = tp.id
inner join
tblmunicipio as m ON u.municipio = m.codigo
inner join
tblestado as e ON u.estado = e.codigo;


end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EliminarCategoria` (IN `p_codigo` INT(3))  begin

DELETE  FROM tblcategoria   
WHERE codigo=p_codigo;

End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EliminarCliente` (IN `p_documento` VARCHAR(12))  begin
DELETE FROM tbl_cliente WHERE  documento=p_documento ;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EliminarDepartamento` (IN `p_codigo` INT(3))  begin

DELETE FROM tbldepartamento
WHERE codigo=p_codigo;

End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EliminarEstado` (IN `p_codigo` INT(1))  begin

DELETE  FROM tblestado   WHERE codigo = p_codigo ;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EliminarFacturacompra` (IN `p_numero` INT(3))  begin

DELETE FROM  tblfacturacompra
WHERE numero=p_numero;

End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EliminarFacturacompramateriaprima` (IN `p_materia_prima` VARCHAR(15), IN `p_factura_compra` INT(3))  begin

DELETE FROM  tblfacturacompramateriaprima
WHERE materia_prima=p_materia_prima;

End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EliminarFacturaventa` (IN `p_numero` INT(3))  begin

DELETE FROM tblfacturaventa
WHERE numero=p_numero;

End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EliminarFacturventaproducto` (IN `p_factura_venta` INT(3))  begin

DELETE FROM tblfacturaventaproducto
WHERE factura_venta=p_factura_venta;

End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EliminarFormaPago` (IN `p_codigo` INT(3))  begin

DELETE  FROM  tblformapaqgo  WHERE codigo=p_codigo;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EliminarMateriaPrima` (IN `p_codigo` VARCHAR(15))  begin

DELETE FROM tblmateriaprima   WHERE codigo=p_codigo;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EliminarMateriaPrimaReceta` (IN `p_materia_prima` VARCHAR(15), IN `p_receta` INT(3))  begin

DELETE FROM tblmateriaprimareceta   WHERE materia_prima=p_materia_prima and receta=p_receta;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EliminarMunicipio` (IN `p_codigo` VARCHAR(6))  begin

DELETE FROM tblmunicipio  WHERE codigo=p_codigo;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EliminarProduccion` (IN `p_codigo` INT(3))  begin

DELETE FROM tblproduccion   WHERE codigo=p_codigo;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EliminarProduccionReceta` (IN `p_produccion` INT(3), IN `p_receta` INT(3))  begin

DELETE FROM tblproduccionreceta   WHERE cod_produccion = p_produccion and cod_receta=p_receta;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EliminarProducto` (IN `p_codigo` VARCHAR(15))  begin
DELETE FROM tblproductoterminado WHERE codigo = p_codigo;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EliminarProveedor` (IN `p_nit` VARCHAR(15))  begin
DELETE FROM tblproveedor WHERE nit = p_nit;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EliminarReceta` (IN `p_codigo` VARCHAR(15))  begin
DELETE FROM tblreceta WHERE codigo = p_codigo;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EliminarTipoUsuario` (IN `p_id` INT(2))  begin
DELETE FROM tbltipousuario WHERE id=p_id;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EliminarUnidadMedida` (IN `p_codigo` INT(3))  begin
DELETE FROM tblunidadmedida WHERE codigo= p_codigo;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_EliminarUsuario` (IN `p_documento` VARCHAR(12))  begin

DELETE  FROM tblusuario   WHERE documento = p_documento ;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarCategoria` (IN `p_codigo` INT(3), IN `p_nombre` VARCHAR(40))  begin

INSERT INTO tblcategoria(codigo,nombre)
VALUES (p_codigo , p_nombre);
End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarCliente` (IN `p_documento` VARCHAR(12), IN `p_nombres` VARCHAR(50), IN `p_apellidos` VARCHAR(60), IN `p_telefono` VARCHAR(20), IN `p_correo` VARCHAR(70), IN `p_direccion` VARCHAR(45), IN `p_municipio` VARCHAR(6))  begin
INSERT INTO tbl_cliente(documento,nombres,apellidos,telefono,correo,direccion,municipio)  
VALUES (p_documento,p_nombres,p_apellidos,p_telefono,p_correo,p_direccion,p_municipio) ; 
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarDepartamento` (IN `p_codigo` INT(3), IN `p_nombre` VARCHAR(60))  begin

INSERT INTO tbldepartamento(codigo,nombre)
VALUES (p_codigo , p_nombre);

End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarEstado` (IN `p_codigo` INT(1), IN `p_nombre` VARCHAR(8))  begin

INSERT INTO tblestado(codigo,nombre)
VALUES (p_codigo , p_nombre);

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarFacturacompra` (IN `p_numero` INT(3), IN `p_proveedor` VARCHAR(15), IN `p_formapago` INT(3), IN `p_fecha` DATE)  begin

INSERT INTO tblfacturacompra (numero,proveedor,formapago,fecha)
VALUES (p_numero , p_proveedor, p_formapago, p_fecha);

End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarFacturacompramateriaprima` (IN `p_materia_prima` VARCHAR(15), IN `p_factura_compra` INT(3), IN `p_cantidad` INT(4), IN `p_precio_unitario` INT(6))  Begin

INSERT INTO tblfacturacompramateriaprima (materia_prima, factura_compra, cantidad, precio_unitario) 
VALUES (p_materia_prima , p_fatura_compra, p_cantidad, p_precio_unitario);

End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarFacturaventa` (IN `p_numero` INT(3), IN `p_cliente` VARCHAR(12), IN `p_fecha` DATE, IN `p_forma_pago` INT(3))  Begin

INSERT INTO tblfacturaventa (numero, cliente, fecha, forma_pago) 
VALUES (p_numero , p_cliente, p_fecha, p_forma_pago);

End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarFacturventaproducto` (IN `p_factura_venta` INT(3), IN `p_producto` VARCHAR(15), IN `p_cantidad` INT(4), IN `p_precio_unitario` INT(6))  Begin

INSERT INTO tblfacturventaproducto (factura_venta, producto, cantidad, precio_unitario) 
VALUES (p_factura_venta , p_producto, p_cantidad, p_precio_unitario);

End$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarFormaPago` (IN `p_codigo` INT(3), IN `p_nombre` VARCHAR(35))  begin

INSERT INTO tblformapago(codigo,nombre)
VALUES (NULL , p_nombre);

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarMateriaPrima` (IN `p_codigo` VARCHAR(15), IN `p_nombre` VARCHAR(30), IN `p_unidad_medida` INT(2), IN `p_unidades_disponibles` INT(5), IN `p_fecha_vencimiento` DATE)  begin

INSERT INTO tblmateriaprima(codigo,nombre,unidad_medida,unidades_disponibles,fecha_vencimiento)
VALUES (p_codigo , p_nombre , p_unidad_meida, p_unidades_disponibles, p_fecha_vencimiento );

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarMateriaPrimaReceta` (IN `p_materia_prima` VARCHAR(15), IN `p_receta` INT(3), IN `p_cantidad` INT(4))  begin

INSERT INTO tblmateriaprimareceta(materia_prima,receta,cantidad)
VALUES (p_materia_prima , p_receta , p_cantidad );

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarMunicipio` (IN `p_codigo` VARCHAR(6), IN `p_nombre` VARCHAR(60), IN `p_departamento` VARCHAR(3))  begin

INSERT INTO tblmunicipio(codigo,nombre,tbl_departamentos_codigo)
VALUES (p_codigo , p_nombre,p_departamento);

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarProduccion` (IN `p_codigo` INT(3), IN `p_fecha` DATE, IN `p_usuario` VARCHAR(12))  begin

INSERT INTO tblproduccion(codigo,fecha,usuario)
VALUES (p_codigo , p_fecha , p_usuario);

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarProduccionReceta` (IN `p_produccion` INT(3), IN `p_receta` INT(3), IN `p_cantidad` INT(4))  begin

INSERT INTO tblproduccionreceta(cod_produccion,cod_receta,cantidad)
VALUES (p_produccion , p_receta , p_cantidad );

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarProductoT` (IN `p_codigo` VARCHAR(15), IN `p_nombre` VARCHAR(30), IN `p_fecha_creacion` DATE, IN `p_fecha_vencimiento` DATE, IN `p_categoria` INT(3), IN `p_unidades_disponibles` INT(5), IN `p_unidad_medida` INT(2))  begin
INSERT INTO tblproductoterminado(codigo,nombre,fecha_creacion,fecha_vencimiento,
categoria,unidades_disponibles,unidad_medida) VALUES (p_codigo,p_nombre,
p_fecha_creacion,p_fecha_vencimiento,p_categoria,p_unidades_disponibles,p_unidad_medida);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarProveedor` (IN `p_nit` VARCHAR(15), IN `p_nombre` VARCHAR(50), IN `p_apellido` VARCHAR(60), IN `p_direccion` VARCHAR(45), IN `p_telefono` VARCHAR(20), IN `p_correo` VARCHAR(70), IN `p_municipio` VARCHAR(6))  begin
INSERT INTO tblproveedor(nit,nombre,apellido,direccion,telefono,correo,municipio) 
VALUES ( p_nit,p_nombre,p_apellido,p_direccion,p_telefono,p_correo,p_municipio);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarReceta` (IN `p_fecha` DATE, IN `p_producto` VARCHAR(15), IN `p_usuario` VARCHAR(12), IN `p_descripcion` VARCHAR(5000))  begin
INSERT INTO tblreceta(fecha,producto,usuario,descripcion) 
VALUES (p_fecha,p_producto,p_usuario,p_descripcion);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarTipoUsuario` (IN `p_id` INT(2), IN `p_nombre` VARCHAR(20))  begin
INSERT INTO tbltipousuario(id,nombre) 
VALUES (p_id,p_nombre);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarUnidadMedida` (IN `p_codigo` INT(3), IN `p_nombre` VARCHAR(15))  begin
INSERT INTO tblunidadmedida(codigo,nombre) 
VALUES (p_codigo,p_nombre);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarUsuario` (IN `p_documento` VARCHAR(12), IN `p_nombres` VARCHAR(50), IN `p_apellidos` VARCHAR(60), IN `p_correo` VARCHAR(60), IN `p_telefono` VARCHAR(20), IN `p_direccion` VARCHAR(45), IN `p_clave` VARCHAR(10), IN `p_municipio` VARCHAR(6))  begin

INSERT INTO tblusuario(documento,nombres,apellidos,correo,telefono,direccion,clave,municipio)
VALUES (p_documento , p_nombres , p_apellidos,p_correo,p_telefono,p_direccion,p_clave, p_municipio);

end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblcategoria`
--

CREATE TABLE `tblcategoria` (
  `codigo` int(3) NOT NULL,
  `nombre` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcategoria`
--

INSERT INTO `tblcategoria` (`codigo`, `nombre`) VALUES
(1, 'Grupo 1'),
(2, 'Grupo 2'),
(3, 'Grupo 3'),
(4, ' Grupo 5'),
(5, 'categoria 6'),
(6, 'categoria 7'),
(7, 'categoria 8'),
(8, 'categoria 9'),
(9, 'categoria 10'),
(10, 'categoria 11'),
(11, 'categoria 12'),
(12, 'categoria 13'),
(13, 'categoria 14'),
(14, 'categoria 15');

-- --------------------------------------------------------

--
-- Table structure for table `tbldepartamento`
--

CREATE TABLE `tbldepartamento` (
  `codigo` varchar(3) NOT NULL,
  `nombre` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbldepartamento`
--

INSERT INTO `tbldepartamento` (`codigo`, `nombre`) VALUES
('1', 'AMAZONAS'),
('10', 'CAQUETÁ'),
('11', 'CASANARE'),
('12', 'CAUCA'),
('13', 'CESAR'),
('14', 'CHOCÓ'),
('15', 'CÓRDOBA'),
('16', 'CUNDINAMARCA'),
('17', 'GUAINÍA'),
('18', 'GUAVIARE'),
('19', 'HUILA'),
('2', 'ANTIOQUIA'),
('20', 'LA GUAJIRA'),
('21', 'MAGDALENA'),
('22', 'META'),
('23', 'NARIÑO'),
('24', 'NORTE DE SANTANDER'),
('25', 'PUTUMAYO'),
('26', 'QUINDIO'),
('27', 'RISARALDA'),
('28', 'SANTANDER'),
('29', 'SUCRE'),
('3', 'ARAUCA'),
('30', 'TOLIMA'),
('31', 'VALLE DEL CAUCA'),
('32', 'VAUPÉS'),
('33', 'VICHADA'),
('4', 'ARCHIPIÉLAGO DE SAN ANDRÉS, PROVIDENCIA Y SANTA CATALINA'),
('5', 'ATLÁNTICO'),
('6', 'BOGOTÁ, D.C.'),
('7', 'BOLÍVAR'),
('8', 'BOYACÁ'),
('9', 'CALDAS');

-- --------------------------------------------------------

--
-- Table structure for table `tblfacturacompra`
--

CREATE TABLE `tblfacturacompra` (
  `numero` int(3) NOT NULL,
  `proveedor` varchar(15) NOT NULL,
  `forma_pago` int(3) NOT NULL,
  `fecha` date NOT NULL,
  `proveedorFactura` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblfacturacompra`
--

INSERT INTO `tblfacturacompra` (`numero`, `proveedor`, `forma_pago`, `fecha`, `proveedorFactura`) VALUES
(1, '09480485', 1, '2021-04-05', '7666'),
(2, '09480485', 1, '2021-04-05', '7666'),
(3, '4850498059', 2, '2021-04-05', '0989089'),
(4, '4850498059', 2, '2021-04-05', '0989089'),
(5, '09438504805', 1, '2021-04-05', '385045845ss'),
(6, '09438504805', 1, '2021-04-05', '385045845ss'),
(7, '4850498059', 1, '2021-04-08', '5987869'),
(8, '4850498059', 1, '2021-04-08', '5987869'),
(9, '4850498059', 1, '2021-04-09', '3095985dd'),
(10, '4850498059', 1, '2021-04-09', '3095985dd'),
(11, '390803805', 2, '2021-04-16', '9045860956'),
(12, '390803805', 2, '2021-04-16', '9045860956');

-- --------------------------------------------------------

--
-- Table structure for table `tblfacturacompramateriaprima`
--

CREATE TABLE `tblfacturacompramateriaprima` (
  `materia_prima` varchar(15) NOT NULL,
  `factura_compra` int(3) NOT NULL,
  `cantidad` int(4) NOT NULL,
  `precio_unitario` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblfacturacompramateriaprima`
--

INSERT INTO `tblfacturacompramateriaprima` (`materia_prima`, `factura_compra`, `cantidad`, `precio_unitario`) VALUES
('0380746984', 9, 800, 10000),
('0485046', 5, 100, 9000),
('04958065', 11, 10, 10000),
('094586098', 1, 100, 8000),
('0954804860', 1, 90, 1700),
('30945958', 9, 400, 10000),
('3865', 7, 10000, 1199),
('3927594d', 9, 100, 10000),
('40985904', 3, 98, 8700),
('46477', 7, 10000, 1000),
('4908', 7, 100, 1000),
('4908603', 9, 600, 100000),
('598769573', 1, 100, 1500),
('834845', 9, 400, 100000),
('83994', 9, 200, 10000),
('943875958', 9, 100, 100000),
('95805987', 9, 600, 10000),
('983758946', 9, 8000, 10000),
('9ee4869', 9, 800, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `tblfacturaventa`
--

CREATE TABLE `tblfacturaventa` (
  `numero` int(3) NOT NULL,
  `cliente` varchar(12) DEFAULT NULL,
  `fecha` date NOT NULL,
  `forma_pago` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblfacturaventa`
--

INSERT INTO `tblfacturaventa` (`numero`, `cliente`, `fecha`, `forma_pago`) VALUES
(47, '084504850', '2021-04-11', 1),
(48, '25096869', '2021-04-11', 1),
(49, '25096869', '2021-04-11', 1),
(50, '25096869', '2021-04-13', 2),
(51, '9308986', '2021-04-14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblfacturventaproducto`
--

CREATE TABLE `tblfacturventaproducto` (
  `factura_venta` int(3) NOT NULL,
  `producto` varchar(15) NOT NULL,
  `cantidad` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblfacturventaproducto`
--

INSERT INTO `tblfacturventaproducto` (`factura_venta`, `producto`, `cantidad`) VALUES
(47, '1', 10),
(48, '39895', 100),
(49, '002', 10),
(50, '002', 10),
(51, '4395906', 10);

-- --------------------------------------------------------

--
-- Table structure for table `tblformapago`
--

CREATE TABLE `tblformapago` (
  `codigo` int(3) NOT NULL,
  `nombre` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblformapago`
--

INSERT INTO `tblformapago` (`codigo`, `nombre`) VALUES
(1, 'Credito'),
(2, 'Efectivo'),
(3, 'Tarjeta de debito'),
(4, 'Tarjeta de credito'),
(5, 'Consignacion');

-- --------------------------------------------------------

--
-- Table structure for table `tblmateriaprima`
--

CREATE TABLE `tblmateriaprima` (
  `codigo` varchar(15) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `unidad_medida` int(2) NOT NULL,
  `unidades_disponibles` int(5) NOT NULL,
  `fecha_vencimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmateriaprima`
--

INSERT INTO `tblmateriaprima` (`codigo`, `nombre`, `unidad_medida`, `unidades_disponibles`, `fecha_vencimiento`) VALUES
('0380746984', 'materia f', 3, 800, '2021-04-09'),
('0485046', 'materia 10', 2, 100, '2022-02-03'),
('04958065', 'materia dd', 4, 10, '2021-11-24'),
('094586098', 'materia 2', 5, 100, '2021-09-28'),
('0954804860', 'materia 1', 2, 90, '2021-08-30'),
('095860956', 'Salchicha Ranchera', 6, 0, '2020-07-31'),
('1', 'Gaseosaaaa', 4, 0, '2020-09-30'),
('1234', 'Banano con cremas', 4, 1228, '2020-11-04'),
('1324', 'Trigo', 3, 999, '2021-03-19'),
('2', 'Bulto 1', 6, 0, '2020-11-18'),
('2374935', 'materia 5', 4, 90, '2021-03-30'),
('2865', 'Materia 4', 5, 788, '2021-08-25'),
('30945958', 'materia g', 2, 400, '2023-10-31'),
('3865', 'materia b', 1, 10000, '2021-04-08'),
('3927594d', 'materia e', 2, 100, '2022-10-12'),
('4', 'poopos', 5, 0, '2020-10-29'),
('408046', 'Materia 3', 6, 556, '2021-12-26'),
('40985904', 'materia 6', 3, 98, '2021-08-30'),
('4398579856', 'Leche', 5, 0, '2020-10-08'),
('46477', 'materia c', 3, 10000, '2021-04-08'),
('4908', 'materia a', 5, 100, '2021-04-08'),
('4908603', ' materia j', 1, 600, '2021-04-12'),
('498960', 'materiad', 2, 477, '2021-03-17'),
('5860', 'Materia 1', 5, 79994, '2020-12-11'),
('598769573', 'materia 3', 5, 100, '2021-10-22'),
('666', 'materia 8.8.8', 4, 999, '2020-11-03'),
('834845', 'materia x', 4, 400, '2023-09-09'),
('83994', 'materia rr', 4, 200, '2024-10-07'),
('905806', 'NUEVA MATERIA', 5, 7888, '2020-11-02'),
('93759', 'Materia 2', 5, 5000, '2021-11-30'),
('943875958', 'materia d', 5, 100, '2021-11-24'),
('94805485', 'materia 7', 2, 6, '2021-03-17'),
('956806', 'Salll', 4, 0, '2020-12-25'),
('95805987', 'mateeria y', 4, 600, '2025-01-01'),
('958696', 'Cacao', 5, 0, '2020-11-05'),
('983758946', 'matria h', 3, 8000, '2021-12-17'),
('9ee4869', 'materia z', 4, 800, '2021-12-09'),
('e4o98045', 'materia4', 1, 10000, '2021-04-02');

-- --------------------------------------------------------

--
-- Table structure for table `tblmateriaprimareceta`
--

CREATE TABLE `tblmateriaprimareceta` (
  `materia_prima` varchar(15) NOT NULL,
  `receta` int(3) NOT NULL,
  `cantidad` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmateriaprimareceta`
--

INSERT INTO `tblmateriaprimareceta` (`materia_prima`, `receta`, `cantidad`) VALUES
('094586098', 9, 4),
('1', 5, 23),
('2865', 6, 33),
('30945958', 14, 4),
('3927594d', 9, 70),
('408046', 7, 7),
('408046', 8, 4),
('40985904', 8, 33),
('40985904', 9, 10),
('598769573', 6, 4),
('598769573', 14, 3),
('834845', 9, 8),
('83994', 7, 4),
('83994', 8, 2),
('93759', 6, 7);

-- --------------------------------------------------------

--
-- Table structure for table `tblmunicipio`
--

CREATE TABLE `tblmunicipio` (
  `codigo` varchar(6) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `tbl_departamentos_codigo` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmunicipio`
--

INSERT INTO `tblmunicipio` (`codigo`, `nombre`, `tbl_departamentos_codigo`) VALUES
('1', 'EL ENCANTO', '1'),
('10', 'PUERTO SANTANDER', '1'),
('100', 'SAN ANDRÉS DE CUERQUÍA', '2'),
('1000', 'CHALÁN', '29'),
('1001', 'COLOSO', '29'),
('1002', 'COROZAL', '29'),
('1003', 'COVEÑAS', '29'),
('1004', 'EL ROBLE', '29'),
('1005', 'GALERAS', '29'),
('1006', 'GUARANDA', '29'),
('1007', 'LA UNIÓN', '29'),
('1008', 'LOS PALMITOS', '29'),
('1009', 'MAJAGUAL', '29'),
('101', 'SAN CARLOS', '2'),
('1010', 'MORROA', '29'),
('1011', 'OVEJAS', '29'),
('1012', 'PALMITO', '29'),
('1013', 'SAMPUÉS', '29'),
('1014', 'SAN BENITO ABAD', '29'),
('1015', 'SAN JUAN DE BETULIA', '29'),
('1016', 'SAN LUIS DE SINCÉ', '29'),
('1017', 'SAN MARCOS', '29'),
('1018', 'SAN ONOFRE', '29'),
('1019', 'SAN PEDRO', '29'),
('102', 'SAN FRANCISCO', '2'),
('1020', 'SANTIAGO DE TOLÚ', '29'),
('1021', 'SINCELEJO', '29'),
('1022', 'SUCRE', '29'),
('1023', 'TOLÚ VIEJO', '29'),
('1024', 'ALPUJARRA', '30'),
('1025', 'ALVARADO', '30'),
('1026', 'AMBALEMA', '30'),
('1027', 'ANZOÁTEGUI', '30'),
('1028', 'ARMERO GUAYABAL', '30'),
('1029', 'ATACO', '30'),
('103', 'SAN JERÓNIMO', '2'),
('1030', 'CAJAMARCA', '30'),
('1031', 'CARMEN DE APICALÁ', '30'),
('1032', 'CASABIANCA', '30'),
('1033', 'CHAPARRAL', '30'),
('1034', 'COELLO', '30'),
('1035', 'COYAIMA', '30'),
('1036', 'CUNDAY', '30'),
('1037', 'DOLORES', '30'),
('1038', 'ESPINAL', '30'),
('1039', 'FALAN', '30'),
('104', 'SAN JOSÉ DE LA MONTAÑA', '2'),
('1040', 'FLANDES', '30'),
('1041', 'FRESNO', '30'),
('1042', 'GUAMO', '30'),
('1043', 'HERVEO', '30'),
('1044', 'HONDA', '30'),
('1045', 'IBAGUÉ', '30'),
('1046', 'ICONONZO', '30'),
('1047', 'LÉRIDA', '30'),
('1048', 'LÍBANO', '30'),
('1049', 'MELGAR', '30'),
('105', 'SAN JUAN DE URABÁ', '2'),
('1050', 'MURILLO', '30'),
('1051', 'NATAGAIMA', '30'),
('1052', 'ORTEGA', '30'),
('1053', 'PALOCABILDO', '30'),
('1054', 'PIEDRAS', '30'),
('1055', 'PLANADAS', '30'),
('1056', 'PRADO', '30'),
('1057', 'PURIFICACIÓN', '30'),
('1058', 'RIOBLANCO', '30'),
('1059', 'RONCESVALLES', '30'),
('106', 'SAN LUIS', '2'),
('1060', 'ROVIRA', '30'),
('1061', 'SALDAÑA', '30'),
('1062', 'SAN ANTONIO', '30'),
('1063', 'SAN LUIS', '30'),
('1064', 'SAN SEBASTIÁN DE MARIQUITA', '30'),
('1065', 'SANTA ISABEL', '30'),
('1066', 'SUÁREZ', '30'),
('1067', 'VALLE DE SAN JUAN', '30'),
('1068', 'VENADILLO', '30'),
('1069', 'VILLAHERMOSA', '30'),
('107', 'SAN PEDRO DE LOS MILAGROS', '2'),
('1070', 'VILLARRICA', '30'),
('1071', 'ALCALÁ', '31'),
('1072', 'ANDALUCÍA', '31'),
('1073', 'ANSERMANUEVO', '31'),
('1074', 'ARGELIA', '31'),
('1075', 'BOLÍVAR', '31'),
('1076', 'BUENAVENTURA', '31'),
('1077', 'BUGALAGRANDE', '31'),
('1078', 'CAICEDONIA', '31'),
('1079', 'CALI', '31'),
('108', 'SAN PEDRO DE URABÁ', '2'),
('1080', 'CALIMA', '31'),
('1081', 'CANDELARIA', '31'),
('1082', 'CARTAGO', '31'),
('1083', 'DAGUA', '31'),
('1084', 'EL ÁGUILA', '31'),
('1085', 'EL CAIRO', '31'),
('1086', 'EL CERRITO', '31'),
('1087', 'EL DOVIO', '31'),
('1088', 'FLORIDA', '31'),
('1089', 'GINEBRA', '31'),
('109', 'SAN RAFAEL', '2'),
('1090', 'GUACARÍ', '31'),
('1091', 'GUADALAJARA DE BUGA', '31'),
('1092', 'JAMUNDÍ', '31'),
('1093', 'LA CUMBRE', '31'),
('1094', 'LA UNIÓN', '31'),
('1095', 'LA VICTORIA', '31'),
('1096', 'OBANDO', '31'),
('1097', 'PALMIRA', '31'),
('1098', 'PRADERA', '31'),
('1099', 'RESTREPO', '31'),
('11', 'TARAPACÁ', '1'),
('110', 'SAN ROQUE', '2'),
('1100', 'RIOFRÍO', '31'),
('1101', 'ROLDANILLO', '31'),
('1102', 'SAN PEDRO', '31'),
('1103', 'SEVILLA', '31'),
('1104', 'TORO', '31'),
('1105', 'TRUJILLO', '31'),
('1106', 'TULUÁ', '31'),
('1107', 'ULLOA', '31'),
('1108', 'VERSALLES', '31'),
('1109', 'VIJES', '31'),
('111', 'SAN VICENTE FERRER', '2'),
('1110', 'YOTOCO', '31'),
('1111', 'YUMBO', '31'),
('1112', 'ZARZAL', '31'),
('1113', 'CARURÚ', '32'),
('1114', 'MITÚ', '32'),
('1115', 'PACOA', '32'),
('1116', 'PAPUNAUA', '32'),
('1117', 'TARAIRA', '32'),
('1118', 'YAVARATÉ', '32'),
('1119', 'CUMARIBO', '33'),
('112', 'SANTA BÁRBARA', '2'),
('1120', 'LA PRIMAVERA', '33'),
('1121', 'PUERTO CARREÑO', '33'),
('1122', 'SANTA ROSALÍA', '33'),
('113', 'SANTA FÉ DE ANTIOQUIA', '2'),
('114', 'SANTA ROSA DE OSOS', '2'),
('115', 'SANTO DOMINGO', '2'),
('116', 'SEGOVIA', '2'),
('117', 'SONSÓN', '2'),
('118', 'SOPETRÁN', '2'),
('119', 'TÁMESIS', '2'),
('12', 'ABEJORRAL', '2'),
('120', 'TARAZÁ', '2'),
('121', 'TARSO', '2'),
('122', 'TITIRIBÍ', '2'),
('123', 'TOLEDO', '2'),
('124', 'TURBO', '2'),
('125', 'URAMITA', '2'),
('126', 'URRAO', '2'),
('127', 'VALDIVIA', '2'),
('128', 'VALPARAÍSO', '2'),
('129', 'VEGACHÍ', '2'),
('13', 'ABRIAQUÍ', '2'),
('130', 'VENECIA', '2'),
('131', 'VIGÍA DEL FUERTE', '2'),
('132', 'YALÍ', '2'),
('133', 'YARUMAL', '2'),
('134', 'YOLOMBÓ', '2'),
('135', 'YONDÓ', '2'),
('136', 'ZARAGOZA', '2'),
('137', 'ARAUCA', '3'),
('138', 'ARAUQUITA', '3'),
('139', 'CRAVO NORTE', '3'),
('14', 'ALEJANDRÍA', '2'),
('140', 'FORTUL', '3'),
('141', 'PUERTO RONDÓN', '3'),
('142', 'SARAVENA', '3'),
('143', 'TAME', '3'),
('144', 'PROVIDENCIA', '4'),
('145', 'SAN ANDRÉS', '4'),
('146', 'BARANOA', '5'),
('147', 'BARRANQUILLA', '5'),
('148', 'CAMPO DE LA CRUZ', '5'),
('149', 'CANDELARIA', '5'),
('15', 'AMAGÁ', '2'),
('150', 'GALAPA', '5'),
('151', 'JUAN DE ACOSTA', '5'),
('152', 'LURUACO', '5'),
('153', 'MALAMBO', '5'),
('154', 'MANATÍ', '5'),
('155', 'PALMAR DE VARELA', '5'),
('156', 'PIOJÓ', '5'),
('157', 'POLONUEVO', '5'),
('158', 'PONEDERA', '5'),
('159', 'PUERTO COLOMBIA', '5'),
('16', 'AMALFI', '2'),
('160', 'REPELÓN', '5'),
('161', 'SABANAGRANDE', '5'),
('162', 'SABANALARGA', '5'),
('163', 'SANTA LUCÍA', '5'),
('164', 'SANTO TOMÁS', '5'),
('165', 'SOLEDAD', '5'),
('166', 'SUAN', '5'),
('167', 'TUBARÁ', '5'),
('168', 'USIACURÍ', '5'),
('169', 'BOGOTÁ, D.C.', '6'),
('17', 'ANDES', '2'),
('170', 'ACHÍ', '7'),
('171', 'ALTOS DEL ROSARIO', '7'),
('172', 'ARENAL', '7'),
('173', 'ARJONA', '7'),
('174', 'ARROYOHONDO', '7'),
('175', 'BARRANCO DE LOBA', '7'),
('176', 'CALAMAR', '7'),
('177', 'CANTAGALLO', '7'),
('178', 'CARTAGENA DE INDIAS', '7'),
('179', 'CICUCO', '7'),
('18', 'ANGELÓPOLIS', '2'),
('180', 'CLEMENCIA', '7'),
('181', 'CÓRDOBA', '7'),
('182', 'EL CARMEN DE BOLÍVAR', '7'),
('183', 'EL GUAMO', '7'),
('184', 'EL PEÑÓN', '7'),
('185', 'HATILLO DE LOBA', '7'),
('186', 'MAGANGUÉ', '7'),
('187', 'MAHATES', '7'),
('188', 'MARGARITA', '7'),
('189', 'MARÍA LA BAJA', '7'),
('19', 'ANGOSTURA', '2'),
('190', 'MOMPÓS', '7'),
('191', 'MONTECRISTO', '7'),
('192', 'MORALES', '7'),
('193', 'NOROSÍ', '7'),
('194', 'PINILLOS', '7'),
('195', 'REGIDOR', '7'),
('196', 'RÍO VIEJO', '7'),
('197', 'SAN CRISTÓBAL', '7'),
('198', 'SAN ESTANISLAO', '7'),
('199', 'SAN FERNANDO', '7'),
('2', 'LA CHORRERA', '1'),
('20', 'ANORÍ', '2'),
('200', 'SAN JACINTO', '7'),
('201', 'SAN JACINTO DEL CAUCA', '7'),
('202', 'SAN JUAN NEPOMUCENO', '7'),
('203', 'SAN MARTÍN DE LOBA', '7'),
('204', 'SAN PABLO', '7'),
('205', 'SANTA CATALINA', '7'),
('206', 'SANTA ROSA', '7'),
('207', 'SANTA ROSA DEL SUR', '7'),
('208', 'SIMITÍ', '7'),
('209', 'SOPLAVIENTO', '7'),
('21', 'ANZÁ', '2'),
('210', 'TALAIGUA NUEVO', '7'),
('211', 'TIQUISIO', '7'),
('212', 'TURBACO', '7'),
('213', 'TURBANÁ', '7'),
('214', 'VILLANUEVA', '7'),
('215', 'ZAMBRANO', '7'),
('216', 'ALMEIDA', '8'),
('217', 'AQUITANIA', '8'),
('218', 'ARCABUCO', '8'),
('219', 'BELÉN', '8'),
('22', 'APARTADÓ', '2'),
('220', 'BERBEO', '8'),
('221', 'BETÉITIVA', '8'),
('222', 'BOAVITA', '8'),
('223', 'BOYACÁ', '8'),
('224', 'BRICEÑO', '8'),
('225', 'BUENAVISTA', '8'),
('226', 'BUSBANZÁ', '8'),
('227', 'CALDAS', '8'),
('228', 'CAMPOHERMOSO', '8'),
('229', 'CERINZA', '8'),
('23', 'ARBOLETES', '2'),
('230', 'CHINAVITA', '8'),
('231', 'CHIQUINQUIRÁ', '8'),
('232', 'CHÍQUIZA', '8'),
('233', 'CHISCAS', '8'),
('234', 'CHITA', '8'),
('235', 'CHITARAQUE', '8'),
('236', 'CHIVATÁ', '8'),
('237', 'CHIVOR', '8'),
('238', 'CIÉNEGA', '8'),
('239', 'CÓMBITA', '8'),
('24', 'ARGELIA', '2'),
('240', 'COPER', '8'),
('241', 'CORRALES', '8'),
('242', 'COVARACHÍA', '8'),
('243', 'CUBARÁ', '8'),
('244', 'CUCAITA', '8'),
('245', 'CUÍTIVA', '8'),
('246', 'DUITAMA', '8'),
('247', 'EL COCUY', '8'),
('248', 'EL ESPINO', '8'),
('249', 'FIRAVITOBA', '8'),
('25', 'ARMENIA', '2'),
('250', 'FLORESTA', '8'),
('251', 'GACHANTIVÁ', '8'),
('252', 'GÁMEZA', '8'),
('253', 'GARAGOA', '8'),
('254', 'GUACAMAYAS', '8'),
('255', 'GUATEQUE', '8'),
('256', 'GUAYATÁ', '8'),
('257', 'GÜICÁN', '8'),
('258', 'IZA', '8'),
('259', 'JENESANO', '8'),
('26', 'BARBOSA', '2'),
('260', 'JERICÓ', '8'),
('261', 'LA CAPILLA', '8'),
('262', 'LA UVITA', '8'),
('263', 'LA VICTORIA', '8'),
('264', 'LABRANZAGRANDE', '8'),
('265', 'MACANAL', '8'),
('266', 'MARIPÍ', '8'),
('267', 'MIRAFLORES', '8'),
('268', 'MONGUA', '8'),
('269', 'MONGUÍ', '8'),
('27', 'BELLO', '2'),
('270', 'MONIQUIRÁ', '8'),
('271', 'MOTAVITA', '8'),
('272', 'MUZO', '8'),
('273', 'NOBSA', '8'),
('274', 'NUEVO COLÓN', '8'),
('275', 'OICATÁ', '8'),
('276', 'OTANCHE', '8'),
('277', 'PACHAVITA', '8'),
('278', 'PÁEZ', '8'),
('279', 'PAIPA', '8'),
('28', 'BELMIRA', '2'),
('280', 'PAJARITO', '8'),
('281', 'PANQUEBA', '8'),
('282', 'PAUNA', '8'),
('283', 'PAYA', '8'),
('284', 'PAZ DE RÍO', '8'),
('285', 'PESCA', '8'),
('286', 'PISBA', '8'),
('287', 'PUERTO BOYACÁ', '8'),
('288', 'QUÍPAMA', '8'),
('289', 'RAMIRIQUÍ', '8'),
('29', 'BETANIA', '2'),
('290', 'RÁQUIRA', '8'),
('291', 'RONDÓN', '8'),
('292', 'SABOYÁ', '8'),
('293', 'SÁCHICA', '8'),
('294', 'SAMACÁ', '8'),
('295', 'SAN EDUARDO', '8'),
('296', 'SAN JOSÉ DE PARE', '8'),
('297', 'SAN LUIS DE GACENO', '8'),
('298', 'SAN MATEO', '8'),
('299', 'SAN MIGUEL DE SEMA', '8'),
('3', 'LA PEDRERA', '1'),
('30', 'BETULIA', '2'),
('300', 'SAN PABLO DE BORBUR', '8'),
('301', 'SANTA MARÍA', '8'),
('302', 'SANTA ROSA DE VITERBO', '8'),
('303', 'SANTA SOFÍA', '8'),
('304', 'SANTANA', '8'),
('305', 'SATIVANORTE', '8'),
('306', 'SATIVASUR', '8'),
('307', 'SIACHOQUE', '8'),
('308', 'SOATÁ', '8'),
('309', 'SOCHA', '8'),
('31', 'BRICEÑO', '2'),
('310', 'SOCOTÁ', '8'),
('311', 'SOGAMOSO', '8'),
('312', 'SOMONDOCO', '8'),
('313', 'SORA', '8'),
('314', 'SORACÁ', '8'),
('315', 'SOTAQUIRÁ', '8'),
('316', 'SUSACÓN', '8'),
('317', 'SUTAMARCHÁN', '8'),
('318', 'SUTATENZA', '8'),
('319', 'TASCO', '8'),
('32', 'BURITICÁ', '2'),
('320', 'TENZA', '8'),
('321', 'TIBANÁ', '8'),
('322', 'TIBASOSA', '8'),
('323', 'TINJACÁ', '8'),
('324', 'TIPACOQUE', '8'),
('325', 'TOCA', '8'),
('326', 'TOGÜÍ', '8'),
('327', 'TÓPAGA', '8'),
('328', 'TOTA', '8'),
('329', 'TUNJA', '8'),
('33', 'CÁCERES', '2'),
('330', 'TUNUNGUÁ', '8'),
('331', 'TURMEQUÉ', '8'),
('332', 'TUTA', '8'),
('333', 'TUTAZÁ', '8'),
('334', 'ÚMBITA', '8'),
('335', 'VENTAQUEMADA', '8'),
('336', 'VILLA DE LEYVA', '8'),
('337', 'VIRACACHÁ', '8'),
('338', 'ZETAQUIRA', '8'),
('339', 'AGUADAS', '9'),
('34', 'CAICEDO', '2'),
('340', 'ANSERMA', '9'),
('341', 'ARANZAZU', '9'),
('342', 'BELALCÁZAR', '9'),
('343', 'CHINCHINÁ', '9'),
('344', 'FILADELFIA', '9'),
('345', 'LA DORADA', '9'),
('346', 'LA MERCED', '9'),
('347', 'MANIZALES', '9'),
('348', 'MANZANARES', '9'),
('349', 'MARMATO', '9'),
('35', 'CALDAS', '2'),
('350', 'MARQUETALIA', '9'),
('351', 'MARULANDA', '9'),
('352', 'NEIRA', '9'),
('353', 'NORCASIA', '9'),
('354', 'PÁCORA', '9'),
('355', 'PALESTINA', '9'),
('356', 'PENSILVANIA', '9'),
('357', 'RIOSUCIO', '9'),
('358', 'RISARALDA', '9'),
('359', 'SALAMINA', '9'),
('36', 'CAMPAMENTO', '2'),
('360', 'SAMANÁ', '9'),
('361', 'SAN JOSÉ', '9'),
('362', 'SUPÍA', '9'),
('363', 'VICTORIA', '9'),
('364', 'VILLAMARÍA', '9'),
('365', 'VITERBO', '9'),
('366', 'ALBANIA', '10'),
('367', 'BELÉN DE LOS ANDAQUÍES', '10'),
('368', 'CARTAGENA DEL CHAIRÁ', '10'),
('369', 'CURILLO', '10'),
('37', 'CAÑASGORDAS', '2'),
('370', 'EL DONCELLO', '10'),
('371', 'EL PAUJÍL', '10'),
('372', 'FLORENCIA', '10'),
('373', 'LA MONTAÑITA', '10'),
('374', 'MILÁN', '10'),
('375', 'MORELIA', '10'),
('376', 'PUERTO RICO', '10'),
('377', 'SAN JOSÉ DEL FRAGUA', '10'),
('378', 'SAN VICENTE DEL CAGUÁN', '10'),
('379', 'SOLANO', '10'),
('38', 'CARACOLÍ', '2'),
('380', 'SOLITA', '10'),
('381', 'VALPARAÍSO', '10'),
('382', 'AGUAZUL', '11'),
('383', 'CHÁMEZA', '11'),
('384', 'HATO COROZAL', '11'),
('385', 'LA SALINA', '11'),
('386', 'MANÍ', '11'),
('387', 'MONTERREY', '11'),
('388', 'NUNCHÍA', '11'),
('389', 'OROCUÉ', '11'),
('39', 'CARAMANTA', '2'),
('390', 'PAZ DE ARIPORO', '11'),
('391', 'PORE', '11'),
('392', 'RECETOR', '11'),
('393', 'SABANALARGA', '11'),
('394', 'SÁCAMA', '11'),
('395', 'SAN LUIS DE PALENQUE', '11'),
('396', 'TÁMARA', '11'),
('397', 'TAURAMENA', '11'),
('398', 'TRINIDAD', '11'),
('399', 'VILLANUEVA', '11'),
('4', 'LA VICTORIA', '1'),
('40', 'CAREPA', '2'),
('400', 'YOPAL', '11'),
('401', 'ALMAGUER', '12'),
('402', 'ARGELIA', '12'),
('403', 'BALBOA', '12'),
('404', 'BOLÍVAR', '12'),
('405', 'BUENOS AIRES', '12'),
('406', 'CAJIBÍO', '12'),
('407', 'CALDONO', '12'),
('408', 'CALOTO', '12'),
('409', 'CORINTO', '12'),
('41', 'CAROLINA', '2'),
('410', 'EL TAMBO', '12'),
('411', 'FLORENCIA', '12'),
('412', 'GUACHENÉ', '12'),
('413', 'GUAPÍ', '12'),
('414', 'INZÁ', '12'),
('415', 'JAMBALÓ', '12'),
('416', 'LA SIERRA', '12'),
('417', 'LA VEGA', '12'),
('418', 'LÓPEZ DE MICAY', '12'),
('419', 'MERCADERES', '12'),
('42', 'CAUCASIA', '2'),
('420', 'MIRANDA', '12'),
('421', 'MORALES', '12'),
('422', 'PADILLA', '12'),
('423', 'PÁEZ', '12'),
('424', 'PATÍA', '12'),
('425', 'PIAMONTE', '12'),
('426', 'PIENDAMÓ', '12'),
('427', 'POPAYÁN', '12'),
('428', 'PUERTO TEJADA', '12'),
('429', 'PURACÉ', '12'),
('43', 'CHIGORODÓ', '2'),
('430', 'ROSAS', '12'),
('431', 'SAN SEBASTIÁN', '12'),
('432', 'SANTA ROSA', '12'),
('433', 'SANTANDER DE QUILICHAO', '12'),
('434', 'SILVIA', '12'),
('435', 'SOTARA', '12'),
('436', 'SUÁREZ', '12'),
('437', 'SUCRE', '12'),
('438', 'TIMBÍO', '12'),
('439', 'TIMBIQUÍ', '12'),
('44', 'CISNEROS', '2'),
('440', 'TORIBÍO', '12'),
('441', 'TOTORÓ', '12'),
('442', 'VILLA RICA', '12'),
('443', 'AGUACHICA', '13'),
('444', 'AGUSTÍN CODAZZI', '13'),
('445', 'ASTREA', '13'),
('446', 'BECERRIL', '13'),
('447', 'BOSCONIA', '13'),
('448', 'CHIMICHAGUA', '13'),
('449', 'CHIRIGUANÁ', '13'),
('45', 'CIUDAD BOLÍVAR', '2'),
('450', 'CURUMANÍ', '13'),
('451', 'EL COPEY', '13'),
('452', 'EL PASO', '13'),
('453', 'GAMARRA', '13'),
('454', 'GONZÁLEZ', '13'),
('455', 'LA GLORIA', '13'),
('456', 'LA JAGUA DE IBIRICO', '13'),
('457', 'LA PAZ', '13'),
('458', 'MANAURE BALCÓN DEL CESAR', '13'),
('459', 'PAILITAS', '13'),
('46', 'COCORNÁ', '2'),
('460', 'PELAYA', '13'),
('461', 'PUEBLO BELLO', '13'),
('462', 'RÍO DE ORO', '13'),
('463', 'SAN ALBERTO', '13'),
('464', 'SAN DIEGO', '13'),
('465', 'SAN MARTÍN', '13'),
('466', 'TAMALAMEQUE', '13'),
('467', 'VALLEDUPAR', '13'),
('468', 'ACANDÍ', '14'),
('469', 'ALTO BAUDÓ', '14'),
('47', 'CONCEPCIÓN', '2'),
('470', 'ATRATO', '14'),
('471', 'BAGADÓ', '14'),
('472', 'BAHÍA SOLANO', '14'),
('473', 'BAJO BAUDÓ', '14'),
('474', 'BOJAYÁ', '14'),
('475', 'CARMEN DEL DARIÉN', '14'),
('476', 'CÉRTEGUI', '14'),
('477', 'CONDOTO', '14'),
('478', 'EL CANTÓN DEL SAN PABLO', '14'),
('479', 'EL CARMEN DE ATRATO', '14'),
('48', 'CONCORDIA', '2'),
('480', 'EL LITORAL DEL SAN JUAN', '14'),
('481', 'ISTMINA', '14'),
('482', 'JURADÓ', '14'),
('483', 'LLORÓ', '14'),
('484', 'MEDIO ATRATO', '14'),
('485', 'MEDIO BAUDÓ', '14'),
('486', 'MEDIO SAN JUAN', '14'),
('487', 'NÓVITA', '14'),
('488', 'NUQUÍ', '14'),
('489', 'QUIBDÓ', '14'),
('49', 'COPACABANA', '2'),
('490', 'RÍO IRÓ', '14'),
('491', 'RÍO QUITO', '14'),
('492', 'RIOSUCIO', '14'),
('493', 'SAN JOSÉ DEL PALMAR', '14'),
('494', 'SIPÍ', '14'),
('495', 'TADÓ', '14'),
('496', 'UNGUÍA', '14'),
('497', 'UNIÓN PANAMERICANA', '14'),
('498', 'AYAPEL', '15'),
('499', 'BUENAVISTA', '15'),
('5', 'LETICIA', '1'),
('50', 'DABEIBA', '2'),
('500', 'CANALETE', '15'),
('501', 'CERETÉ', '15'),
('502', 'CHIMÁ', '15'),
('503', 'CHINÚ', '15'),
('504', 'CIÉNAGA DE ORO', '15'),
('505', 'COTORRA', '15'),
('506', 'LA APARTADA', '15'),
('507', 'LORICA', '15'),
('508', 'LOS CÓRDOBAS', '15'),
('509', 'MOMIL', '15'),
('51', 'DONMATÍAS', '2'),
('510', 'MONTELÍBANO', '15'),
('511', 'MONTERÍA', '15'),
('512', 'MOÑITOS', '15'),
('513', 'PLANETA RICA', '15'),
('514', 'PUEBLO NUEVO', '15'),
('515', 'PUERTO ESCONDIDO', '15'),
('516', 'PUERTO LIBERTADOR', '15'),
('517', 'PURÍSIMA DE LA CONCEPCIÓN', '15'),
('518', 'SAHAGÚN', '15'),
('519', 'SAN ANDRÉS DE SOTAVENTO', '15'),
('52', 'EBÉJICO', '2'),
('520', 'SAN ANTERO', '15'),
('521', 'SAN BERNARDO DEL VIENTO', '15'),
('522', 'SAN CARLOS', '15'),
('523', 'SAN JOSÉ DE URÉ', '15'),
('524', 'SAN PELAYO', '15'),
('525', 'TIERRALTA', '15'),
('526', 'TUCHÍN', '15'),
('527', 'VALENCIA', '15'),
('528', 'AGUA DE DIOS', '16'),
('529', 'ALBÁN', '16'),
('53', 'EL BAGRE', '2'),
('530', 'ANAPOIMA', '16'),
('531', 'ANOLAIMA', '16'),
('532', 'APULO', '16'),
('533', 'ARBELÁEZ', '16'),
('534', 'BELTRÁN', '16'),
('535', 'BITUIMA', '16'),
('536', 'BOJACÁ', '16'),
('537', 'CABRERA', '16'),
('538', 'CACHIPAY', '16'),
('539', 'CAJICÁ', '16'),
('54', 'EL CARMEN DE VIBORAL', '2'),
('540', 'CAPARRAPÍ', '16'),
('541', 'CÁQUEZA', '16'),
('542', 'CARMEN DE CARUPA', '16'),
('543', 'CHAGUANÍ', '16'),
('544', 'CHÍA', '16'),
('545', 'CHIPAQUE', '16'),
('546', 'CHOACHÍ', '16'),
('547', 'CHOCONTÁ', '16'),
('548', 'COGUA', '16'),
('549', 'COTA', '16'),
('55', 'EL SANTUARIO', '2'),
('550', 'CUCUNUBÁ', '16'),
('551', 'EL COLEGIO', '16'),
('552', 'EL PEÑÓN', '16'),
('553', 'EL ROSAL', '16'),
('554', 'FACATATIVÁ', '16'),
('555', 'FÓMEQUE', '16'),
('556', 'FOSCA', '16'),
('557', 'FUNZA', '16'),
('558', 'FÚQUENE', '16'),
('559', 'FUSAGASUGÁ', '16'),
('56', 'ENTRERRÍOS', '2'),
('560', 'GACHALÁ', '16'),
('561', 'GACHANCIPÁ', '16'),
('562', 'GACHETÁ', '16'),
('563', 'GAMA', '16'),
('564', 'GIRARDOT', '16'),
('565', 'GRANADA', '16'),
('566', 'GUACHETÁ', '16'),
('567', 'GUADUAS', '16'),
('568', 'GUASCA', '16'),
('569', 'GUATAQUÍ', '16'),
('57', 'ENVIGADO', '2'),
('570', 'GUATAVITA', '16'),
('571', 'GUAYABAL DE SÍQUIMA', '16'),
('572', 'GUAYABETAL', '16'),
('573', 'GUTIÉRREZ', '16'),
('574', 'JERUSALÉN', '16'),
('575', 'JUNÍN', '16'),
('576', 'LA CALERA', '16'),
('577', 'LA MESA', '16'),
('578', 'LA PALMA', '16'),
('579', 'LA PEÑA', '16'),
('58', 'FREDONIA', '2'),
('580', 'LA VEGA', '16'),
('581', 'LENGUAZAQUE', '16'),
('582', 'MACHETÁ', '16'),
('583', 'MADRID', '16'),
('584', 'MANTA', '16'),
('585', 'MEDINA', '16'),
('586', 'MOSQUERA', '16'),
('587', 'NARIÑO', '16'),
('588', 'NEMOCÓN', '16'),
('589', 'NILO', '16'),
('59', 'FRONTINO', '2'),
('590', 'NIMAIMA', '16'),
('591', 'NOCAIMA', '16'),
('592', 'PACHO', '16'),
('593', 'PAIME', '16'),
('594', 'PANDI', '16'),
('595', 'PARATEBUENO', '16'),
('596', 'PASCA', '16'),
('597', 'PUERTO SALGAR', '16'),
('598', 'PULÍ', '16'),
('599', 'QUEBRADANEGRA', '16'),
('6', 'MIRITÍ - PARANÁ', '1'),
('60', 'GIRALDO', '2'),
('600', 'QUETAME', '16'),
('601', 'QUIPILE', '16'),
('602', 'RICAURTE', '16'),
('603', 'SAN ANTONIO DEL TEQUENDAMA', '16'),
('604', 'SAN BERNARDO', '16'),
('605', 'SAN CAYETANO', '16'),
('606', 'SAN FRANCISCO', '16'),
('607', 'SAN JUAN DE RIOSECO', '16'),
('608', 'SASAIMA', '16'),
('609', 'SESQUILÉ', '16'),
('61', 'GIRARDOTA', '2'),
('610', 'SIBATÉ', '16'),
('611', 'SILVANIA', '16'),
('612', 'SIMIJACA', '16'),
('613', 'SOACHA', '16'),
('614', 'SOPÓ', '16'),
('615', 'SUBACHOQUE', '16'),
('616', 'SUESCA', '16'),
('617', 'SUPATÁ', '16'),
('618', 'SUSA', '16'),
('619', 'SUTATAUSA', '16'),
('62', 'GÓMEZ PLATA', '2'),
('620', 'TABIO', '16'),
('621', 'TAUSA', '16'),
('622', 'TENA', '16'),
('623', 'TENJO', '16'),
('624', 'TIBACUY', '16'),
('625', 'TIBIRITA', '16'),
('626', 'TOCAIMA', '16'),
('627', 'TOCANCIPÁ', '16'),
('628', 'TOPAIPÍ', '16'),
('629', 'UBALÁ', '16'),
('63', 'GRANADA', '2'),
('630', 'UBAQUE', '16'),
('631', 'UNE', '16'),
('632', 'ÚTICA', '16'),
('633', 'VENECIA', '16'),
('634', 'VERGARA', '16'),
('635', 'VIANÍ', '16'),
('636', 'VILLA DE SAN DIEGO DE UBATÉ', '16'),
('637', 'VILLAGÓMEZ', '16'),
('638', 'VILLAPINZÓN', '16'),
('639', 'VILLETA', '16'),
('64', 'GUADALUPE', '2'),
('640', 'VIOTÁ', '16'),
('641', 'YACOPÍ', '16'),
('642', 'ZIPACÓN', '16'),
('643', 'ZIPAQUIRÁ', '16'),
('644', 'BARRANCO MINAS', '17'),
('645', 'CACAHUAL', '17'),
('646', 'INÍRIDA', '17'),
('647', 'LA GUADALUPE', '17'),
('648', 'MAPIRIPANA', '17'),
('649', 'MORICHAL', '17'),
('65', 'GUARNE', '2'),
('650', 'PANA PANA', '17'),
('651', 'PUERTO COLOMBIA', '17'),
('652', 'SAN FELIPE', '17'),
('653', 'CALAMAR', '18'),
('654', 'EL RETORNO', '18'),
('655', 'MIRAFLORES', '18'),
('656', 'SAN JOSÉ DEL GUAVIARE', '18'),
('657', 'ACEVEDO', '19'),
('658', 'AGRADO', '19'),
('659', 'AIPE', '19'),
('66', 'GUATAPÉ', '2'),
('660', 'ALGECIRAS', '19'),
('661', 'ALTAMIRA', '19'),
('662', 'BARAYA', '19'),
('663', 'CAMPOALEGRE', '19'),
('664', 'COLOMBIA', '19'),
('665', 'ELÍAS', '19'),
('666', 'GARZÓN', '19'),
('667', 'GIGANTE', '19'),
('668', 'GUADALUPE', '19'),
('669', 'HOBO', '19'),
('67', 'HELICONIA', '2'),
('670', 'ÍQUIRA', '19'),
('671', 'ISNOS', '19'),
('672', 'LA ARGENTINA', '19'),
('673', 'LA PLATA', '19'),
('674', 'NÁTAGA', '19'),
('675', 'NEIVA', '19'),
('676', 'OPORAPA', '19'),
('677', 'PAICOL', '19'),
('678', 'PALERMO', '19'),
('679', 'PALESTINA', '19'),
('68', 'HISPANIA', '2'),
('680', 'PITAL', '19'),
('681', 'PITALITO', '19'),
('682', 'RIVERA', '19'),
('683', 'SALADOBLANCO', '19'),
('684', 'SAN AGUSTÍN', '19'),
('685', 'SANTA MARÍA', '19'),
('686', 'SUAZA', '19'),
('687', 'TARQUI', '19'),
('688', 'TELLO', '19'),
('689', 'TERUEL', '19'),
('69', 'ITAGÜÍ', '2'),
('690', 'TESALIA', '19'),
('691', 'TIMANÁ', '19'),
('692', 'VILLAVIEJA', '19'),
('693', 'YAGUARÁ', '19'),
('694', 'ALBANIA', '20'),
('695', 'BARRANCAS', '20'),
('696', 'DIBULLA', '20'),
('697', 'DISTRACCIÓN', '20'),
('698', 'EL MOLINO', '20'),
('699', 'FONSECA', '20'),
('7', 'PUERTO ALEGRÍA', '1'),
('70', 'ITUANGO', '2'),
('700', 'HATONUEVO', '20'),
('701', 'LA JAGUA DEL PILAR', '20'),
('702', 'MAICAO', '20'),
('703', 'MANAURE', '20'),
('704', 'RIOHACHA', '20'),
('705', 'SAN JUAN DEL CESAR', '20'),
('706', 'URIBIA', '20'),
('707', 'URUMITA', '20'),
('708', 'VILLANUEVA', '20'),
('709', 'ALGARROBO', '21'),
('71', 'JARDÍN', '2'),
('710', 'ARACATACA', '21'),
('711', 'ARIGUANÍ', '21'),
('712', 'CERRO DE SAN ANTONIO', '21'),
('713', 'CHIVOLO', '21'),
('714', 'CIÉNAGA', '21'),
('715', 'CONCORDIA', '21'),
('716', 'EL BANCO', '21'),
('717', 'EL PIÑÓN', '21'),
('718', 'EL RETÉN', '21'),
('719', 'FUNDACIÓN', '21'),
('72', 'JERICÓ', '2'),
('720', 'GUAMAL', '21'),
('721', 'NUEVA GRANADA', '21'),
('722', 'PEDRAZA', '21'),
('723', 'PIJIÑO DEL CARMEN', '21'),
('724', 'PIVIJAY', '21'),
('725', 'PLATO', '21'),
('726', 'PUEBLOVIEJO', '21'),
('727', 'REMOLINO', '21'),
('728', 'SABANAS DE SAN ÁNGEL', '21'),
('729', 'SALAMINA', '21'),
('73', 'LA CEJA', '2'),
('730', 'SAN SEBASTIÁN DE BUENAVISTA', '21'),
('731', 'SAN ZENÓN', '21'),
('732', 'SANTA ANA', '21'),
('733', 'SANTA BÁRBARA DE PINTO', '21'),
('734', 'SANTA MARTA', '21'),
('735', 'SITIONUEVO', '21'),
('736', 'TENERIFE', '21'),
('737', 'ZAPAYÁN', '21'),
('738', 'ZONA BANANERA', '21'),
('739', 'ACACÍAS', '22'),
('74', 'LA ESTRELLA', '2'),
('740', 'BARRANCA DE UPÍA', '22'),
('741', 'CABUYARO', '22'),
('742', 'CASTILLA LA NUEVA', '22'),
('743', 'CUMARAL', '22'),
('744', 'EL CALVARIO', '22'),
('745', 'EL CASTILLO', '22'),
('746', 'EL DORADO', '22'),
('747', 'FUENTE DE ORO', '22'),
('748', 'GRANADA', '22'),
('749', 'GUAMAL', '22'),
('75', 'LA PINTADA', '2'),
('750', 'LA MACARENA', '22'),
('751', 'LEJANÍAS', '22'),
('752', 'MAPIRIPÁN', '22'),
('753', 'MESETAS', '22'),
('754', 'PUERTO CONCORDIA', '22'),
('755', 'PUERTO GAITÁN', '22'),
('756', 'PUERTO LLERAS', '22'),
('757', 'PUERTO LÓPEZ', '22'),
('758', 'PUERTO RICO', '22'),
('759', 'RESTREPO', '22'),
('76', 'LA UNIÓN', '2'),
('760', 'SAN CARLOS DE GUAROA', '22'),
('761', 'SAN JUAN DE ARAMA', '22'),
('762', 'SAN JUANITO', '22'),
('763', 'SAN LUIS DE CUBARRAL', '22'),
('764', 'SAN MARTÍN', '22'),
('765', 'URIBE', '22'),
('766', 'VILLAVICENCIO', '22'),
('767', 'VISTAHERMOSA', '22'),
('768', 'ALBÁN', '23'),
('769', 'ALDANA', '23'),
('77', 'LIBORINA', '2'),
('770', 'ANCUYÁ', '23'),
('771', 'ARBOLEDA', '23'),
('772', 'BARBACOAS', '23'),
('773', 'BELÉN', '23'),
('774', 'BUESACO', '23'),
('775', 'CHACHAGÜÍ', '23'),
('776', 'COLÓN', '23'),
('777', 'CONSACÁ', '23'),
('778', 'CONTADERO', '23'),
('779', 'CÓRDOBA', '23'),
('78', 'MACEO', '2'),
('780', 'CUASPÚD', '23'),
('781', 'CUMBAL', '23'),
('782', 'CUMBITARA', '23'),
('783', 'EL CHARCO', '23'),
('784', 'EL PEÑOL', '23'),
('785', 'EL ROSARIO', '23'),
('786', 'EL TABLÓN DE GÓMEZ', '23'),
('787', 'EL TAMBO', '23'),
('788', 'FRANCISCO PIZARRO', '23'),
('789', 'FUNES', '23'),
('79', 'MARINILLA', '2'),
('790', 'GUACHUCAL', '23'),
('791', 'GUAITARILLA', '23'),
('792', 'GUALMATÁN', '23'),
('793', 'ILES', '23'),
('794', 'IMUÉS', '23'),
('795', 'IPIALES', '23'),
('796', 'LA CRUZ', '23'),
('797', 'LA FLORIDA', '23'),
('798', 'LA LLANADA', '23'),
('799', 'LA TOLA', '23'),
('8', 'PUERTO ARICA', '1'),
('80', 'MEDELLÍN', '2'),
('800', 'LA UNIÓN', '23'),
('801', 'LEIVA', '23'),
('802', 'LINARES', '23'),
('803', 'LOS ANDES', '23'),
('804', 'MAGÜÍ', '23'),
('805', 'MALLAMA', '23'),
('806', 'MOSQUERA', '23'),
('807', 'NARIÑO', '23'),
('808', 'OLAYA HERRERA', '23'),
('809', 'OSPINA', '23'),
('81', 'MONTEBELLO', '2'),
('810', 'PASTO', '23'),
('811', 'POLICARPA', '23'),
('812', 'POTOSÍ', '23'),
('813', 'PROVIDENCIA', '23'),
('814', 'PUERRES', '23'),
('815', 'PUPIALES', '23'),
('816', 'RICAURTE', '23'),
('817', 'ROBERTO PAYÁN', '23'),
('818', 'SAMANIEGO', '23'),
('819', 'SAN ANDRÉS DE TUMACO', '23'),
('82', 'MURINDÓ', '2'),
('820', 'SAN BERNARDO', '23'),
('821', 'SAN LORENZO', '23'),
('822', 'SAN PABLO', '23'),
('823', 'SAN PEDRO DE CARTAGO', '23'),
('824', 'SANDONÁ', '23'),
('825', 'SANTA BÁRBARA', '23'),
('826', 'SANTACRUZ', '23'),
('827', 'SAPUYES', '23'),
('828', 'TAMINANGO', '23'),
('829', 'TANGUA', '23'),
('83', 'MUTATÁ', '2'),
('830', 'TÚQUERRES', '23'),
('831', 'YACUANQUER', '23'),
('832', 'ÁBREGO', '24'),
('833', 'ARBOLEDAS', '24'),
('834', 'BOCHALEMA', '24'),
('835', 'BUCARASICA', '24'),
('836', 'CÁCHIRA', '24'),
('837', 'CÁCOTA', '24'),
('838', 'CHINÁCOTA', '24'),
('839', 'CHITAGÁ', '24'),
('84', 'NARIÑO', '2'),
('840', 'CONVENCIÓN', '24'),
('841', 'CÚCUTA', '24'),
('842', 'CUCUTILLA', '24'),
('843', 'DURANIA', '24'),
('844', 'EL CARMEN', '24'),
('845', 'EL TARRA', '24'),
('846', 'EL ZULIA', '24'),
('847', 'GRAMALOTE', '24'),
('848', 'HACARÍ', '24'),
('849', 'HERRÁN', '24'),
('85', 'NECHÍ', '2'),
('850', 'LA ESPERANZA', '24'),
('851', 'LA PLAYA', '24'),
('852', 'LABATECA', '24'),
('853', 'LOS PATIOS', '24'),
('854', 'LOURDES', '24'),
('855', 'MUTISCUA', '24'),
('856', 'OCAÑA', '24'),
('857', 'PAMPLONA', '24'),
('858', 'PAMPLONITA', '24'),
('859', 'PUERTO SANTANDER', '24'),
('86', 'NECOCLÍ', '2'),
('860', 'RAGONVALIA', '24'),
('861', 'SALAZAR', '24'),
('862', 'SAN CALIXTO', '24'),
('863', 'SAN CAYETANO', '24'),
('864', 'SANTIAGO', '24'),
('865', 'SARDINATA', '24'),
('866', 'SILOS', '24'),
('867', 'TEORAMA', '24'),
('868', 'TIBÚ', '24'),
('869', 'TOLEDO', '24'),
('87', 'OLAYA', '2'),
('870', 'VILLA CARO', '24'),
('871', 'VILLA DEL ROSARIO', '24'),
('872', 'COLÓN', '25'),
('873', 'MOCOA', '25'),
('874', 'ORITO', '25'),
('875', 'PUERTO ASÍS', '25'),
('876', 'PUERTO CAICEDO', '25'),
('877', 'PUERTO GUZMÁN', '25'),
('878', 'PUERTO LEGUÍZAMO', '25'),
('879', 'SAN FRANCISCO', '25'),
('88', 'PEÑOL', '2'),
('880', 'SAN MIGUEL', '25'),
('881', 'SANTIAGO', '25'),
('882', 'SIBUNDOY', '25'),
('883', 'VALLE DEL GUAMUEZ', '25'),
('884', 'VILLAGARZÓN', '25'),
('885', 'ARMENIA', '26'),
('886', 'BUENAVISTA', '26'),
('887', 'CALARCÁ', '26'),
('888', 'CIRCASIA', '26'),
('889', 'CÓRDOBA', '26'),
('89', 'PEQUE', '2'),
('890', 'FILANDIA', '26'),
('891', 'GÉNOVA', '26'),
('892', 'LA TEBAIDA', '26'),
('893', 'MONTENEGRO', '26'),
('894', 'PIJAO', '26'),
('895', 'QUIMBAYA', '26'),
('896', 'SALENTO', '26'),
('897', 'APÍA', '27'),
('898', 'BALBOA', '27'),
('899', 'BELÉN DE UMBRÍA', '27'),
('9', 'PUERTO NARIÑO', '1'),
('90', 'PUEBLORRICO', '2'),
('900', 'DOSQUEBRADAS', '27'),
('901', 'GUÁTICA', '27'),
('902', 'LA CELIA', '27'),
('903', 'LA VIRGINIA', '27'),
('904', 'MARSELLA', '27'),
('905', 'MISTRATÓ', '27'),
('906', 'PEREIRA', '27'),
('907', 'PUEBLO RICO', '27'),
('908', 'QUINCHÍA', '27'),
('909', 'SANTA ROSA DE CABAL', '27'),
('91', 'PUERTO BERRÍO', '2'),
('910', 'SANTUARIO', '27'),
('911', 'AGUADA', '28'),
('912', 'ALBANIA', '28'),
('913', 'ARATOCA', '28'),
('914', 'BARBOSA', '28'),
('915', 'BARICHARA', '28'),
('916', 'BARRANCABERMEJA', '28'),
('917', 'BETULIA', '28'),
('918', 'BOLÍVAR', '28'),
('919', 'BUCARAMANGA', '28'),
('92', 'PUERTO NARE', '2'),
('920', 'CABRERA', '28'),
('921', 'CALIFORNIA', '28'),
('922', 'CAPITANEJO', '28'),
('923', 'CARCASÍ', '28'),
('924', 'CEPITÁ', '28'),
('925', 'CERRITO', '28'),
('926', 'CHARALÁ', '28'),
('927', 'CHARTA', '28'),
('928', 'CHIMA', '28'),
('929', 'CHIPATÁ', '28'),
('93', 'PUERTO TRIUNFO', '2'),
('930', 'CIMITARRA', '28'),
('931', 'CONCEPCIÓN', '28'),
('932', 'CONFINES', '28'),
('933', 'CONTRATACIÓN', '28'),
('934', 'COROMORO', '28'),
('935', 'CURITÍ', '28'),
('936', 'EL CARMEN DE CHUCURÍ', '28'),
('937', 'EL GUACAMAYO', '28'),
('938', 'EL PEÑÓN', '28'),
('939', 'EL PLAYÓN', '28'),
('94', 'REMEDIOS', '2'),
('940', 'ENCINO', '28'),
('941', 'ENCISO', '28'),
('942', 'FLORIÁN', '28'),
('943', 'FLORIDABLANCA', '28'),
('944', 'GALÁN', '28'),
('945', 'GÁMBITA', '28'),
('946', 'GIRÓN', '28'),
('947', 'GUACA', '28'),
('948', 'GUADALUPE', '28'),
('949', 'GUAPOTÁ', '28'),
('95', 'RETIRO', '2'),
('950', 'GUAVATÁ', '28'),
('951', 'GÜEPSA', '28'),
('952', 'HATO', '28'),
('953', 'JESÚS MARÍA', '28'),
('954', 'JORDÁN', '28'),
('955', 'LA BELLEZA', '28'),
('956', 'LA PAZ', '28'),
('957', 'LANDÁZURI', '28'),
('958', 'LEBRIJA', '28'),
('959', 'LOS SANTOS', '28'),
('96', 'RIONEGRO', '2'),
('960', 'MACARAVITA', '28'),
('961', 'MÁLAGA', '28'),
('962', 'MATANZA', '28'),
('963', 'MOGOTES', '28'),
('964', 'MOLAGAVITA', '28'),
('965', 'OCAMONTE', '28'),
('966', 'OIBA', '28'),
('967', 'ONZAGA', '28'),
('968', 'PALMAR', '28'),
('969', 'PALMAS DEL SOCORRO', '28'),
('97', 'SABANALARGA', '2'),
('970', 'PÁRAMO', '28'),
('971', 'PIEDECUESTA', '28'),
('972', 'PINCHOTE', '28'),
('973', 'PUENTE NACIONAL', '28'),
('974', 'PUERTO PARRA', '28'),
('975', 'PUERTO WILCHES', '28'),
('976', 'RIONEGRO', '28'),
('977', 'SABANA DE TORRES', '28'),
('978', 'SAN ANDRÉS', '28'),
('979', 'SAN BENITO', '28'),
('98', 'SABANETA', '2'),
('980', 'SAN GIL', '28'),
('981', 'SAN JOAQUÍN', '28'),
('982', 'SAN JOSÉ DE MIRANDA', '28'),
('983', 'SAN MIGUEL', '28'),
('984', 'SAN VICENTE DE CHUCURÍ', '28'),
('985', 'SANTA BÁRBARA', '28'),
('986', 'SANTA HELENA DEL OPÓN', '28'),
('987', 'SIMACOTA', '28'),
('988', 'SOCORRO', '28'),
('989', 'SUAITA', '28'),
('99', 'SALGAR', '2'),
('990', 'SUCRE', '28'),
('991', 'SURATÁ', '28'),
('992', 'TONA', '28'),
('993', 'VALLE DE SAN JOSÉ', '28'),
('994', 'VÉLEZ', '28'),
('995', 'VETAS', '28'),
('996', 'VILLANUEVA', '28'),
('997', 'ZAPATOCA', '28'),
('998', 'BUENAVISTA', '29'),
('999', 'CAIMITO', '29');

-- --------------------------------------------------------

--
-- Table structure for table `tblproduccion`
--

CREATE TABLE `tblproduccion` (
  `codigo` int(3) NOT NULL,
  `fecha` date NOT NULL,
  `usuario` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblproduccion`
--

INSERT INTO `tblproduccion` (`codigo`, `fecha`, `usuario`) VALUES
(1, '2021-03-26', '1001651967'),
(2, '2021-04-09', '4586058'),
(3, '2021-04-14', '43574966654');

-- --------------------------------------------------------

--
-- Table structure for table `tblproduccionreceta`
--

CREATE TABLE `tblproduccionreceta` (
  `cod_produccion` int(3) NOT NULL,
  `cod_receta` int(3) NOT NULL,
  `cantidad` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblproduccionreceta`
--

INSERT INTO `tblproduccionreceta` (`cod_produccion`, `cod_receta`, `cantidad`) VALUES
(1, 5, 3),
(2, 6, 5),
(3, 7, 10),
(3, 8, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `tblproductoterminado`
--

CREATE TABLE `tblproductoterminado` (
  `codigo` varchar(15) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `fecha_creacion` date NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `categoria` int(3) NOT NULL,
  `unidades_disponibles` int(5) NOT NULL,
  `unidad_medida` int(2) NOT NULL,
  `precio` int(11) NOT NULL,
  `estado` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblproductoterminado`
--

INSERT INTO `tblproductoterminado` (`codigo`, `nombre`, `fecha_creacion`, `fecha_vencimiento`, `categoria`, `unidades_disponibles`, `unidad_medida`, `precio`, `estado`) VALUES
('002', 'Producto 5', '2021-04-05', '2021-11-05', 4, 8769, 5, 10000, 1),
('1', 'Arroz Chino', '2020-08-20', '2020-09-03', 2, 560, 5, 10500, 1),
('2', 'Pulpo asadoss', '2020-09-23', '2020-09-30', 2, 3909, 5, 100000, 1),
('39895', 'Producto1', '2021-02-22', '2021-11-02', 4, 7846, 6, 15000, 0),
('4395906', 'producto bb', '2021-04-09', '2023-11-27', 3, 8889, 4, 10000, 0),
('497945', 'producto cc', '2021-04-09', '2022-12-10', 1, 7888, 2, 10000, 1),
('87878787', 'Pasta con albondigas', '2021-01-02', '2021-01-30', 3, 7798, 5, 70000, 0),
('9408058906', 'producto aa AA', '2021-04-09', '2024-06-18', 4, 989, 4, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblproveedor`
--

CREATE TABLE `tblproveedor` (
  `nit` varchar(15) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(60) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `correo` varchar(70) NOT NULL,
  `municipio` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblproveedor`
--

INSERT INTO `tblproveedor` (`nit`, `nombre`, `apellido`, `direccion`, `telefono`, `correo`, `municipio`) VALUES
('048098469486', 'Jorge Eliecer ', 'Gaitan', 'carrera 5 # 27-4', '6080850806', 'jorger@gmail.com', '102'),
('09438504805', 'prroveedor', 'proveedoaprellido', 'Avenida 14 # 49B-15', '90385094', 'prov4@hotiam.com', '110'),
('09480485', 'Proveedor cc', 'cuatro', 'Carrera 89 vereda Payuco', '938085', 'prov4@hotmial.com', '719'),
('390803805', 'proveedornono', 'tresss', 'Calle 49 # 30-15 A', '038038540', 'prov3@hotmial.com', '719'),
('4850498059', 'proveedor 16', 'dieskddd', 'CARRETERA A LOMA ALTA S/N.', '0493805', 'Alej23@gmail.com', '664'),
('5869533', 'proveedor6', 'proveedorseis', 'CARRETERA A LOMA ALTA S/N.', '0850458', 'sfhs@ckjd.com', '225'),
('90348504', 'proveedor3', 'pr3333', 'calle1barriaSamanta#45-6', '3904750496', 'sfhs@ckjd.com', '647'),
('98509485045', 'Proveedor ', 'dos', 'Carrera 30 # 27-45 B', '940850980', 'proveedor3@gmial.com', '110');

-- --------------------------------------------------------

--
-- Table structure for table `tblreceta`
--

CREATE TABLE `tblreceta` (
  `codigo` int(3) NOT NULL,
  `fecha` date NOT NULL,
  `producto` varchar(15) NOT NULL,
  `usuario` varchar(12) NOT NULL,
  `descripcion` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblreceta`
--

INSERT INTO `tblreceta` (`codigo`, `fecha`, `producto`, `usuario`, `descripcion`) VALUES
(5, '2021-03-11', '1', '1001651969', '                        Soda y frutiño                        ooooo'),
(6, '2021-04-07', '2', '40860586056', 'lkefhlsdfh'),
(7, '2021-04-13', '002', '1001651967', 'skdhsldfkhdlf'),
(8, '2021-04-13', '9408058906', '1001651969', 'dsfjdlfhMAYCOLSJSJS'),
(9, '2021-04-13', '2', '1001651968', 'llzjsdlsdhfl'),
(14, '2021-04-14', '497945', '1001651968', 'skjdlsjfdl');

-- --------------------------------------------------------

--
-- Table structure for table `tbltipousuario`
--

CREATE TABLE `tbltipousuario` (
  `id` int(2) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbltipousuario`
--

INSERT INTO `tbltipousuario` (`id`, `nombre`) VALUES
(1, 'SuperAdministrador'),
(2, 'Administrador'),
(3, 'Operario');

-- --------------------------------------------------------

--
-- Table structure for table `tblunidadmedida`
--

CREATE TABLE `tblunidadmedida` (
  `codigo` int(2) NOT NULL,
  `nombre` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblunidadmedida`
--

INSERT INTO `tblunidadmedida` (`codigo`, `nombre`) VALUES
(1, 'Medio Litro'),
(2, 'Litro'),
(3, 'Galón'),
(4, 'Libra'),
(5, 'Kilogramo'),
(6, 'Paca');

-- --------------------------------------------------------

--
-- Table structure for table `tblusuario`
--

CREATE TABLE `tblusuario` (
  `documento` varchar(12) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `correo` varchar(60) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `clave` varchar(10) NOT NULL,
  `tipo_usuario` int(2) DEFAULT NULL,
  `municipio` varchar(6) NOT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblusuario`
--

INSERT INTO `tblusuario` (`documento`, `nombres`, `apellidos`, `correo`, `telefono`, `direccion`, `clave`, `tipo_usuario`, `municipio`, `estado`) VALUES
('1001651967', 'uusuario2555', 'dos', 'Carolina@gmail.com', '55267384', 'Calle 35 # 27-41', '111', 1, '542', 0),
('1001651968', 'usuario3', 'tres', 'usuario3@gmail.com', '3196200585', 'calle 35 # 29-40', '111', 2, '109', 1),
('1001651969', 'usuario5', 'cinco', 'usuario4@gmail.com', '3137155567', 'Calle 85 # 49-70', '111', 3, '749', 0),
('40860586056', 'usuario4.4.4', 'apellido4', 'sfhs@ckjd.com', '045860586', 'nñueva#22-45', '111', 2, '11', NULL),
('43574966654', 'usuarioU', 'userAp', 'Alej23@gmail.com', '4999677', 'calle1barriaSamanta#45-6', '111', NULL, '110', NULL),
('4586058', 'usuario', 'uno', 'usuario1@hto.cao', '69487979', 'CARRETERA A LOMA ALTA S/N.', '111', NULL, '539', NULL),
('490680598605', 'usuarioNombre2', 'usuarioApellido2', 'Josefina@gmail.com', '0830458945', 'CARRETERA A LOMA ALTA S/N.ddd', '111', NULL, '389', NULL),
('9486094586', 'usuarioNombre', 'usuarioApellido', 'Josefina@gmail.com', '0830458', 'CARRETERA A LOMA ALTA S/N.', '111', NULL, '384', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cliente`
--

CREATE TABLE `tbl_cliente` (
  `documento` varchar(12) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `correo` varchar(70) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `municipio` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_cliente`
--

INSERT INTO `tbl_cliente` (`documento`, `nombres`, `apellidos`, `telefono`, `correo`, `direccion`, `municipio`) VALUES
('084504850', 'cliente8.8.8', 'ocho', '948674956', 'cliente8@kd.co', 'calle1barriaSamanta#45-6', '534'),
('25096869', 'cliente10', 'diez', '2435234', 'qewr@dasf', 'calle1barriaSamanta#45-6', '753'),
('9308986', 'cliente11', 'once', '480486789', 'cliente1@hotmial.com', 'CALLE AGUSTIN LARA NO. 69-B', '452'),
('94795', 'ciente5', 'cinco', '4o985095', 'hodfj@cohd.com', 'BLVD. BENITO JUAREZ S / N', '1003'),
('948508054', 'cliente4', 'cuetro', '904380598046', 'cient3@hfo.com', 'AV. INDEPENDENCIA NO. 1282-A', '1008'),
('98508058', 'cliente3', 'tres', '30823683', 'cliente3@hoc.om', 'CALLE MATAMOROS NO. 310', '1011');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcategoria`
--
ALTER TABLE `tblcategoria`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `tbldepartamento`
--
ALTER TABLE `tbldepartamento`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `tblfacturacompra`
--
ALTER TABLE `tblfacturacompra`
  ADD PRIMARY KEY (`numero`),
  ADD KEY `fk_tbl_facturacompra_tbl_formapago1_idx` (`forma_pago`),
  ADD KEY `fk_tbl_facturacompra_tbl_proveedor1_idx` (`proveedor`);

--
-- Indexes for table `tblfacturacompramateriaprima`
--
ALTER TABLE `tblfacturacompramateriaprima`
  ADD PRIMARY KEY (`materia_prima`,`factura_compra`),
  ADD KEY `FK_compraD` (`factura_compra`);

--
-- Indexes for table `tblfacturaventa`
--
ALTER TABLE `tblfacturaventa`
  ADD PRIMARY KEY (`numero`);

--
-- Indexes for table `tblfacturventaproducto`
--
ALTER TABLE `tblfacturventaproducto`
  ADD PRIMARY KEY (`factura_venta`,`producto`);

--
-- Indexes for table `tblformapago`
--
ALTER TABLE `tblformapago`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `tblmateriaprima`
--
ALTER TABLE `tblmateriaprima`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `fk_tbl_materiaprima_tblunidadmedida1_idx` (`unidad_medida`);

--
-- Indexes for table `tblmateriaprimareceta`
--
ALTER TABLE `tblmateriaprimareceta`
  ADD PRIMARY KEY (`materia_prima`,`receta`),
  ADD KEY `fk_tbl_materiaprima_receta_tbl_receta1_idx` (`receta`);

--
-- Indexes for table `tblmunicipio`
--
ALTER TABLE `tblmunicipio`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `fk_tbl_municipio_tbl_departamentos1_idx` (`tbl_departamentos_codigo`);

--
-- Indexes for table `tblproduccion`
--
ALTER TABLE `tblproduccion`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `tblproduccionreceta`
--
ALTER TABLE `tblproduccionreceta`
  ADD PRIMARY KEY (`cod_produccion`,`cod_receta`),
  ADD KEY `fk_tblproduccionreceta_tblreceta1_idx` (`cod_receta`),
  ADD KEY `fk_tblproduccionreceta_tblproduccion1_idx` (`cod_produccion`);

--
-- Indexes for table `tblproductoterminado`
--
ALTER TABLE `tblproductoterminado`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `fk_tblproducto_tblcategoria1_idx` (`categoria`),
  ADD KEY `fk_tblproducto_tblunidadmedida1_idx` (`unidad_medida`);

--
-- Indexes for table `tblproveedor`
--
ALTER TABLE `tblproveedor`
  ADD PRIMARY KEY (`nit`),
  ADD KEY `fk_tbl_proveedor_tbl_municipio1_idx` (`municipio`);

--
-- Indexes for table `tblreceta`
--
ALTER TABLE `tblreceta`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `fk_tbl_ajusteinventario_tbl_usuarios1_idx` (`usuario`),
  ADD KEY `fk_tbl_receta_tbl_productoterminado1_idx` (`producto`);

--
-- Indexes for table `tbltipousuario`
--
ALTER TABLE `tbltipousuario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblunidadmedida`
--
ALTER TABLE `tblunidadmedida`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `tblusuario`
--
ALTER TABLE `tblusuario`
  ADD PRIMARY KEY (`documento`),
  ADD KEY `fk_tbl_usuarios_tbl_municipio1_idx` (`municipio`),
  ADD KEY `fk_tbl_usuarios_tbl_tipo_usuario1_idx` (`tipo_usuario`);

--
-- Indexes for table `tbl_cliente`
--
ALTER TABLE `tbl_cliente`
  ADD PRIMARY KEY (`documento`),
  ADD KEY `fk_tbl_clientes_tbl_municipio1_idx` (`municipio`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblfacturacompra`
--
ALTER TABLE `tblfacturacompra`
  MODIFY `numero` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tblfacturaventa`
--
ALTER TABLE `tblfacturaventa`
  MODIFY `numero` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `tblfacturventaproducto`
--
ALTER TABLE `tblfacturventaproducto`
  MODIFY `factura_venta` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `tblformapago`
--
ALTER TABLE `tblformapago`
  MODIFY `codigo` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblproduccion`
--
ALTER TABLE `tblproduccion`
  MODIFY `codigo` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblreceta`
--
ALTER TABLE `tblreceta`
  MODIFY `codigo` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tblunidadmedida`
--
ALTER TABLE `tblunidadmedida`
  MODIFY `codigo` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblfacturacompra`
--
ALTER TABLE `tblfacturacompra`
  ADD CONSTRAINT `fk_tbl_facturacompra_tbl_formapago1` FOREIGN KEY (`forma_pago`) REFERENCES `tblformapago` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_facturacompra_tbl_proveedor1` FOREIGN KEY (`proveedor`) REFERENCES `tblproveedor` (`nit`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tblfacturacompramateriaprima`
--
ALTER TABLE `tblfacturacompramateriaprima`
  ADD CONSTRAINT `FK_compraD` FOREIGN KEY (`factura_compra`) REFERENCES `tblfacturacompra` (`numero`),
  ADD CONSTRAINT `fk_compra` FOREIGN KEY (`factura_compra`) REFERENCES `tblfacturacompra` (`numero`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_materia` FOREIGN KEY (`materia_prima`) REFERENCES `tblmateriaprima` (`codigo`),
  ADD CONSTRAINT `fk_tbl_facturacompra_materiaprima_tbl_facturacompra1` FOREIGN KEY (`factura_compra`) REFERENCES `tblfacturacompra` (`numero`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_facturacompra_materiaprima_tbl_materiaprima1` FOREIGN KEY (`materia_prima`) REFERENCES `tblmateriaprima` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tblfacturventaproducto`
--
ALTER TABLE `tblfacturventaproducto`
  ADD CONSTRAINT `fk_tblventacompuesta_tblventa` FOREIGN KEY (`factura_venta`) REFERENCES `tblfacturaventa` (`numero`);

--
-- Constraints for table `tblmateriaprima`
--
ALTER TABLE `tblmateriaprima`
  ADD CONSTRAINT `fk_tbl_materiaprima_tblunidadmedida1` FOREIGN KEY (`unidad_medida`) REFERENCES `tblunidadmedida` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tblmateriaprimareceta`
--
ALTER TABLE `tblmateriaprimareceta`
  ADD CONSTRAINT `fk_tbl_materiaprima_receta_tbl_receta1` FOREIGN KEY (`receta`) REFERENCES `tblreceta` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tblmateriaprima_receta_tbl_materiaprima1` FOREIGN KEY (`materia_prima`) REFERENCES `tblmateriaprima` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tblmunicipio`
--
ALTER TABLE `tblmunicipio`
  ADD CONSTRAINT `fk_tbl_municipio_tbl_departamentos1` FOREIGN KEY (`tbl_departamentos_codigo`) REFERENCES `tbldepartamento` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tblproduccionreceta`
--
ALTER TABLE `tblproduccionreceta`
  ADD CONSTRAINT `fk_tblproduccionreceta_tblproduccion1` FOREIGN KEY (`cod_produccion`) REFERENCES `tblproduccion` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tblproduccionreceta_tblreceta1` FOREIGN KEY (`cod_receta`) REFERENCES `tblreceta` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tblproductoterminado`
--
ALTER TABLE `tblproductoterminado`
  ADD CONSTRAINT `fk_tblproducto_tblcategoria1` FOREIGN KEY (`categoria`) REFERENCES `tblcategoria` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tblproducto_tblunidadmedida1` FOREIGN KEY (`unidad_medida`) REFERENCES `tblunidadmedida` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tblproveedor`
--
ALTER TABLE `tblproveedor`
  ADD CONSTRAINT `fk_tbl_proveedor_tbl_municipio1` FOREIGN KEY (`municipio`) REFERENCES `tblmunicipio` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tblreceta`
--
ALTER TABLE `tblreceta`
  ADD CONSTRAINT `fk_tbl_ajusteinventario_tbl_usuarios10` FOREIGN KEY (`usuario`) REFERENCES `tblusuario` (`documento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_receta_tbl_productoterminado1` FOREIGN KEY (`producto`) REFERENCES `tblproductoterminado` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tblusuario`
--
ALTER TABLE `tblusuario`
  ADD CONSTRAINT `fk_tbl_usuarios_tbl_municipio1` FOREIGN KEY (`municipio`) REFERENCES `tblmunicipio` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tbl_usuarios_tbl_tipo_usuario1` FOREIGN KEY (`tipo_usuario`) REFERENCES `tbltipousuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_cliente`
--
ALTER TABLE `tbl_cliente`
  ADD CONSTRAINT `fk_tbl_clientes_tbl_municipio1` FOREIGN KEY (`municipio`) REFERENCES `tblmunicipio` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
