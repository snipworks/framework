<?php

/**
 * Default controller
 * @class indexController
 */
class homeController extends Controller
{
    /**
     * Default action (list users)
     * @action doIndex
     */
    public function indexAction()
    {
        try {
            $con = Database::getConnection(Database::DEFAULT_SETTING);
            $users = User::find($con);
        } catch (Exception $e) {
            $users = null;
        }

        $this->users = $users;
        $this->msg = null;
    }

    /**
     * Create user action
     */
    public function createAction()
    {
        try {
            if (Request::isMethod('post')) {
                $con = Database::getConnection(Database::DEFAULT_SETTING);
                $user = UserUtil::create(
                    Request::getParameter('username'),
                    Request::getParameter('password'),
                    $con
                );
                $this->msg = 'User ' . $user->username . ' has been created';
            }
        } catch (Exception $e) {
            $this->msg = $e->getMessage();
        }
    }

    /**
     * Find function
     * @action doFind
     */
    public function viewAction()
    {
        try {
            $con = Database::getConnection(Database::DEFAULT_SETTING);
            $user = User::findById(Request::getParameter('id'), $con);
            $this->msg = (!$user) ? 'User not found.' : 'User ' . $user->username . ' has been found.';
            $this->user = $user;
        } catch (Exception $e) {
            $this->msg = $e->getMessage();
            $this->user = null;
        }
    }

    /**
     * Edit function
     */
    public function editAction()
    {
        try {
            $id = Request::getParameter('id');
            $con = Database::getConnection(Database::DEFAULT_SETTING);
            if (Request::isMethod('post')) {
                $username = Request::getParameter('username');
                $password = Request::getParameter('password');
                if (!$username || !$password) {
                    throw new Exception('Username/Password is required');
                }

                UserUtil::update($id, $username, $password);
                $this->redirect('/');
            } else {
                $user = User::findById($id, $con);
                if (!$user) {
                    throw new Exception('User with id ' . $id . ' not found.');
                }

                $this->user = $user;
            }
        } catch (Exception $e) {
            $this->msg = $e->getMessage();
        }
    }

    /**
     * Delete specific user
     */
    public function deleteAction()
    {
        try {
            $con = Database::getConnection(Database::DEFAULT_SETTING);
            UserUtil::delete(Request::getParameter('id'), $con);
            $this->redirect('/');
        } catch (Exception $e) {
            $this->msg = $e->getMessage();
        }
    }
}