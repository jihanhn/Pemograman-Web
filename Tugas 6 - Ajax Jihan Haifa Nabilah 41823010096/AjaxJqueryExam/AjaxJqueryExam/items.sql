CREATE TABLE IF NOT EXISTS WebBasic.items (

  id int(10) unsigned NOT NULL AUTO_INCREMENT,

  title varchar(255) COLLATE utf8_unicode_ci NOT NULL,

  description text COLLATE utf8_unicode_ci NOT NULL,

  created_at timestamp NULL DEFAULT NULL,

  updated_at timestamp NULL DEFAULT NULL,

  PRIMARY KEY (`id`)

)  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=63 ;