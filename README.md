# Migrate Customer Password from Magento2 to Wordpress
This wordpress plugin checks and updates passwords of users migrated from Magento2 to Wordpress


### Requirements:

1. `user_pass` column will have this kind data from Magento2
`dcbdc524f215fd054502dcad5a23a702ec029c02ff8d7051d049f76e29927f8b:C8yVqeuPfkHWvkmipx0iKLPtOUGETpLL:1`
2. `usermeta` table must have a `meta_key` ["migrated_cs"](https://github.com/harshvardhanmalpani/migrate-password-from-magento2-to-wordpress/blob/master/password-migrator.php#L10) for this user, `meta_value` can be anything positive

3. This plugin file [password-migrator.php](https://github.com/harshvardhanmalpani/migrate-password-from-magento2-to-wordpress/raw/master/password-migrator.php) should be in _wp-content/plugins_ and must be an active plugin

### What is does?

For new wordpress based users which dont have anything to do with magento2, it doesnt do anything

For all migrated users (those have the key "migrated_cs"), this plugin checks if input password matches old password from magento2 or not, if matched, it clears the key migrated_cs and updates the password using wordpress' algorithm ; else results false.
