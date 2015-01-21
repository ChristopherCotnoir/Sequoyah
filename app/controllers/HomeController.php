<?php

class HomeController extends BaseController
{
	public function ShowIndex()
	{
		return View::make('pages.home');
	}
}
