<?php

return [

	'form' => [
		'quiz' => [
			'writing_style' => [
				''            => 'Select writing style',
				'Fact based'  => 'Fact based',
				'Emotional'   => 'Emotional',
				'Middle Road' => 'Middle Road',
			],
			'graphic_style' => [
				''            => 'Select graphic style',
				'Clean Lines' => 'Clean Lines',
				'Borders'     => 'Borders',
				'Fade'        => 'Fade',
				'Cut Out'     => 'Cut Out',
				'Vibrant'     => 'Vibrant',
				'Boxed Text'  => 'Boxed Text',
			],
		],
	],
	'plans' => [
		'fubbi-basic-plan'  => [
			'price'    => '79700',
			'articles' => [
				'count' => 1,
				'words' => [
					'min' => '1750',
					'max' => '1750',
				],
			],
			'services' => [
				'Facebook Posting'           => 10,
				'Instagram Posting'          => 10,
				'Twitter Posting'            => 10,
				'Pinterest Posting'          => 10,
				'LinkedIn Posting'           => 10,
				'365 Day Marketing Calendar' => true,
				'LinkedIn Articles'          => false,
				'Slideshare'                 => false,
				'Medium'                     => false,
				'Quora'                      => false,
			],
		],
		'fubbi-bronze-plan' => [
			'price'    => '99700',
			'articles' => [
				'count' => 2,
				'words' => [
					'min' => '1750',
					'max' => '1750',
				],
			],
			'services' => [
				'Facebook Posting'           => 10,
				'Instagram Posting'          => 10,
				'Twitter Posting'            => 10,
				'Pinterest Posting'          => 10,
				'LinkedIn Posting'           => 10,
				'365 Day Marketing Calendar' => true,
				'LinkedIn Articles'          => 1,
				'Slideshare'                 => false,
				'Medium'                     => false,
				'Quora'                      => false,
			],
		],
		'fubbi-silver-plan' => [
			'price'    => '79700',
			'articles' => [
				'count' => 4,
				'words' => [
					'min' => '1250',
					'max' => '1500',
				],
			],
			'services' => [
				'Facebook Posting'           => 20,
				'Instagram Posting'          => 20,
				'Twitter Posting'            => 20,
				'Pinterest Posting'          => 20,
				'LinkedIn Posting'           => 20,
				'365 Day Marketing Calendar' => true,
				'LinkedIn Articles'          => 1,
				'Slideshare'                 => 1,
				'Medium'                     => 1,
				'Quora'                      => 1,
			],
		],
		'fubbi-gold-plan'   => [
			'price'    => '179700',
			'articles' => [
				'count' => 4,
				'words' => [
					'min' => '1750',
					'max' => '1750',
				],
			],
			'services' => [
				'Facebook Posting'           => 30,
				'Instagram Posting'          => 30,
				'Twitter Posting'            => 30,
				'Pinterest Posting'          => 30,
				'LinkedIn Posting'           => 30,
				'365 Day Marketing Calendar' => true,
				'LinkedIn Articles'          => 2,
				'Slideshare'                 => 2,
				'Medium'                     => 2,
				'Quora'                      => 2,
			],
		],
	],

];