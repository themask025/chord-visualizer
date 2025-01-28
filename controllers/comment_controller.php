<?php

require_once 'controller.php';
class CommentController extends Controller
{
    private $comment_model;
    private $user_model;

    public function __construct()
    {
        $this->comment_model = $this->loadModel('Comment');
        $this->user_model = $this->loadModel('User');
    }

    private function checkUser($user_id)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if(!isset($_SESSION["user_id"])) {
            header("Location: /chord-visualizer/");
            exit;
        }

        if($_SESSION["user_id"] != $user_id) {
            echo "You are not authorized to comment on this version.";
            exit;
        }
    }
    public function addComment()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

           $this->checkUser($_POST['user_id']);
            $user_id = $_POST['user_id'];
            $comment_text = $_POST['comment_text'];
            $version_id = $_POST['version_id'];
            $timestamp = date('Y-m-d H:i:s');
            $this->comment_model->storeComment($version_id, $user_id, $timestamp, $comment_text);

            header("Location: /chord-visualizer/version/tabEditor?version_id={$version_id}");
        }
    }

    public function updateComment()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->checkUser($_POST['user_id']);
            $user_id = $_POST['user_id'];
            $comment_id = $_POST['comment_id'];
            $comment_text = $_POST['comment_text'];
            $version_id = $_POST['version_id'];
            $timestamp = date('Y-m-d H:i:s');
            $this->comment_model->updateComment($comment_id,$user_id ,$timestamp, $comment_text);

            header("Location: /chord-visualizer/version/tabEditor?version_id={$version_id}");
        }
    }
}
