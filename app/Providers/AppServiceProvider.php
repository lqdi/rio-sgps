<?php

namespace SGPS\Providers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Schema;
use SGPS\Entity\Family;
use SGPS\Entity\Flag;
use SGPS\Entity\Group;
use SGPS\Entity\Person;
use SGPS\Entity\Residence;
use SGPS\Entity\User;
use SGPS\Utils\DateUtils;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

	    Schema::defaultStringLength(191);

	    Carbon::setLocale('pt_BR');

    	Carbon::setToStringFormat(DateUtils::BR_DATE_TIME);

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
