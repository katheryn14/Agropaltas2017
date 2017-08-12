USE [AGRODB]
GO
/****** Object:  StoredProcedure [dbo].[SP_Rubro_Mnt]    Script Date: 12/08/2017 12:19:38 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROCEDURE [dbo].[SP_Rubro_Mnt]
@peticion int =0 , @idRubro int=0, @Descripcion varchar(70)='',
@Abreviatura varchar(12)='',@Etiqueta varchar(12)=''
as
begin
	DECLARE @cont int, @c int;
	if @peticion=0 ---ver las actividades
		SELECT
			R.idRubro, R.Descripcion as 'Rubro',R.Abreviatura,R.Etiqueta
		FROM Rubro R
		ORDER BY R.idRubro DESC;
	else if @peticion=1 --- inserta Rubro
		BEGIN
			select @cont=COUNT(*) from Rubro where Descripcion=@Descripcion
			if @cont = 0
				begin
					select @c=COUNT(*)+1 from Rubro 
					insert into Rubro(idRubro,Descripcion,Abreviatura,Etiqueta)
						values(@c,@Descripcion,@Abreviatura,@Etiqueta)
					select 1 as 'respuesta'
				end
			else
				select 'Ya existe un rubro con el mismo nombre' as 'respuesta'
		END
	else if @peticion=2---update actividad
		BEGIN
			select @cont=COUNT(*) from Rubro
				where idRubro != @idRubro and (Descripcion=@Descripcion or Abreviatura=@Abreviatura)
			if @cont = 0
				begin
					UPDATE Rubro set Descripcion=@Descripcion,
					Abreviatura=@Abreviatura,Etiqueta=@Etiqueta where idRubro=@idRubro
					select 1 as 'respuesta'
				end
			else
				select 'Ya existe un rubro con el mismo nombre' as 'respuesta'
		END
	else if @peticion=3---eliminar rubro
		begin
			--delete from Actividad where idActividad=@idActividad
			select 1 as 'respuesta'
		end
	else if @peticion=4---mosrtrar uno
		SELECT
			R.idRubro,R.Descripcion as 'Rubro',R.Abreviatura,R.Etiqueta
		FROM Rubro R
		where R.idRubro=@idRubro
end
go


USE [AGRODB]
GO
/****** Object:  StoredProcedure [dbo].[SP_Labor_Mnt]    Script Date: 12/08/2017 12:19:35 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER PROCEDURE [dbo].[SP_Labor_Mnt]
@peticion int =0 , @idLabor char(18)='', @idActividad int=0,@idRubro int=0,
@Descripcion varchar(50)='', @UniMedida char(18)='',@CodigoERP char(18)=''
as
BEGIN
	IF @peticion=0
		SELECT  L.idLabor,L.idActividad,R.idRubro,
				A.Descripcion as 'actividad',L.Descripcion as 'labor',
				R.Descripcion as 'rubro',
				L.UniMedida as 'medida',L.CodigoERP as 'codigoERP'
			FROM Labor L
			INNER JOIN Actividad A ON A.idActividad=L.idActividad
			INNER JOIN Rubro R ON R.idRubro=A.idActividad
			ORDER BY L.idActividad DESC
	
	ELSE IF @peticion = 5
		select idActividad,Descripcion as 'actividad',idRubro 
			from Actividad
			where idRubro=@idRubro
	ELSE IF @peticion=6
		select idRubro,Descripcion as 'rubro' from Rubro
		
END
go

USE [AGRODB]
GO
/****** Object:  StoredProcedure [dbo].[SP_Actividad_Mnt]    Script Date: 12/08/2017 12:19:29 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[SP_Actividad_Mnt]
@peticion int =0 , @idActividad int=0, @Descripcion varchar(50)='',@idRubro int=0
as
begin
	DECLARE @cont int, @c int;
	if @peticion=0 ---ver las actividades
		SELECT
			A.idActividad,A.Descripcion as 'Actividad',R.idRubro,R.Abreviatura,R.Descripcion as 'Rubro'
		FROM Actividad A 
		INNER JOIN Rubro R on R.idRubro=A.idRubro
		ORDER BY A.idActividad DESC;
	else if @peticion=1 --- inserta Actividad
		BEGIN
			select @cont=COUNT(*) from Actividad where Descripcion=@Descripcion and idRubro=@idRubro
			if @cont = 0
				begin
					select @c=COUNT(*)+1 from Actividad 
					insert into Actividad(idActividad,idRubro,Descripcion)
						values(@c,@idRubro,@Descripcion)
					select 1 as 'respuesta'
				end
			else
				select 'Ya existe una actividad con el mismo nombre' as 'respuesta'
		END
	else if @peticion=2---update actividad
		BEGIN
			select @cont=COUNT(*) from Actividad 
				where idActividad != @idActividad and Descripcion=@Descripcion and idRubro=@idRubro
			if @cont = 0
				begin
					UPDATE Actividad set Descripcion=@Descripcion,
					idRubro=@idRubro where idActividad=@idActividad
					select 1 as 'respuesta'
				end
			else
				select 'Ya existe una actividad con el mismo nombre' as 'respuesta'
		END
	else if @peticion=3---eliminar grupo
		begin
			delete from Actividad where idActividad=@idActividad
			select 1 as 'respuesta'
		end
	else if @peticion=4---mosrtrar uno
		SELECT
			A.idActividad,A.Descripcion as 'Actividad',R.idRubro,R.Abreviatura,R.Descripcion as 'Rubro'
		FROM Actividad A 
		INNER JOIN Rubro R on R.idRubro=A.idRubro
		where A.idActividad=@idActividad
	else if @peticion=5
		SELECT idRubro,Descripcion as 'rubro' from Rubro
end
go