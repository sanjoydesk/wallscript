<?php
namespace Apps\Controllers;

use Cygnite\Common\Input;
use Cygnite\FormBuilder\Form;
use Cygnite\Validation\Validator;
use Cygnite\AssetManager\Asset;
use Cygnite\Common\UrlManager\Url;
use Cygnite\Foundation\Application;
use Cygnite\Mvc\Controller\AbstractBaseController;
use Apps\Components\Form\CommentForm;
use Apps\Models\FacebookPosts;
use Cygnite\Mvc\View\Widget;
use Apps\Components\Wallscript\Libraries\Link;
use Apps\Components\Wallscript\Time\TimeStamp;
use Apps\Models\FacebookPostsComments as FacebookComment;

class CommentController extends AbstractBaseController
{
    // Plain layout
    protected $layout = 'layout.base';
	
	protected $templateEngine = false;

    public $link;

    public $input;

    /**
     * Your constructor.
     * @access public
     */
    public function __construct(Link $link)
    {
        parent::__construct();
        $this->link = $link;
        $this->input = Input::make();
    }

    /**
     * Default method for your controller. Render welcome page to user.
     * @access public
     *
     */
    public function indexAction()
    {
        $comment = array();
        $comment = FacebookPosts::all(array('orderBy' => 'p_id desc', 'limit' => "0,8"));
		
        $this->render('index', array(
            'posts' => $comment,
            "commentWidget" => Widget::make('comment::widget::comment', array('posts' => $comment, 'link' => $this->link )),
            "number_of_post" => count($comment) ,
            'title' => 'Facebook Style Wall Posting Script using jQuery PHP and Ajax.'
        ));
    }

    public function addCommentAction()
    {
        $post = $this->input->post();

        $fBComment = new FacebookComment;
        $fBComment->post_id = $post['post_id'];
        $fBComment->comments = $post['comment'];
        $fBComment->userip = $_SERVER['REMOTE_ADDR'];
        $fBComment->date_created = strtotime(date("Y-m-d H:i:s"));
        $fBComment->save();

        $result = FacebookComment::findByCId($fBComment->c_id);
        $response = array("comment" => $result[0]->comments, "comment_id" => $result[0]->c_id);
        echo json_encode($response);
    }

    public function deleteAction()
    {
        $userip = $_SERVER['REMOTE_ADDR'];
        $post = $this->input->post();

        $fBPost = new FacebookPosts;
        $fBPost->trash($post['id']);

        $fBComment = new FacebookComment;

        $fbComment = FacebookComment::prepare("DELETE FROM facebook_posts_comments WHERE post_id =  ? ");
        $fbComment->execute(array($post['id']));
        echo $fbComment->rowCount();
    }

    public function deleteCommentAction()
    {
        $userip = $_SERVER['REMOTE_ADDR'];
        $post = $this->input->post();

        $fbComment = new FacebookComment;
        $fbComment->trash($post['id']);
    }

    public function postAction()
    {
        $comment = $this->input->post('value');

        if (isset($comment)) {

            $fbPost = new FacebookPosts();
            $fbPost->post = $comment;
            $fbPost->f_name = 'Sanjoy Dey - www.appsntech.com';
            $fbPost->userip = $_SERVER['REMOTE_ADDR'];
            $fbPost->date_created = strtotime(date("Y-m-d H:i:s"));
            $fbPost->save();
            //$result = FacebookPosts::all(array('orderBy' => 'p_id desc', 'limit' => "1"));
            $response = array('name' => $fbPost->f_name , 'post' => $fbPost->post, 'id' => $fbPost->p_id);
            echo json_encode($response);
        }


    }

    public function getTimeStampAction($timeStamp)
    {
        TimeStamp::convert($timeStamp);
    }

    public function showMoreAction()
    {
        $value = $this->input->post('limit');

        if (isset($value)) { // more posting paging
            $result = FacebookPosts::all(array('orderBy' => 'p_id desc', 'limit' => "$value, 8"));
        }
		
        if (count($result) > 0) {
                $widgetComment = Widget::make('comment::widget::comment', array('posts' => $result, 'link' => $this->link ));
                $reponse = array('posts' => $widgetComment, "count" => 8);
        } else {
              $reponse = array('posts' => '',  "count" => 8);
        }
		echo json_encode($reponse);exit;
    }
}
//End of your comment controller
