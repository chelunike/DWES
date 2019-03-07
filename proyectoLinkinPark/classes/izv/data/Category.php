<?php

namespace izv\data;

/**
 * @Entity @Table(name="category")
 * 
 */
class Category {
    
    use \izv\Common\Comun;
    
    /**
     * @Id
     * @Column(type="bigint") @GeneratedValue
     */
    private $id; 
    
    /**
     * @Column(type="string", unique=true, length=255, nullable=false)
     */
    private $name;
    
    /**
     * @ManyToOne(targetEntity="izv\data\User", inversedBy="category")
     * @JoinColumn(name="author_id", referencedColumnName="id", unique=true)
     */
    private $author;
    
    
    /**
     * @OneToMany(targetEntity="izv\data\Link", mappedBy="category")
     */
    private $links;
    
    /**
     * @Column(type="boolean", nullable=false)
     */
    private $active = true;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->links = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Category
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
     * Set author
     *
     * @param \izv\data\User $author
     *
     * @return Category
     */
    public function setAuthor(\izv\data\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \izv\data\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add link
     *
     * @param \izv\data\Link $link
     *
     * @return Category
     */
    public function addLink(\izv\data\Link $link)
    {
        $this->links[] = $link;

        return $this;
    }

    /**
     * Remove link
     *
     * @param \izv\data\Link $link
     */
    public function removeLink(\izv\data\Link $link)
    {
        $this->links->removeElement($link);
    }

    /**
     * Get links
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLinks()
    {
        return $this->links;
    }
}

