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
     * @ManyToOne(targetEntity="User", inversedBy="projects")
     */
    private $author;
    
    /**
     * @Column(type="text", length=255, nullable=false)
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
     * @Column(type="blob", nullable=false)
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
}
