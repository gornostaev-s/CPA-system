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

    /**
     * @param $name
     * @param $data
     * @return false|string
     */
    protected function view($name, $data=null): bool|string
    {
        return View::load($name, $data);
    }

    /**
     * @param string $url
     * @return void
     */
    protected function redirect(string $url): void
    {
        header("Location: $url");
    }
}
