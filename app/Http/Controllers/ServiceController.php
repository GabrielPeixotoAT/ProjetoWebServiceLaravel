<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Xml;
use App\Models\User;

class ServiceController extends Controller
{
    private Xml $xml;

    public function __contruct(Xml $xml)
    {
        $this->xml = $xml;
    }
    public function index()
    {
        $this->xml = new Xml();

        $error = 0;
        $msg = 'success';

        $id_user = $_GET['id'];

        $this->xml->openTag("response");

        if ($id_user == '')
        {
            $error = 1;
            $msg = 'Invalid ID';
        }
        else 
        {
            $finded_user = User::find($id_user);
            if ($finded_user == null)
            {
                $error = 2;
                $msg = 'Not Found';
            }
            else
            {
                $this->xml->addTag('login', $finded_user->login);
                $this->xml->addTag('password', $finded_user->password);
            }
        }

        $this->xml->addTag('error', $error);
        $this->xml->addTag('message', $msg);

        $this->xml->closeTag("response");

        echo $this->xml;
    }
}
