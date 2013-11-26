<?php

namespace br\com\cf\library\core\gantt;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class Task
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
     * @var integer
     */
    public $duration = 0;

    /**
     * @var integer
     */
    public $percent = 0;

    /**
     * @var integer
     */
    public $parent = '';

    /**
     * @var array
     */
    public $tasks = array();

    /**
     * @return void
     */
    private function __construct ($id, $name, $date, $duration, $percent, $parent = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
        $this->duration = $duration;
        $this->percent = $percent;
        $this->parent = $parent;
    }

    /**
     * @return Task
     */
    public static function factory ($id, $name, $date, $duration, $percent, $parent = '')
    {
        return new self($id, $name, $date, $duration, $percent, $parent);
    }

    /**
     * @return Task
     */
    public function addTask (Task $task)
    {
        $this->tasks[$task->id] = $task;
        return $this;
    }

}