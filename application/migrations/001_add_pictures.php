<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Migration_Add_pictures extends CI_Migration {
  public function up () {
    $this->db->query (
      "CREATE TABLE `pictures` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,

        `token` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '亂碼',

        `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '名稱',
        `cover` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Cover',
        `pv` int(11) unsigned NOT NULL DEFAULT 0 COMMENT 'Page View',

        `color_r` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT 'RGB Red',
        `color_g` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT 'RGB Green',
        `color_b` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT 'RGB Blue',

        `latitude` DOUBLE NOT NULL DEFAULT -1 COMMENT '緯度',
        `longitude` DOUBLE NOT NULL DEFAULT -1 COMMENT '經度',

        `x` DOUBLE NOT NULL DEFAULT 0 COMMENT '球面 X',
        `y` DOUBLE NOT NULL DEFAULT 0 COMMENT '球面 Y',
        `z` DOUBLE NOT NULL DEFAULT 180 COMMENT '球面 Z',

        `made_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '照片時間',
        
        `is_visibled` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '是否可見，1 可, 0 不可',
        `is_rotated` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '是否自動旋轉，1 是, 0 否',
        `is_name_compressor` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '是否壓縮過，1 是，0 否',
        `is_cover_compressor` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '是否壓縮過，1 是，0 否',

        `updated_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '更新時間',
        `created_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '新增時間',
        PRIMARY KEY (`id`),
        KEY `token_index` (`token`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
    );
  }
  public function down () {
    $this->db->query (
      "DROP TABLE `pictures`;"
    );
  }
}