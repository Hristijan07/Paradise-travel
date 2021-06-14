drop database if exists travel;
create database travel;
use travel;

/*==============================================================*/
/* Table: BOOKING                                               */
/*==============================================================*/
create table booking  (
   booking_id           INTEGER                         not null AUTO_INCREMENT,
   trip_id              INTEGER                         not null,
   user_id              INTEGER                         not null,
   booking              VARCHAR(255),
   constraint pk_booking primary key (booking_id)
);

/*==============================================================*/
/* Index: BOOK_TRIP_FK                                          */
/*==============================================================*/
create index book_trip_fk on booking (
   trip_id ASC
);

/*==============================================================*/
/* Index: USER_BOOKING_FK                                       */
/*==============================================================*/
create index user_booking_fk on booking (
   user_id ASC
);

/*==============================================================*/
/* Table: CITY                                                  */
/*==============================================================*/
create table city  (
   city_id              INTEGER                         not null AUTO_INCREMENT,
   city_name            CHAR(50),
   img1                 CHAR(50),
   img2                 CHAR(50),
   img3                 CHAR(50),
   img4                 CHAR(50),
   lon                  FLOAT,
   lat                  FLOAT,
   color1               VARCHAR(50),
   color2               VARCHAR(50),
   color3               VARCHAR(50),
   color4               VARCHAR(50),
   constraint pk_city primary key (city_id)
);

/*==============================================================*/
/* Table: RATING                                                */
/*==============================================================*/
create table rating  (
   rating_id            INTEGER                         not null AUTO_INCREMENT,
   city_id              INTEGER                         not null,
   user_id              INTEGER                         not null,
   rating               FLOAT,
   constraint pk_rating primary key (rating_id)
);

/*==============================================================*/
/* Index: CITY_RATING_FK                                        */
/*==============================================================*/
create index city_rating_fk on rating (
   city_id ASC
);

/*==============================================================*/
/* Index: USER_RATING_FK                                        */
/*==============================================================*/
create index user_rating_fk on rating (
   user_id ASC
);

/*==============================================================*/
/* Table: REVIEW                                                */
/*==============================================================*/
create table review  (
   review_id            INTEGER                         not null AUTO_INCREMENT,
   user_id              INTEGER                         not null,
   city_id              INTEGER                         not null,
   review               VARCHAR(300),
   constraint pk_review primary key (review_id)
);

/*==============================================================*/
/* Index: USER_REVIEW_FK                                        */
/*==============================================================*/
create index user_review_fk on review (
   user_id ASC
);

/*==============================================================*/
/* Index: TRPI_REVIEW_FK                                        */
/*==============================================================*/
create index trpi_review_fk on review (
   city_id ASC
);

/*==============================================================*/
/* Table: TRIP                                                  */
/*==============================================================*/
create table trip  (
   trip_id              INTEGER            not null  AUTO_INCREMENT,
   city_id              INTEGER                         not null,
   name                 VARCHAR(255),
   description          VARCHAR(1000),
   price                INTEGER,
   date_to              VARCHAR(20),
   date_from            VARCHAR(20),
   constraint pk_trip primary key (trip_id)
);

/*==============================================================*/
/* Index: TRIP_CITY_FK                                          */
/*==============================================================*/
create index trip_city_fk on trip (
   city_id ASC
);

/*==============================================================*/
/* Table: "USER"                                                */
/*==============================================================*/
create table `user`  (
   user_id              INTEGER                         not null AUTO_INCREMENT,
   user_name            CHAR(30),
   password             VARCHAR(255),
   name                 VARCHAR(50),
   surname              VARCHAR(50),
   role                 INTEGER,
   constraint pk_user primary key (user_id)
);

alter table booking
   add constraint fk_booking_book_trip_trip foreign key (trip_id)
      references trip (trip_id);

alter table booking
   add constraint fk_booking_user_book_user foreign key (user_id)
      references `user` (user_id);

alter table rating
   add constraint fk_rating_city_rati_city foreign key (city_id)
      references city (city_id);

alter table rating
   add constraint fk_rating_user_rati_user foreign key (user_id)
      references `user` (user_id);

alter table review
   add constraint fk_review_trpi_revi_city foreign key (city_id)
      references city (city_id);

alter table review
   add constraint fk_review_user_revi_user foreign key (user_id)
      references `user` (user_id);

