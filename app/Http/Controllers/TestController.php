<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function test1()
    {
        dd('ok');
        $ip = "81.246.119.251";
        $ldaps_url = "ldaps://$ip";
        $port = 636;
        $ldap_conn = ldap_connect( $ldaps_url, $port ) or die("Sorry! Could not connect to LDAP server ($ip)");
        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);

        $password = "bLDH*.5Pp";
        $binddn = "CN=ngiadmin,CN=Users,DC=mse,DC=local";
        $result = ldap_bind( $ldap_conn, $binddn, $password ) or die("  Error: Couldn't bind to server using provided credentials!");
        if($result) {
            return $ldap_conn;
        }
        else
        {
            die (" Error: Couldn't bind to server with supplied credentials!");
        }





        if ($ldapconn) {

            try {
                $ldapbind = ldap_bind($ldapconn, "testgebruiker@mse.local", "Info1234");
                if ($ldapbind) {
                    echo "LDAP bind successful...";
                } else {
                    echo "LDAP bind failed...";
                }
            } catch (\Exception $e) {
                dd($e);
                echo 'not binded';
            }


        }

    }
}
