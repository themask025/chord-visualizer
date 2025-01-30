<?php

require_once (__DIR__ . "/../constants.php");
require_once (__DIR__ . '/controller.php');
class CommentController extends Controller
{
    private $comment_model;

    public function __construct()
    {
        $this->comment_model = $this->loadModel('Comment');
    }

    private function checkUser()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["user_id"])) {
            header("Location: ". BASE_PATH);
            exit;
        }
    }
    public function addComment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->checkUser();
            $user_id = $_SESSION['user_id'];
            $comment_text = $_POST['comment_text'];
            $version_id = $_POST['version_id'];
            $timestamp = date('Y-m-d H:i:s');
            $this->comment_model->storeComment($version_id, $user_id, $timestamp, $comment_text);

            header("Location: ". BASE_PATH. "version/tabEditor?version_id={$version_id}");
        }
    }

    public function updateComment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->checkUser();

            $user_id = $_SESSION["user_id"];
            $comment_id = $_POST['comment_id'];
            $comment_text = $_POST['comment_text'];
            $version_id = $_POST['version_id'];
            $timestamp = date('Y-m-d H:i:s');
            $this->comment_model->updateComment($comment_id, $user_id, $timestamp, $comment_text);

            header("Location: " .BASE_PATH. "version/tabEditor?version_id={$version_id}");
        }
    }
}