alter table trip
   add constraint fk_trip_trip_city_city foreign key (city_id)
      references city (city_id);

ALTER TABLE trip ADD FULLTEXT(name);

/*========================Data===================================*/

INSERT INTO `user` (user_id, user_name, password, name, surname, role) VALUES
(1, 'batman', "$2y$10$3yutXxvGchiLrzG3uKFUBe92yDD0Lzbuh89EMS//5oMATcatWSN2W", 'Bruce', 'Wayne', 1),
(2, 'joeW111', '$2y$10$tQ.j34QJSKvp56ttCHMjr.Hs63Kquk14T/F8HKNws0FVoli8xsKlC', 'Joe', 'Walker', 1),
(3, 'superman007', '$2y$10$8wzSyJ9lAZ0824ytkd4IDemxg75kbSS2JoDUDYsqHsgXrKzw9ylg2', 'Clark', 'Kent', 1),
(4, 'admin', '$2y$10$T3V4qzTcHv4dKQWvk7Av4.44nL0qukrjXGoyGWuKDetuKztbOXRg2', 'Admin', 'Admin', 0);

INSERT INTO city (city_id, city_name, img1, img2, img3, img4, lon, lat, color1, color2, color3, color4) VALUES
(1, 'Bled', '/bled/bled1.jpg', '/bled/bled2.jpg', '/bled/bled3.jpg', '/bled/bled4.jpg', 46.3683, 14.1146, "#ffd5e5", "#ffffdd", "#a0ffe6", "#81f5ff"),
(2, 'Bruges', '/bruges/bruges1.jpg', '/bruges/bruges2.jpg', '/bruges/bruges3.jpg', '/bruges/bruges4.jpg', 51.2093, 3.2247, "#f67280", "#c06c84", "#6c5b7b", "#35477d"),
(3, 'Kyoto', '/kyoto/kyoto1.jpg', '/kyoto/kyoto2.jpg', '/kyoto/kyoto3.jpg', '/kyoto/kyoto4.jpg', 35.0116, 135.7681, "#ffd5e5", "#ffffdd", "#a0ffe6", "#81f5ff"),
(4, 'Ljubjana', '/ljubjana/ljubjana1.jpg', '/ljubjana/ljubjana2.jpg', '/ljubjana/ljubjana3.jpg', '/ljubjana/ljubjana4.jpg', 46.0569, 14.5058, "#f67280", "#c06c84", "#6c5b7b", "#35477d"),
(5, 'Ohrid', '/ohrid/ohrid1.jpg', '/ohrid/ohrid2.jpg', '/ohrid/ohrid3.jpg', '/ohrid/ohrid4.jpg', 41.1231, 20.8016, "#48466d", "#3d84a8", "#46cdcf", "#abedd8"),
(6, 'Svalbard', '/svalbard/svalbard1.jpg', '/svalbard/svalbard2.jpg', '/svalbard/svalbard3.jpeg', '/svalbard/svalbard4.jpg', 78.2232, 15.6267, "#071a52", "#086972", "#17b978", "#a7ff83"),
(7, 'Venice', '/venice/venice1.jpg', '/venice/venice2.jpg', '/venice/venice3.jpg', '/venice/venice4.jpg', 45.4408, 12.3155, "#ffd5e5", "#ffffdd", "#a0ffe6", "#81f5ff");

