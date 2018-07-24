<?php

namespace SGPS\Providers;

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
    	$faker = \Faker\Factory::create('pt_BR');;

    	$labels = collect([
    		'Criança Fora da Escola',
		    'Bolsa Família',
		    'Cartão Família Carioca',
		    'Falta de documentação',
		    'Desemprego',
		    'Violência Doméstica',
		    'Falta de Saneamento Básico',
		    'Falta de Transporte Público',
	    ]);

        \View::share('faker', $faker);
        \View::share('labels', $labels);
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
