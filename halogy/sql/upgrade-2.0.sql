# Halogy upgrade for existing installs (run once, safe to re-run)
# Adds the "pages_navigation" permission used by /admin/pages/navigation.
# Assumes the default ha_ table prefix.

INSERT IGNORE INTO `ha_permissions` (`permission`, `key`, `category`, `special`)
VALUES ('Allow Navigation', 'pages_navigation', 'Pages', 0);
