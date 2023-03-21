<?php
/**
 * Create 500 creatives using random data.
 * 
 * First you need to composer require fakerphp/faker and require autoload.php,
 * or this won't work.
 * 
 * Then load your site with ?create_500_affiliates
 * 
 * @since Mar 21, 2023
 */

add_action( 'affwp_plugins_loaded', function() {

	if ( isset( $_GET['create_500_affiliates'] ) ) {

		$faker = \Faker\Factory::create();

		for ( $i = 0; $i <= 500; $i++ ) {

			affwp_add_creative(
				array(
					'name'        => $faker->name(),
					'description' => $faker->realText(),
					'text'        => $faker->realText(),
					'status'      => 'active',
				)
			);
		}

		die( 'Done' );
	}

} );