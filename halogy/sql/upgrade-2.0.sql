# Halogy upgrade for existing installs (run once, safe to re-run)
# Adds the "pages_navigation" permission used by /admin/pages/navigation.
# Assumes the default ha_ table prefix.

INSERT IGNORE INTO `ha_permissions` (`permission`, `key`, `category`, `special`)
VALUES ('Allow Navigation', 'pages_navigation', 'Pages', 0);

# Widen the password column to hold password_hash() hashes (legacy md5 values
# still work and are upgraded on first login).
ALTER TABLE `ha_users` MODIFY `password` varchar(255) collate utf8_unicode_ci default NULL;
