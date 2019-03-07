<?php

namespace izv\data;

/**
 * @Entity @Table(name="project")
 * 
 */
class Project {
    
    /**
     * @Id
     * @Column(type="bigint") @GeneratedValue
     */
    private $id; 
    
    /**
     * @Column(type="string", length=255, nullable=false)
     */
    private $title;
    
    /**
     * @ManyToOne(targetEntity="izv\data\User", inversedBy="projects")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $author;
    
    /**
     * @Column(type="text", length=255)
     */
    private $excerpt;
    
    /**
     * @Column(type="text", length=255)
     */
    private $content;
    
    /**
     * @Column(type="boolean", unique=false, nullable=false)
     */
    private $active = 0;
    
    /**
     * @Column(type="datetime", unique=false, nullable=false, columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP")
     */
    private $date;
    
    /**
     * @Column(type="bigint", nullable=false)
     */
    private $likes = 0;
    
    /**    
     * @Column(type="blob")
     */
    private $image = 0;
    

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
     * Set title
     *
     * @param string $title
     *
     * @return Project
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Project
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Project
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Project
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Project
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set author
     *
     * @param \User $author
     *
     * @return Project
     */
    public function setAuthor(\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set excerpt
     *
     * @param string $excerpt
     *
     * @return Project
     */
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    /**
     * Get excerpt
     *
     * @return string
     */
    public function getExcerpt()
    {
        return $this->excerpt;
    }

    /**
     * Set likes
     *
     * @param integer $likes
     *
     * @return Project
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * Get likes
     *
     * @return integer
     */
    public function getLikes()
    {
        return $this->likes;
    }
}
