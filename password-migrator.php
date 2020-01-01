<?php
/*
Plugin Name: Password Migration for Magento2 to Wordpress
Plugin URI: https://harshmalpani.in
Description: Lets your customers successfully log in to their accounts after migration from Magento2 to Wordpress.
Version: 1.1
Author: Harshvardhan Malpani
Author URI: https://harshmalpani.in
*/
define('MIGRATED_USER_META_KEY', 'migrated_cs');
add_filter('check_password', 'malpani_password_migration_filter', 10, 4);
function malpani_password_migration_filter($check, $password, $hash, $user_id)
{
    if ($check)
    {
        return $check;
    }
    $pendingMigration = get_user_meta($user_id, MIGRATED_USER_META_KEY, true);
    if ($pendingMigration)
    {
        $currentPassword = get_userdata($user_id)->user_pass;
        //var_dump($currentPassword);
        $currentParts = explode(":", $currentPassword);
        //var_dump($currentParts);
        $currentSalt = $currentParts[1];
        $currentHash = $currentParts[0];
        $check = (md5($password) === $currentPassword)
        || (md5($currentSalt . $password) === $currentHash 
        || md5($currentSalt . $password) . ':' . $currentSalt === $currentHash 
        || hash('sha256', $currentSalt . $password) === $currentHash //current magento2
        || hash('sha256', $currentSalt . $password) . ':' . $currentSalt === $currentHash);

        if ($check && $user_id)
        {
            // Rehash using new hash.
            wp_set_password($password, $user_id);
            delete_user_meta($user_id, MIGRATED_USER_META_KEY);
        }

    }
    return $check;
}
?>
