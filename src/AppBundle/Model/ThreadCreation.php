<?php
namespace AppBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Thread;
use AppBundle\Entity\Post;

class ThreadCreation
{
    /**
     * @Assert\Type(type="AppBundle\Entity\Thread")
     * @Assert\Valid()
     */
    protected $thread;

    /**
     * @Assert\Type(type="AppBundle\Entity\Post")
     * @Assert\Valid()
     */
    protected $post;

    /**
     * @return mixed
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * @param mixed $thread
     */
    public function setThread(Thread $thread)
    {
        $this->thread = $thread;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     */
    public function setPost(Post $post)
    {
        $this->post = $post;
    }


}