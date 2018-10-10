<?php

namespace SGPS\Providers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use SGPS\Entity\Family;
use SGPS\Entity\Flag;
use SGPS\Entity\Group;
use SGPS\Entity\Person;
use SGPS\Entity\Residence;
use SGPS\Entity\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    	Carbon::setLocale('pt_BR');

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

	    Relation::morphMap([
		    'residence' => Residence::class,
		    'family' => Family::class,
		    'person' => Person::class,
		    'group' => Group::class,
		    'flag' => Flag::class,
		    'user' => User::class,
	    ]);

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
