<?php
class ShopController extends AdminController
{

    function init()
    {
        parent::init();
    }

    function indexAction(){

    }

    #广告列表
    function bannerAction(){
        $condition = array();
        $page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
        $page_size = 20;
        $admin_user_model = new BannerModel();
        $show_list = $admin_user_model->getListData($page,$page_size,$condition);

        $this->_view->page = $page;
        $this->_view->show_list = $show_list;
        #分页处理
        $total_num = $admin_user_model->getListCount($condition);
        $pagination = $this->getPagination($total_num, $page, $page_size);
        $this->_view->page = $page;
        $this->_view->pager = new System_Page($this->base_url, $condition, $pagination);

        $this->_layout->meta_title = '后台用户列表';
    }

    #新增/编辑广告
    function createBannerAction(){
        $id = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
        $book_model = new BannerModel();

        $info = [];
        if($id > 0){
            $info = $book_model->getData($id);
        }

        if($this->getRequest()->isPost()) {
            $title = !empty($_REQUEST['title']) ? trim($_REQUEST['title']) : '';
            $author = !empty($_REQUEST['author']) ? trim($_REQUEST['author']) : '';
            $press = !empty($_REQUEST['press']) ? trim($_REQUEST['press']) : '';
            $version = !empty($_REQUEST['version']) ? trim($_REQUEST['version']) : '';
            $category = !empty($_REQUEST['category']) ? trim($_REQUEST['category']) : '';
            $price = !empty($_REQUEST['price']) ? trim($_REQUEST['price']) : '';
            $type = !empty($_REQUEST['type']) ? intval($_REQUEST['type']) : 1;

            $data = array(
                'title' => $title,
                'author' => $author,
                'press' => $press,
                'version' => $version,
                'category' => $category,
                'type' => $type,
                'price' => $price,
            );

            if($info['id']) {
                $book_model->updateData($data, $info['id']);
            } else {
                $book_model->addData($data);
            }

            $this->set_flush_message("编辑/添加活动成功");
            $this->redirect('/admin/book/index/');
            return FALSE;
        }

        $this->_view->info = $info;
        $this->_layout->meta_title = '编辑/添加书籍';

    }
}