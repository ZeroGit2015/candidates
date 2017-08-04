<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
           Расширение синтаксиса blade:

           @switch ($item) 
				@case (Значение 1) 
      				// code
					@break

				@case (Значение 2)
    	  			// code
					@break

				@case (Значение 3)
      				// code
					@break
			@endswitch
		*/

        Blade::extend(function($value, $compiler)
		{
    		$value = preg_replace('/(?<=\s)@switch[\s]*\((.*)\)(\s*)@case[\s]*\((.*)\)(?=\s)/', '<?php switch($1):$2case $3: ?>', $value);
    		$value = preg_replace('/(?<=\s)@endswitch(?=\s)/', '<?php endswitch; ?>', $value);

    		$value = preg_replace('/(?<=\s)@case[\s]*\((.*)\)(?=\s)/', '<?php case $1: ?>', $value);
    		$value = preg_replace('/(?<=\s)@default(?=\s)/', '<?php default: ?>', $value);
    		$value = preg_replace('/(?<=\s)@break(?=\s)/', '<?php break; ?>', $value);

    		return $value;
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
