<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
		Blade::directive('warning', function ($text)
		{
			/*$text = explode('(', $text)[1];
			$text = explode('"', $text)[1];
			$text = explode(')', $text)[0];*/
			$text = substr($text, 1, -1);
			return
			'
			<div class="alert alert-warning alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Warning! </strong> '.$text.'
            </div>
            ';
		});
		Blade::directive('danger', function ($text)
		{
			/*$text = explode('(', $text)[1];
			$text = explode('"', $text)[1];
			$text = explode(')', $text)[0];*/
			$text = substr($text, 1, -1);
			return
				'
			<div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
              <strong>Danger! </strong> '.$text.'
            </div>
            ';
		});
		Blade::directive('info', function ($text)
		{
			/*$text = explode('(', $text)[1];
			$text = explode('"', $text)[1];
			$text = explode(')', $text)[0];*/
			$text = substr($text, 1, -1);
			return
				'
			<div class="alert alert-info alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Info! </strong> '.$text.'
            </div>
            ';
		});
		Blade::directive('success', function ($text)
		{
			/*$text = explode('(', $text)[1];
			$text = explode('"', $text)[1];
			$text = explode(')', $text)[0];*/
			$text = substr($text, 1, -1);
			return
				'
			<div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <strong>Success! </strong> '.$text.'
            </div>
            ';
		});
		Blade::directive('helper', function($namevar){
			$namevar = explode('(', $namevar)[1];
			$namevar = explode(')', $namevar)[0];

			return '<?php
						if($errors->has('.$namevar.')){

							echo "<span class=\"help-block\"><p class=\"red\">".$errors->first('.$namevar.')."</p></span>";
						}
					?>';
		});
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
