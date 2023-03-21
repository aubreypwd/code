<?php
/**
 * Create 500 affiliates using random data.
 *
 * Does not user fake data, but a counter.
 *
 * @since Mar 21, 2023
 */

add_action( 'affwp_plugins_loaded', function() {

	add_action( 'admin_init', function() {

		if ( isset( $_GET['create_500_affiliates'] ) ) {

			for ( $i = 1; $i <= 501; $i++ ) {

				$email = "user_{$i}" . '@example.com';

				$user_id = wp_insert_user( array(
					'user_pass'     => wp_generate_password(),
					'user_login'    => "user_{$i}",
					'user_nicename' => "user_{$i}",
					'user_email'    => $email,
					'display_name'  => "User {$i}",
					'nickname'      => "Nickname {$i}",
					'first_name'    => "First{$i}",
					'last_name'     => "Last{$i}",
				) );

				affwp_add_affiliate(
					array(
						'user_id'          => $user_id,
						'status'           => 'active',
						// 'rate'             => '',
						// 'rate_type'        => '',
						// 'flat_rate_basis'  => '',
						'payment_email'    => $email,
						// 'notes'            => '',
						// 'website_url'      => '',
						// 'date_registered'  => '',
						// 'dynamic_coupon'   => '',
					)
				);
			}

			die( '500 Affiliates Created' );
		}

	} );

} );