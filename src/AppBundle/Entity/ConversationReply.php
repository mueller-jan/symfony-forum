<?php
/**
 * Created by PhpStorm.
 * User: Jan
 * Date: 27.03.2015
 * Time: 19:49
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="conversation_reply")
 */
class ConversationReply {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Conversation", inversedBy="conversationReplies")
     * @ORM\JoinColumn(name="id_conversation", referencedColumnName="id");
     */
    protected $conversation;

    /**
     * @ORM\Column(type="text")
     */
    protected $reply;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id");
     */
    protected $user;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set reply
     *
     * @param string $reply
     * @return ConversationReply
     */
    public function setReply($reply)
    {
        $this->reply = $reply;

        return $this;
    }

    /**
     * Get reply
     *
     * @return string 
     */
    public function getReply()
    {
        return $this->reply;
    }

    /**
     * Set conversation
     *
     * @param \AppBundle\Entity\Conversation $conversation
     * @return ConversationReply
     */
    public function setConversation(\AppBundle\Entity\Conversation $conversation = null)
    {
        $this->conversation = $conversation;

        return $this;
    }

    /**
     * Get conversation
     *
     * @return \AppBundle\Entity\Conversation 
     */
    public function getConversation()
    {
        return $this->conversation;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return ConversationReply
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
