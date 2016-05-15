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
				"
			<div class='ui warning message'>
				<div class='header'>
    				All hands on deck
  				</div>
  				<i class='close icon'></i>
  				{$text}
			</div>
			";
		});
		Blade::directive('error', function ($text)
		{
			/*$text = explode('(', $text)[1];
			$text = explode('"', $text)[1];
			$text = explode(')', $text)[0];*/
			$text = substr($text, 1, -1);

			return
				"
			<div class='ui error message'>
				<div class='header'>
    				Alright {{ explode(' ', Auth::user()->name)[0] }}... Calm your tits
  				</div>
  				<i class='close icon'></i>
  				{$text}
			</div>
			";
		});
		Blade::directive('info', function ($text)
		{
			/*$text = explode('(', $text)[1];
			$text = explode('"', $text)[1];
			$text = explode(')', $text)[0];*/
			$text = substr($text, 1, -1);
			return
				"
			<div class='ui info message'>
				<div class='header'>
    				Information
  				</div>
  				<i class='close icon'></i>
  				{$text}
			</div>
			";
		});
		Blade::directive('success', function ($text)
		{
			/*$text = explode('(', $text)[1];
			$text = explode('"', $text)[1];
			$text = explode(')', $text)[0];*/
			$text = substr($text, 1, -1);
			return
				"
			<div class='ui success message'>
				<div class='header'>
    				Success
  				</div>
  				<i class='close icon'></i>
  				{$text}
			</div>
			";
		});
		Blade::directive('helper', function ($namevar)
		{
			$namevar = explode('(', $namevar)[1];
			$namevar = explode(')', $namevar)[0];

			return '<?php
						if($errors->has(' . $namevar . ')){

							echo "<div class=\"ui pointing red basic label\" style=\"margin-bottom: 14px\">".$errors->first(' . $namevar . ')."</div>";
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
