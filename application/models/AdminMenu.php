<?php class AdminMenuModel {

	public  $menu_list = array(
			'user' => array(
				'user' => array(
					'title' => '用户管理',
					'style' => 'glyphicon glyphicon-registration-mark',
					'href' => '/admin/user/index',
					'childs' => array(
						'index' => array(
							'title' => '用户列表',
							'href' => '/admin/user/index/',
							'style' => 'glyphicon glyphicon-chevron-right'
						),

					)
				),
			),
			'stat' => array(
				'stat' => array(
					'title' => '数据统计',
					'style' => 'glyphicon glyphicon-certificate',
					'href' => '/admin/stat/index',
					'childs' => array(
						'index' => array(
							'title' => '统计列表',
							'href' => '/admin/stat/index/',
							'style' => 'glyphicon glyphicon-chevron-right'
						),

					)
				),
			),
			'adminuser' => array(
				'adminuser' => array(
					'title' => '后台管理',
					'style' => 'glyphicon glyphicon-user',
					'href' => '/admin/adminuser/index/',
					'childs' => array(
						'index' => array(
							'title' => '后台管理',
							'href' => '/admin/adminuser/index/',
							'style' => 'glyphicon glyphicon-chevron-right'
						),
					)
				),

			),

		);
	
	public function getMenu($controller){
		if(isset($this->menu_list[$controller])) {
			$ret = $this->menu_list[$controller];
		} else {
			$ret = array();
		}
		return $ret;
	}
	
}