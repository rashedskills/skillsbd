ALTER TABLE `lesson` ADD `video_type_for_mobile_application` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `order`;
ALTER TABLE `lesson` ADD `video_url_for_mobile_application` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `order`;
ALTER TABLE `lesson` ADD `duration_for_mobile_application` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `order`;
UPDATE `settings` SET `value` = '3.0' WHERE `settings`.`key` = 'version';
