<?php 

return  [
 
	'panels' => [
		'dashboard' => [
            'name' => 'داشبورد',
            'href' => '#1b',
        ],
		'system' => [
            'name' => 'سیستم',
            'href' => '#2b',
        ],
		'monitor' => [
            'name' => 'نظارت',
            'href' => '#3b',
        ],
		'security' => [
            'name' => 'امنیت',
            'href' => '#4b',
        ],
		'callcenter' => [
            'name' => 'مرکز تلفن',
            'href' => '#5b',
        ],
		'users' => [
            'name' => 'کاربری',
            'href' => '#6b',
        ],
		'sounds' => [
            'name' => 'مدیریت صدا',
            'href' => '#7b',
        ],
		'modules' => [
            'name' => 'افزونه ها',
            'href' => '#8b',
        ],
		'reports' => [
            'name' => 'گزارشات سیستم',
            'href' => '#9b',
        ],
		'customreports' => [
            'name' => 'گزارشات درخواستی',
            'href' => '#10b',
        ],		
	],
	
	'views' => [
		'dashboard' => [
			'href'     => '1b',			
			'panels' => [
				'p1' => [
					'name' 	   => 'داشبورد',
					'tag'      => 'dashboard',				
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R01S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R01S02',
							'label' => 'دریافت خروجی',
							'name' => 'export',
						],
					],
				],	
			],
		],
		'system' => [
			'href' => '2b',
			'panels' => [
				'p1' => [
					'name' => 'مسیرهای ورودی',
					'tag'      => 'inroute',				
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R02S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R02S02',
							'label' => 'نمایش مسیرهای شخصی',
							'name' => 'pview',
						],
						'r3' => [
							'id'    => 'R02S03',
							'label' => 'ویرایش مسیر ها',
							'name' => 'edit',
						],
						'r4' => [
							'id'    => 'R02S04',
							'label' => 'حذف مسیر ها',
							'name' => 'delete',
						],
						'r5' => [
							'id'    => 'R02S05',
							'label' => 'افزودن مسیر جدید',
							'name' => 'add',
						],
					],	
				],
				'p2' => [
					'name' => 'مسیرهای خروجی',
					'tag'      => 'outroute',
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R03S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R03S02',
							'label' => 'نمایش مسیرهای شخصی',
							'name' => 'pview',
						],
						'r3' => [
							'id'    => 'R03S03',
							'label' => 'ویرایش مسیر ها',
							'name' => 'edit',
						],
						'r4' => [
							'id'    => 'R03S04',
							'label' => 'حذف مسیر ها',
							'name' => 'delete',
						],
						'r5' => [
							'id'    => 'R03S05',
							'label' => 'افزودن مسیر جدید',
							'name' => 'add',
						],
					],					
				],
				'p3' => [
					'name' => 'تنظیمات',
					'tag'      => 'settings',
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R04S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R04S02',
							'label' => 'ویرایش',
							'name' => 'edit',
						],						
					],					
				],
				'p4' => [
					'name' => 'پلان تماس های داخلی',
					'tag'      => 'dialplanes',
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R05S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R05S02',
							'label' => 'نمایش مسیرهای شخصی',
							'name' => 'pview',
						],
						'r3' => [
							'id'    => 'R05S03',
							'label' => 'ویرایش مسیر ها',
							'name' => 'edit',
						],
						'r4' => [
							'id'    => 'R05S04',
							'label' => 'حذف مسیر ها',
							'name' => 'delete',
						],
						'r5' => [
							'id'    => 'R05S05',
							'label' => 'افزودن مسیر جدید',
							'name' => 'add',
						],
					],					
				],
				'p5' => [
					'name' => 'دستورهای سیستم',
					'tag'      => 'commands',
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R06S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R06S02',
							'label' => 'ارسال دستور',
							'name' => 'command',
						],						
					],					
				],
			],							
		],
		'monitoring' => [
			'href' => '3b',
			'panels' => [
				'p1' => [
					'name' => 'مدیریت وضعیت سرویس ها',
					'tag'      => 'servicecontroling',				
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R07S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R07S02',
							'label' => 'نمایش سرویس های شخصی',
							'name' => 'pview',
						],
						'r3' => [
							'id'    => 'R07S03',
							'label' => 'ویرایش سرویس ها',
							'name' => 'edit',
						],
						'r4' => [
							'id'    => 'R07S04',
							'label' => 'حذف سرویس ها',
							'name' => 'delete',
						],
						'r5' => [
							'id'    => 'R07S05',
							'label' => 'افزودن سرویس جدید',
							'name' => 'add',
						],
					],	
				],
				'p2' => [
					'name' => 'وضعیت سرویس ها',
					'tag'      => 'servicestatus',
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R08S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],						
					],					
				],
				'p3' => [
					'name' => 'وضعیت سیستم',
					'tag'      => 'systemstatus',
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R09S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],	
						'r2'   => 	[
							'id'    => 'R09S02',
							'label' => 'عملیات',            
							'name' => 'access',
						],
					],					
				],	
				'p4' => [
					'name' => 'وضعیت صف ها',
					'tag'      => 'queuestatus',				
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R10S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R10S02',
							'label' => 'شنود',
							'name' => 'spy',
						],
						'r3' => [
							'id'    => 'R10S03',
							'label' => 'قطع تماس ها',
							'name' => 'disconnect',
						],
						'r4' => [
							'id'    => 'R10S04',
							'label' => 'انتقال تماس ها',
							'name' => 'transfet',
						],
						'r5' => [
							'id'    => 'R10S05',
							'label' => 'ورود و خروج',
							'name' => 'io',
						],
					],	
				],
			],							
		],
		'security' => [
			'href' => '4b',
			'panels' => [
				'p1' => [
					'name' => 'دیوار آتش',
					'tag'      => 'firewalld',				
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R11S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R11S02',
							'label' => 'ویرایش',
							'name' => 'edit',
						],						
					],	
				],
				'p2' => [
					'name' => 'دستگاه های مجاز',
					'tag'      => 'accesslist',				
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R12S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R12S02',
							'label' => 'ویرایش',
							'name' => 'edit',
						],						
					],	
				],	
				'p3' => [
					'name' => 'سرویس ها با دسترسی مجاز',
					'tag'      => 'acl',				
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R13S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R13S02',
							'label' => 'ویرایش',
							'name' => 'edit',
						],						
					],	
				],
			],							
		],
		'callcenter' => [
			'href' => '5b',
			'panels' => [
				'p1' => [
					'name' => 'میزکار',
					'tag'      => 'usersdashboard',				
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R14S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R14S02',
							'label' => 'شروع پاسخگویی',
							'name' => 'start',
						],
						'r3' => [
							'id'    => 'R14S03',
							'label' => 'استراحت',
							'name' => 'pause',
						],
						'r4' => [
							'id'    => 'R14S04',
							'label' => 'اتمام پاسخگویی',
							'name' => 'stop',
						],
						'r5' => [
							'id'    => 'R14S05',
							'label' => 'انتقال تماس',
							'name' => 'transfer',
						],
						'r6' => [
							'id'    => 'R14S06',
							'label' => 'بلوکه کردن مشترکین',
							'name' => 'block',
						],
						'r7' => [
							'id'    => 'R14S07',
							'label' => 'انتخاب صف',
							'name' => 'queue',
						],
						'r8' => [
							'id'    => 'R14S08',
							'label' => 'عملیات های مشترکین',
							'name' => 'actions',
						],
					],	
				],
				'p2' => [
					'name' => 'دفترچه تلفن',
					'tag'      => 'phonebook',
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R15S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R15S02',
							'label' => 'نمایش شماره های شخصی',
							'name' => 'pview',
						],
						'r3' => [
							'id'    => 'R15S03',
							'label' => 'ویرایش شماره ها',
							'name' => 'edit',
						],
						'r4' => [
							'id'    => 'R15S04',
							'label' => 'حذف شماره ها',
							'name' => 'delete',
						],
						'r5' => [
							'id'    => 'R15S05',
							'label' => 'افزودن شماره جدید',
							'name' => 'add',
						],
					],					
				],
				'p3' => [
					'name' => 'منشی دیجیتال',
					'tag'      => 'ivr',
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R16S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R16S02',
							'label' => 'نمایش منشی شخصی',
							'name' => 'pview',
						],
						'r3' => [
							'id'    => 'R16S03',
							'label' => 'ویرایش منشی ها',
							'name' => 'edit',
						],
						'r4' => [
							'id'    => 'R16S04',
							'label' => 'حذف منشی ها',
							'name' => 'delete',
						],
						'r5' => [
							'id'    => 'R16S05',
							'label' => 'افزودن منشی جدید',
							'name' => 'add',
						],
					],					
				],
				'p4' => [
					'name' => 'مدیریت صف ها',
					'tag'      => 'queues',
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R17S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R17S02',
							'label' => 'نمایش صف شخصی',
							'name' => 'pview',
						],
						'r3' => [
							'id'    => 'R17S03',
							'label' => 'ویرایش صف ها',
							'name' => 'edit',
						],
						'r4' => [
							'id'    => 'R17S04',
							'label' => 'حذف صف ها',
							'name' => 'delete',
						],
						'r5' => [
							'id'    => 'R17S05',
							'label' => 'افزودن صف جدید',
							'name' => 'add',
						],						
					],					
				],
				'p5' => [
					'name' => 'کاربران صف ها',
					'tag'      => 'queueagents',
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R18S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],					
						'r3' => [
							'id'    => 'R18S03',
							'label' => 'ویرایش',
							'name' => 'edit',
						],
						'r4' => [
							'id'    => 'R18S04',
							'label' => 'حذف',
							'name' => 'delete',
						],
						'r5' => [
							'id'    => 'R18S05',
							'label' => 'افزودن',
							'name' => 'add',
						],						
					],					
				],
				'p6' => [
					'name' => 'صندوق صوتی',
					'tag'      => 'voicemail',
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R19S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R19S02',
							'label' => 'نمایش صندوق های شخصی',
							'name' => 'pview',
						],
						'r3' => [
							'id'    => 'R19S03',
							'label' => 'ویرایش صندوق ها',
							'name' => 'edit',
						],
						'r4' => [
							'id'    => 'R19S04',
							'label' => 'حذف صندوق ها',
							'name' => 'delete',
						],
						'r5' => [
							'id'    => 'R19S05',
							'label' => 'افزودن صندوق جدید',
							'name' => 'add',
						],
					],					
				],
				'p7' => [
					'name' => 'شرکت ها',
					'tag'      => 'companies',
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R20S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R20S02',
							'label' => 'نمایش شرکت های شخصی',
							'name' => 'pview',
						],
						'r3' => [
							'id'    => 'R20S03',
							'label' => 'ویرایش شرکت ها',
							'name' => 'edit',
						],
						'r4' => [
							'id'    => 'R20S04',
							'label' => 'حذف شرکت ها',
							'name' => 'delete',
						],
						'r5' => [
							'id'    => 'R20S05',
							'label' => 'افزودن شرکت جدید',
							'name' => 'add',
						],
					],					
				],
				'p8' => [
					'name' => 'شرایط زمانی',
					'tag'      => 'timeline',
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R21S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R21S02',
							'label' => 'نمایش شرط شخصی',
							'name' => 'pview',
						],
						'r3' => [
							'id'    => 'R21S03',
							'label' => 'ویرایش شرط ها',
							'name' => 'edit',
						],
						'r4' => [
							'id'    => 'R21S04',
							'label' => 'حذف شرط ها',
							'name' => 'delete',
						],
						'r5' => [
							'id'    => 'R21S05',
							'label' => 'افزودن شرط جدید',
							'name' => 'add',
						],
					],					
				],
				'p9' => [
					'name' => 'اطلاعیه ها',
					'tag'      => 'info',
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R22S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R22S02',
							'label' => 'نمایش اطلاعیه های شخصی',
							'name' => 'pview',
						],
						'r3' => [
							'id'    => 'R22S03',
							'label' => 'ویرایش اطلاعیه ها',
							'name' => 'edit',
						],
						'r4' => [
							'id'    => 'R22S04',
							'label' => 'حذف اطلاعیه ها',
							'name' => 'delete',
						],
						'r5' => [
							'id'    => 'R22S05',
							'label' => 'افزودن اطلاعیه جدید',
							'name' => 'add',
						],
					],					
				],
			],							
		],
		'users' => [
			'href' => '6b',
			'panels' => [
				'p1' => [
					'name' => 'کاربران',
					'tag'      => 'users',				
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R23S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R23S02',
							'label' => 'نمایش سرویس های شخصی',
							'name' => 'pview',
						],
						'r3' => [
							'id'    => 'R23S03',
							'label' => 'ویرایش سرویس ها',
							'name' => 'edit',
						],
						'r4' => [
							'id'    => 'R23S04',
							'label' => 'حذف سرویس ها',
							'name' => 'delete',
						],
						'r5' => [
							'id'    => 'R23S05',
							'label' => 'افزودن سرویس جدید',
							'name' => 'add',
						],
						'r6' => [
							'id'    => 'R23S06',
							'label' => 'افزودن گروه',
							'name' => 'addgroup',
						],
					],	
				],
				'p2' => [
					'name' => 'گروه ها',
					'tag'      => 'groups',				
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R24S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],
						'r2' => [
							'id'    => 'R24S02',
							'label' => 'نمایش سرویس های شخصی',
							'name' => 'pview',
						],
						'r3' => [
							'id'    => 'R24S03',
							'label' => 'ویرایش سرویس ها',
							'name' => 'edit',
						],
						'r4' => [
							'id'    => 'R24S04',
							'label' => 'حذف سرویس ها',
							'name' => 'delete',
						],
						'r5' => [
							'id'    => 'R24S05',
							'label' => 'افزودن سرویس جدید',
							'name' => 'add',
						],
					],	
				],
				'p3' => [
					'name' => 'مدیریت گروه ها',
					'tag'      => 'managegroups',
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R25S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],	
						'r2'   => 	[
							'id'    => 'R25S02',
							'label' => 'ویرایش',            
							'name' => 'edit',
						],	
					],					
				],
				'p4' => [
					'name' => 'پیام ها',
					'tag'      => 'messages',
					'roles'    => [
						'r1'   => 	[
							'id'    => 'R26S01',
							'label' => 'نمایش',            
							'name' => 'view',
						],	
						'r2'   => 	[
							'id'    => 'R26S02',
							'label' => 'ویرایش',            
							'name' => 'edit',
						],							
					],					
				],					
			],							
		],
	],
];