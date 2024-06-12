drop database if exists proyecto3;
create database proyecto3;
use proyecto3;

create table videojuegos(
	id int auto_increment primary key,
    titulo varchar(45) unique,
    portada varchar(1000),
    cantidad int default 0
);
create table generos(
	id int auto_increment,
    id_video int,
    genero varchar(25),
    primary key (id,id_video),
    foreign key (id_video) references videojuegos(id) on update cascade on delete cascade
);
create table plataformas(
	id int auto_increment primary key,
    nombre varchar(45) unique,
    cantidad int default 0,
    precio decimal(10,2) unsigned default 0,
    imagen varchar(1000)
);
create table tiene(
	id_video int,
    id_plat int,
    precio decimal(10,2) unsigned default 0,
    primary key (id_video,id_plat),
    foreign key (id_video) references videojuegos(id) on update cascade on delete cascade,
    foreign key (id_plat) references plataformas(id) on update cascade on delete cascade
);
create table componentes(
	id int auto_increment primary key,
    nombre varchar(45),
    tipo enum('GPU','CPU','Alimentacion','Almacenamiento','RAM','Mando','Teclado','Raton'),
    precio decimal(10,2) default 0,
    cantidad int default 0,
    imagen varchar(1000)
);
create table usuarios(
	id int auto_increment primary key,
    nombre varchar(25),
    email varchar(45) unique,
    pass varchar(45),
    tipo enum("cliente","empleado","admin")
);
create table compra_video(
	id_video int,
    id_plat int,
    id_usu int,
    fecha_compra datetime default now(),
    cantidad int unsigned,
    primary key(id_video,id_usu,fecha_compra),
    foreign key(id_video) references videojuegos(id) on update cascade on delete cascade,
    foreign key(id_usu) references usuarios(id) on update cascade on delete cascade
);
select * from compra_video;
create table compra_compo(
	id_usu int,
    id_compo int,
    fecha_compra datetime default now(),
    cantidad int unsigned,
    primary key (id_usu,id_compo,fecha_compra),
    foreign key (id_usu) references usuarios(id) on update cascade on delete cascade,
    foreign key (id_compo) references componentes(id) on update cascade on delete cascade
);
select * from compra_compo;
create table compra_equipo(
	id_usu int,
    id_plat int,
    fecha_compra datetime default now(),
    cantidad int unsigned,
    primary key (id_usu,id_plat,fecha_compra),
    foreign key (id_usu) references usuarios(id) on update cascade on delete cascade,
    foreign key (id_plat) references plataformas(id) on update cascade on delete cascade
);

-- Insertar registros en la tabla videojuegos
INSERT INTO videojuegos (titulo, portada, cantidad) VALUES
('The Legend of Zelda: Breath of the Wild', 'https://m.media-amazon.com/images/I/81U-DS7w+CL.jpg', 10),
('Super Mario Odyssey', 'https://m.media-amazon.com/images/I/81drkVN7GRL._AC_UF1000,1000_QL80_.jpg', 15),
('Minecraft', 'https://image.api.playstation.com/vulcan/img/cfn/11307x4B5WLoVoIUtdewG4uJ_YuDRTwBxQy0qP8ylgazLLc01PBxbsFG1pGOWmqhZsxnNkrU3GXbdXIowBAstzlrhtQ4LCI4.png', 20),
('Fortnite', 'https://cdn1.epicgames.com/offer/fn/Blade_2560x1440_2560x1440-95718a8046a942675a0bc4d27560e2bb', 30),
('Animal Crossing: New Horizons', 'https://m.media-amazon.com/images/I/71sT6IkxThL.jpg', 25);

-- Insertar registros en la tabla generos
INSERT INTO generos (id_video, genero) VALUES
(1, 'Aventura'),
(1, 'Acción'),
(2, 'Plataformas'),
(3, 'Sandbox'),
(4, 'Battle Royale'),
(5, 'Simulación');

-- Insertar registros en la tabla plataformas
INSERT INTO plataformas (nombre, cantidad, precio, imagen) VALUES
('Nintendo Switch', 50, 299.99, 'https://m.media-amazon.com/images/I/714mELI+eGL.jpg'),
('PlayStation 4', 40, 399.99, 'https://m.media-amazon.com/images/I/71iKdXqlx2L._AC_UF894,1000_QL80_.jpg'),
('Xbox One', 35, 349.99, 'https://m.media-amazon.com/images/I/510LV3K6PnL._AC_UF894,1000_QL80_.jpg'),
('PC', 100, 599.99, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQbzYwhf-QjdjfZIUHn0tId1EL1TpXD6VcAYZNISVUIZw&s'),
('Mobile', 200, 0.00, 'https://m.media-amazon.com/images/I/71JTN8O8KnL._AC_UF894,1000_QL80_.jpg');

-- Insertar registros en la tabla tiene
INSERT INTO tiene (id_video, id_plat, precio) VALUES
(1, 1, 59.99),
(2, 1, 59.99),
(3, 4, 26.95),
(3, 5, 0.00),
(3, 1, 59.99);

-- Insertar registros en la tabla componentes
INSERT INTO componentes (nombre, tipo, precio, cantidad, imagen) VALUES
('Procesador Intel Core i7', 'CPU', 320.00, 15, 'https://www.coolmod.com/images/product/large/PROD-021839_1.jpg'),
('Tarjeta Gráfica NVIDIA RTX 3080', 'GPU', 699.99, 10, 'https://thumb.pccomponentes.com/w-530-530/articles/51/514403/1873-gigabyte-geforce-rtx-3080-gaming-oc-v2-10gb-gddr6x.jpg'),
('Memoria RAM 16GB', 'RAM', 80.00, 25, 'https://www.vsgamers.es/thumbnails/product_gallery_large/uploads/products/g-skill/memoria/trident-z-rgb-ddr4-3000-16gb-cl15/galeria/memoria-gskill-trident-z-rgb-ddr4-3000-pc4-24000-16gb-galeria.jpg'),
('Disco Duro SSD 1TB', 'Almacenamiento', 120.00, 20, 'https://m.media-amazon.com/images/I/5169n4UNj5L._AC_UF894,1000_QL80_.jpg'),
('Fuente de Alimentación 650W', 'Alimentacion', 70.00, 30, 'https://res.cloudinary.com/rsc/image/upload/b_rgb:FFFFFF,c_pad,dpr_2.625,f_auto,h_214,q_auto,w_380/c_pad,h_214,w_380/Y2083900-01?pgw=1');

insert into usuarios (nombre, email, pass, tipo) values
("Jeff","admin@correo",sha1("admin") ,"admin");
insert into usuarios (nombre, email, pass, tipo) values
("Danny","empleado@correo",sha1("empleado"),"empleado");
insert into usuarios (nombre, email, pass, tipo) values
("Cliente","cliente@correo",sha1("cliente"),"cliente");