INSERT INTO trip (trip_id, city_id, name, description, price, date_from, date_to) VALUES
(1, 1, 'Bled', "This Alpine lake with the only island in Slovenia has been a world-renowned paradise for centuries, impressing visitors with its natural beauty, wealth of legend, and special powers to restore well-being. Look out at the lake from a castle on a cliff and visit the island on a traditional “pletna” boat. These boats are operated by standing rowers known as pletnars. On this island, which is the subject of legendary tales, listen to the church bell and ring it yourself. Legend has it that this will make your wishes come true.", 400, "04.05.2022", "12.05.2022"),
(2, 2, 'Bruges', "If you set out to design a fairy-tale medieval town, it would be hard to improve on central Bruges (Brugge in Dutch), one of Europe's best preserved cities. Picturesque cobbled lanes and dreamy canals link photogenic market squares lined with soaring towers, historical churches and lane after lane of old whitewashed almshouses. For many the secret is already out; during the busy summer months, you'll be sharing Bruges' magic with a constant stream of tourists in the medieval core.", 650, "10.04.2022", "17.04.2022"),
(3, 3, 'Kyoto', "Kyoto (京都, Kyōto), Japan. Kyoto is Japan in a nutshell. It’s the cultural and historical heart of the country. It’s the best place in all Japan to experience traditional temples, shrines, gardens, geisha, shops, restaurants and festivals. In short, Kyoto is the most rewarding destination in all of Japan and it should be at the top of any Japan travel itinerary. Indeed, I may be biased, but I’d go so far as to say that Kyoto is the most rewarding single city in all of Asia.", 900, "06.08.2021", "18.08.2021"),
(4, 4, 'Ljubjana',"Ljubljana is the green capital of a green country. The image of the town by a river with picturesque bridges. The town of a thousand events is surrounded by parks and natural protected areas. The Ljubljanica river flows through the centre of town, past Baroque buildings and under the ramparts of the ancient castle on the hill. Many bridges cross the river, the most famous of which is the Tromostovje (triple) bridge.", 450, "25.09.2021", "05.10.2021"),
(5, 5, 'Ohrid', "Ohrid is small enough to hop from historic monuments into a deck chair and dip your toes in the water – a lovely little town beach and boardwalk make the most of the town's natural charms. A holiday atmosphere prevails all summer, when it's a good idea to book accommodation in advance. Ohrid's busiest time is from mid-July to mid-August, during the popular summer festival.", 300, "01.07.2021", "15.07.2021"),
(6, 6, 'Svalbard', "Svalbard is the Arctic North as you always dreamed it existed. This wondrous archipelago is a land of dramatic snow-drowned peaks and glaciers, of vast ice fields and forbidding icebergs, skys with the spectacular light show of the Northern Lights, an elemental place where the seemingly endless Arctic night and the perpetual sunlight of summer carry a deeper kind of magic. One of Europe's last great wildernesses, this is also the domain of more polar bears than people, a terrain rich in epic legends of polar exploration.", 500, "20.12.2021", "29.12.2021"),
(7, 7, 'Venice', "Few cities can claim such a priceless art and history heritage as Venice. This unique city with its magical, spectacular scenery is not just beautiful; it is a real miracle of creative genius: a city built on mud, sand and the slime of a difficult, inhospitable landscape. The biggest attraction in the gorgeous city of Venice is the architecture — which is enhanced by the ancient canals that surround it. As well as Piazza San Marco and St. Mark’s Basilica, the city is home to the Gothic masterpiece Doge’s Palace.", 480, "15.04.2022", "24.04.2022");

INSERT INTO review (user_id, city_id, review) VALUES
(1, 1, "Wonderful nature, the lake and the island in the middle were like from a dream."),
(1, 2, "Very good place to visit, every thing was amazing! :)"),
(1, 3, "First time going to Japan and Kyoto was for sure an amazing experience. I will visit the country and the city again for sure :DD"),
(2, 3, "Just Wow, such an amazing place. The nature and the culture of this city were a thing to remember."),
(1, 4, "Very beautiful place, the river in the center of the city is mesmerizing, the Presernov square with all the architecture around is an unforgetable image. The old city at the top of the hill was amazing!!! :)"),
(1, 5, "Best time to visit is the summer. I loved everyday of the trip but mostly the swimming in the lake. The water is clear and refresing."),
(2, 6, "Despite the cold weather, The views are worth it. I suggest for everyone, at least once in their lifetime to witness the magical beauty of the Aurora Borealis."),
(2, 7, "Just a wonderful place to visit. Very pretty and made some unforgetable memories overthere. I would definately visit again :)");

INSERT INTO booking (user_id, trip_id, booking) VALUES
(1, 1, 'booking_info'),
(1, 2, 'booking_info'),
(1, 3, 'booking_info'),
(1, 4, 'booking_info'),
(1, 5, 'booking_info'),
(1, 6, 'booking_info'),
(2, 1, 'booking_info'),
(2, 3, 'booking_info'),
(2, 5, 'booking_info'),
(2, 6, 'booking_info'),
(2, 7, 'booking_info');

INSERT INTO rating (user_id, city_id, rating) VALUES
(1, 1, 5),
(1, 2, 4.5),
(1, 3, 5),
(1, 4, 4),
(1, 5, 3.5),
(1, 6, 4),
(2, 1, 4),
(2, 3, 5),
(2, 5, 4),
(2, 6, 4.5),
(2, 7, 4);