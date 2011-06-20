<?php
/**
 * Created by IntelliJ IDEA.
 * User: codetwister
 * Date: 4/9/11
 * Time: 1:36 AM
 * To change this template use File | Settings | File Templates.
 */
 
class Test extends Controller {

    function index() {
        $this->load->library('activerecord');
        echo "test fjdsl ajfdsf aieowjifo jid sjfioasj ieo";
        $users = UserModel::all();
        print_r($users);
    }

}
