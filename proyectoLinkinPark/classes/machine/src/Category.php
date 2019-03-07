<?php

namespace izv\data;

/**
 * @Entity @Table(name="category")
 * 
 */
class Category {
    
    /**
     * @Id
     * @Column(type="bigint") @GeneratedValue
     */
    private $id; 
    
    /**
     * @Column(type="string", length=255, nullable=false)
     */
    private $name;
    
    /**
     * @ManyToOne(targetEntity="izv\data\User", inversedBy="categories")
     * @JoinColumn(name="author_id", referencedColumnName="id")
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
     * @param \User $author
     *
     * @return Category
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
}
