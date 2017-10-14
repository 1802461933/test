<?php
namespace app\admin\controller;
use think\Session;
class Index
{
    public function index()
    {
        dump(Session::get('uid'));
    }
}
