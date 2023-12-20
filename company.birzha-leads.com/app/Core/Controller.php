<?php
namespace App\Core;

use App\Core\View;

/**
 * @class Controller
 */
class Controller
{
    public function __construct()
    {
    }

    protected function view($name, $data=null)
    {
        return View::load($name, $data);
    }
}
