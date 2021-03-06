/****** Object:  Table [dbo].[ISAL_Accion]    Script Date: 11/4/2021 08:57:18 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ISAL_Accion](
	[id_accion] [int] IDENTITY(1,1) NOT NULL,
	[descripcion] [varchar](100) NOT NULL,
	[alias] [varchar](100) NOT NULL,
	[activo] [bit] NOT NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id_accion] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ISAL_Bancos]    Script Date: 11/4/2021 08:57:18 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ISAL_Bancos](
	[id_banco] [int] IDENTITY(1,1) NOT NULL,
	[descripcion] [nvarchar](200) NOT NULL,
	[codigo] [nvarchar](5) NOT NULL,
	[activo] [bit] NOT NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id_banco] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[ISAL_Conceptos]    Script Date: 11/4/2021 08:57:18 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ISAL_Conceptos](
	[id_concepto] [int] IDENTITY(1,1) NOT NULL,
	[descripcion] [nvarchar](200) NOT NULL,
	[letra] [char](1) NOT NULL,
	[texto] [text] NULL,
	[activo] [bit] NOT NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id_concepto] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[ISAL_CorreosProcesados]    Script Date: 11/4/2021 08:57:18 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ISAL_CorreosProcesados](
	[id_cp] [numeric](18, 0) IDENTITY(1,1) NOT NULL,
	[id_usuario] [int] NOT NULL,
	[fecha] [date] NOT NULL,
	[TipoFac] [varchar](1) NOT NULL,
	[NumeroD] [varchar](20) NOT NULL,
	[correo] [varchar](200) NOT NULL,
	[CodClie] [varchar](15) NOT NULL,
	[observacion] [nvarchar](200) NULL,
	[CodVend] [varchar](10) NULL,
PRIMARY KEY CLUSTERED 
(
	[id_cp] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ISAL_CuentasBancarias]    Script Date: 11/4/2021 08:57:18 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ISAL_CuentasBancarias](
	[id_cb] [int] IDENTITY(1,1) NOT NULL,
	[nro_cuenta] [nvarchar](20) NOT NULL,
	[tipo_cuenta] [nvarchar](20) NOT NULL,
	[id_concepto] [int] NOT NULL,
	[id_banco] [int] NOT NULL,
	[CodVend] [nvarchar](20) NOT NULL,
	[activo] [bit] NOT NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id_cb] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[ISAL_Pregunta]    Script Date: 11/4/2021 08:57:18 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ISAL_Pregunta](
	[id_pregunta] [int] IDENTITY(1,1) NOT NULL,
	[descripcion] [varchar](100) NOT NULL,
	[activo] [bit] NOT NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id_pregunta] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ISAL_Rol]    Script Date: 11/4/2021 08:57:18 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ISAL_Rol](
	[id_rol] [int] IDENTITY(1,1) NOT NULL,
	[descripcion] [varchar](100) NOT NULL,
	[activo] [bit] NOT NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id_rol] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
/****** Object:  Table [dbo].[ISAL_RolAccion]    Script Date: 11/4/2021 08:57:18 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ISAL_RolAccion](
	[id_rol] [int] NOT NULL,
	[id_accion] [int] NOT NULL,
	[modifica] [bit] NOT NULL DEFAULT ((1)),
PRIMARY KEY CLUSTERED 
(
	[id_rol] ASC,
	[id_accion] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[ISAL_Usuario]    Script Date: 11/4/2021 08:57:18 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[ISAL_Usuario](
	[id_usuario] [int] IDENTITY(1,1) NOT NULL,
	[usuario] [varchar](20) NOT NULL,
	[correo] [varchar](100) NOT NULL,
	[cedula] [varchar](15) NOT NULL,
	[clave] [varchar](100) NOT NULL,
	[nombre] [nvarchar](100) NOT NULL,
	[apellido] [varchar](100) NOT NULL,
	[sexo] [char](1) NOT NULL DEFAULT ('M'),
	[respuesta_seguridad] [varchar](1000) NULL,
	[fecha_registro] [datetime] NOT NULL DEFAULT (getdate()),
	[telefono] [varchar](20) NULL,
	[activo] [bit] NOT NULL DEFAULT ((1)),
	[id_rol] [int] NOT NULL,
	[id_pregunta] [int] NULL,
	[CodVend] [nvarchar](10) NULL,
PRIMARY KEY CLUSTERED 
(
	[id_usuario] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [dbo].[ISAL_Accion] ON 

INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (1, N'accion-index', N'Accion Inicio', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (2, N'accion-update', N'Accion Actualizar', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (3, N'accion-view', N'Accion Vista', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (4, N'accion-delete', N'Accion Desactivar', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (5, N'accion-create', N'Accion Crear', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (6, N'rol-index', N'Rol Inicio', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (7, N'rol-update', N'Rol Actualizar', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (8, N'rol-view', N'Rol Vista', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (9, N'rol-delete', N'Rol Desactivar', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (10, N'rol-create', N'Rol Crear', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (11, N'rol-accion-index', N'RolAccion Inicio', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (12, N'rol-accion-update', N'RolAccion Actualizar', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (13, N'rol-accion-view', N'RolAccion Vista', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (14, N'rol-accion-delete', N'RolAccion Desactivar', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (15, N'rol-accion-create', N'RolAccion Crear', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (16, N'usuario-index', N'Usuario Inicio', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (17, N'usuario-update', N'Usuario Actualizar', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (18, N'usuario-view', N'Usuario Vista', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (19, N'usuario-delete', N'Usuario Desactivar', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (20, N'usuario-create', N'Usuario Crear', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (21, N'pregunta-index', N'Pregunta Inicio', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (22, N'pregunta-update', N'Pregunta Actualizar', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (23, N'pregunta-view', N'Pregunta Vista', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (24, N'pregunta-delete', N'Pregunta Desactivar', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (25, N'pregunta-create', N'Pregunta Crear', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (26, N'ubicacion-index', N'Ubicación Inicio', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (27, N'ubicacion-update', N'Ubicación Actualizar', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (28, N'ubicacion-view', N'Ubicación Vista', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (29, N'ubicacion-delete', N'Ubicación Desactivar', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (30, N'ubicacion-create', N'Ubicación Crear', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (31, N'bancos-index', N'Bancos Inicio', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (32, N'bancos-create', N'Bancos Crear', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (33, N'bancos-update', N'Bancos Actualizar', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (34, N'bancos-view', N'Bancos Vista', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (35, N'bancos-delete', N'Bancos Desactivar', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (36, N'conceptos-index', N'Conceptos Inicio', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (37, N'conceptos-create', N'Conceptos Crear', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (38, N'conceptos-update', N'Conceptos Actualizar', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (39, N'conceptos-view', N'Conceptos Vista', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (40, N'conceptos-delete', N'Conceptos Desactivar', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (41, N'cuentas-bancarias-index', N'Cuentas Bancarias Inicio', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (42, N'cuentas-bancarias-create', N'Cuentas Bancarias Crear', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (43, N'cuentas-bancarias-update', N'Cuentas Bancarias Actualizar', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (44, N'cuentas-bancarias-view', N'Cuentas Bancarias Vista', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (45, N'cuentas-bancarias-delete', N'Cuentas Bancarias Desactivar', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (46, N'site-reporte-enviados', N'Avisos de cobro enviados', 1)
INSERT [dbo].[ISAL_Accion] ([id_accion], [descripcion], [alias], [activo]) VALUES (47, N'site-reporte-correos', N'Clientes sin correo', 1)
SET IDENTITY_INSERT [dbo].[ISAL_Accion] OFF
SET IDENTITY_INSERT [dbo].[ISAL_Bancos] ON 

INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (1, N'Banco de Venezuela S.A.C.A. Banco Universal', N'0102', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (2, N'Venezolano de Crédito, S.A. Banco Universal', N'0104', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (3, N'Banco Mercantil, C.A. Banco Universal', N'0105', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (4, N'Banco Provincial, S.A. Banco Universal', N'0108', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (5, N'Bancaribe C.A. Banco Universal', N'0114', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (6, N'Banco Occidental de Descuento, Banco Universal C.A', N'0116', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (7, N'Banco Caroní C.A. Banco Universal', N'0128', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (8, N'Banesco Banco Universal S.A.C.A.', N'0134', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (9, N'Banco Sofitasa, Banco Universal', N'0137', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (10, N'Banco Plaza, Banco Universal', N'0138', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (11, N'Banco de la Gente Emprendedora C.A', N'0146', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (12, N'BFC Banco Fondo Común C.A. Banco Universal', N'0151', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (13, N'100% Banco, Banco Universal C.A.', N'0156', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (14, N'DelSur Banco Universal C.A.', N'0157', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (15, N'Banco del Tesoro, C.A. Banco Universal', N'0163', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (16, N'Banco Agrícola de Venezuela, C.A. Banco Universal', N'0166', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (17, N'Bancrecer, S.A. Banco Microfinanciero', N'0168', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (18, N'Mi Banco, Banco Microfinanciero C.A.', N'0169', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (19, N'Banco Activo, Banco Universal', N'0171', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (20, N'Bancamica, Banco Microfinanciero C.A.', N'0172', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (21, N'Banco Internacional de Desarrollo, C.A. Banco Universal', N'0173', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (22, N'Banplus Banco Universal, C.A', N'0174', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (23, N'Banco Bicentenario del Pueblo de la Clase Obrera, Mujer y Comunas B.U.', N'0175', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (24, N'Novo Banco, S.A. Sucursal Venezuela Banco Universal', N'0176', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (25, N'Banco de la Fuerza Armada Nacional Bolivariana, B.U.', N'0177', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (26, N'Citibank N.A.', N'0190', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (27, N'Banco Nacional de Crédito, C.A. Banco Universal', N'0191', 1)
INSERT [dbo].[ISAL_Bancos] ([id_banco], [descripcion], [codigo], [activo]) VALUES (28, N'Instituto Municipal de Crédito Popular', N'0601', 1)
SET IDENTITY_INSERT [dbo].[ISAL_Bancos] OFF
SET IDENTITY_INSERT [dbo].[ISAL_Conceptos] ON 

INSERT [dbo].[ISAL_Conceptos] ([id_concepto], [descripcion], [letra], [texto], [activo]) VALUES (1, N'FACTURA', 'A', '', 1)
INSERT [dbo].[ISAL_Conceptos] ([id_concepto], [descripcion], [letra], [texto], [activo]) VALUES (2, N'DEV. DE FACTURA', 'B', '', 1)
SET IDENTITY_INSERT [dbo].[ISAL_Conceptos] OFF

SET IDENTITY_INSERT [dbo].[ISAL_Pregunta] ON 

INSERT [dbo].[ISAL_Pregunta] ([id_pregunta], [descripcion], [activo]) VALUES (1, N'Lugar de Nacimiento', 1)
INSERT [dbo].[ISAL_Pregunta] ([id_pregunta], [descripcion], [activo]) VALUES (2, N'Segundo nombre de su Padre', 1)
INSERT [dbo].[ISAL_Pregunta] ([id_pregunta], [descripcion], [activo]) VALUES (3, N'Segundo nombre de su Madre', 1)
INSERT [dbo].[ISAL_Pregunta] ([id_pregunta], [descripcion], [activo]) VALUES (4, N'Héroe de infancia', 1)
INSERT [dbo].[ISAL_Pregunta] ([id_pregunta], [descripcion], [activo]) VALUES (5, N'Lugar de Luna de miel', 1)
SET IDENTITY_INSERT [dbo].[ISAL_Pregunta] OFF
SET IDENTITY_INSERT [dbo].[ISAL_Rol] ON 

INSERT [dbo].[ISAL_Rol] ([id_rol], [descripcion], [activo]) VALUES (1, N'En Espera', 1)
INSERT [dbo].[ISAL_Rol] ([id_rol], [descripcion], [activo]) VALUES (2, N'Usuario', 1)
INSERT [dbo].[ISAL_Rol] ([id_rol], [descripcion], [activo]) VALUES (3, N'Administrador', 1)
SET IDENTITY_INSERT [dbo].[ISAL_Rol] OFF
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 1, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 2, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 3, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 4, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 5, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 6, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 7, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 8, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 9, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 10, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 11, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 12, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 13, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 14, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 15, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 16, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 17, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 18, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 19, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 20, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 21, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 22, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 23, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 24, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 25, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 26, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 27, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 28, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 29, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 30, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 31, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 32, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 33, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 34, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 35, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 36, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 37, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 38, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 39, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 40, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 41, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 42, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 43, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 44, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 45, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 46, 1)
INSERT [dbo].[ISAL_RolAccion] ([id_rol], [id_accion], [modifica]) VALUES (3, 47, 1)
SET IDENTITY_INSERT [dbo].[ISAL_Usuario] ON 

INSERT [dbo].[ISAL_Usuario] ([id_usuario], [usuario], [correo], [cedula], [clave], [nombre], [apellido], [sexo], [respuesta_seguridad], [fecha_registro], [telefono], [activo], [id_rol], [id_pregunta], [CodVend]) VALUES (1, N'001', N'nada@nada.com', N'123456', N'9df3bb42df815f39041a621f7282a475', N'Innova', N'Administrador', N'M', N'CCS', CAST(N'2020-03-29T10:48:03.840' AS DateTime), NULL, 1, 3, 1, N'B')
SET IDENTITY_INSERT [dbo].[ISAL_Usuario] OFF
SET ANSI_PADDING ON

GO
/****** Object:  Index [UQ__ISAL_Usu__9AFF8FC6D06905DF]    Script Date: 11/4/2021 08:57:18 ******/
ALTER TABLE [dbo].[ISAL_Usuario] ADD UNIQUE NONCLUSTERED 
(
	[usuario] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
ALTER TABLE [dbo].[ISAL_CuentasBancarias]  WITH CHECK ADD  CONSTRAINT [pk_cb_banco] FOREIGN KEY([id_banco])
REFERENCES [dbo].[ISAL_Bancos] ([id_banco])
GO
ALTER TABLE [dbo].[ISAL_CuentasBancarias] CHECK CONSTRAINT [pk_cb_banco]
GO
ALTER TABLE [dbo].[ISAL_CuentasBancarias]  WITH CHECK ADD  CONSTRAINT [pk_cb_concepto] FOREIGN KEY([id_concepto])
REFERENCES [dbo].[ISAL_Conceptos] ([id_concepto])
GO
ALTER TABLE [dbo].[ISAL_CuentasBancarias] CHECK CONSTRAINT [pk_cb_concepto]
GO
ALTER TABLE [dbo].[ISAL_RolAccion]  WITH CHECK ADD  CONSTRAINT [fk_alrol_accion01] FOREIGN KEY([id_rol])
REFERENCES [dbo].[ISAL_Rol] ([id_rol])
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[ISAL_RolAccion] CHECK CONSTRAINT [fk_alrol_accion01]
GO
ALTER TABLE [dbo].[ISAL_RolAccion]  WITH CHECK ADD  CONSTRAINT [fk_alrol_accion02] FOREIGN KEY([id_accion])
REFERENCES [dbo].[ISAL_Accion] ([id_accion])
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[ISAL_RolAccion] CHECK CONSTRAINT [fk_alrol_accion02]
GO
ALTER TABLE [dbo].[ISAL_Usuario]  WITH CHECK ADD  CONSTRAINT [fk_alusuario_pregunta] FOREIGN KEY([id_pregunta])
REFERENCES [dbo].[ISAL_Pregunta] ([id_pregunta])
GO
ALTER TABLE [dbo].[ISAL_Usuario] CHECK CONSTRAINT [fk_alusuario_pregunta]
GO
ALTER TABLE [dbo].[ISAL_Usuario]  WITH CHECK ADD  CONSTRAINT [fk_alusuario_rol] FOREIGN KEY([id_rol])
REFERENCES [dbo].[ISAL_Rol] ([id_rol])
GO
ALTER TABLE [dbo].[ISAL_Usuario] CHECK CONSTRAINT [fk_alusuario_rol]
GO
