<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 4/9/11
 * Time: 1:29 AM
 * To change this template use File | Settings | File Templates.
 */

class UserModel extends ActiveRecord\Model {
    static $table_name = 'users';

    public static function authenticateUser($user_name, $pw, $salt) {
        $user = UserModel::find_by_username($user_name);
        if (isset($user->password)) {
            // calculate the password hash
            $calculated_hash = hash("sha256", $user->password.hash("sha256", $salt));
            if ($calculated_hash == $pw) {
                return $user; // return the user and do whatever with it
            }
        }
        return false;
    }

}
