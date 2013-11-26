<?php

namespace br\com\cf\library\core\gantt;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class Project
{

    /**
     * @var integer
     */
    public $id = 0;

    /**
     * @var string
     */
    public $name = 0;

    /**
     * @var date
     */
    public $date = '0000-00-00';

    /**
     * @var array
     */
    public $tasks = array();

    /**
     * @return void
     */
    private function __construct ($id, $name, $date)
    {
        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
    }

    /**
     * @return Project
     */
    public static function factory ($id, $name, $date)
    {
        return new self($id, $name, $date);
    }

    /**
     * @return Project
     */
    public function addTask (Task $task)
    {
        $this->tasks[$task->id] = $task;
        return $this;
    }

}