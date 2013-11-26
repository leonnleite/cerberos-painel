<?php

namespace br\com\cf\library\core\gantt;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class Gantt
{

    /**
     * @var integer
     */
    private $_id = 0;

    /**
     * @var Project[]
     */
    private $_projects = array();

    /**
     * @var array
     */
    private $_tmpl = array(
        'script' => "<script type='text/javascript'>%s</script>\r\n",
        'project' => "var project%d = new GanttProjectInfo(%d, '%s', new Date(%s));\r\n",
        'task' => "var task%d = new GanttTaskInfo(%d, '%s', new Date(%s), %d, %d, '%s');\r\n",
        'addTaskInProject' => "project%d.addTask(task%d);\r\n",
        'addTaskInTask' => "task%d.addChildTask(task%d);\r\n",
        'addProjectInGantt' => "ganttChartControl%s.addProject(project%d);\r\n",
        'createGantt' => "ganttChartControl%s.create('%s');\r\n",
        'html' => "<div class='targetGanttChartControl' id='%s'></div>\r\n",
    );

    /**
     * @return void
     * @param string $target
     */
    private function __construct ($target)
    {
        $this->_id = $target;
    }

    /**
     * @return Gantt
     * @param string $target
     */
    public static function factory ($target = 'targetGanttChartControl')
    {
        return new self($target);
    }

    /**
     * @return Gantt
     * @param Project $project
     */
    public function addProject (Project $project)
    {
        $this->_projects[$project->id] = $project;
        return $this;
    }

    /**
     * @return string
     * @param Task $parent
     */
    private function _subTasks (Task $parent)
    {
        if (!isset($script)) {
            $script = '';
        }

        foreach ($parent->tasks as $task) {
            $script .= sprintf($this->_tmpl['task'], $task->id, $task->id, $task->name, str_replace('-', ',', $task->date), $task->duration, $task->percent, $task->parent);
            if (!empty($task->tasks)) {
                $script .= $this->_subTasks($task);
            }
            $script .= sprintf($this->_tmpl['addTaskInTask'], $parent->id, $task->id);
        }

        return $script;
    }

    /**
     * @return string
     */
    public function render ()
    {
        printf($this->_tmpl['html'], $this->_id);

        $script = sprintf("var ganttChartControl%s = new GanttChart();\r\n"
                . "ganttChartControl%s.setImagePath('/library/dhtmlxgantt/codebase/imgs/');\r\n"
                . "ganttChartControl%s.setEditable(false);\r\n"
                . "ganttChartControl%s.shortMonthNames = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];\r\n"
                . "ganttChartControl%s.monthNames = ['Janeiro', 'Fevereiro', 'Marco', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];\r\n"
                . "ganttChartControl%s.useShortMonthNames(false);\r\n", $this->_id, $this->_id, $this->_id, $this->_id, $this->_id, $this->_id)
        ;

        foreach ($this->_projects as $project) {

            $script .= sprintf($this->_tmpl['project'], $project->id, $project->id, $project->name, str_replace('-', ',', $project->date));

            foreach ($project->tasks as $task) {

                $script .= sprintf($this->_tmpl['task'], $task->id, $task->id, $task->name, str_replace('-', ',', $task->date), $task->duration, $task->percent, $task->parent);
                $script .= $this->_subTasks($task);
                $script .= sprintf($this->_tmpl['addTaskInProject'], $project->id, $task->id);
            }

            $script .= sprintf($this->_tmpl['addProjectInGantt'], $this->_id, $project->id);
        }

        $script .= sprintf($this->_tmpl['createGantt'], $this->_id, $this->_id);

        return sprintf($this->_tmpl['script'], $script);
    }

}