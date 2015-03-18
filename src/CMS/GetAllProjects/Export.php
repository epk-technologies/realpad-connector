<?php
namespace RealPadConnector\CMS\GetAllProjects;

use RealPadConnector\CMS\AbstractExport;
use RealPadConnector\CMS\Project;
use RealPadConnector\CMS\Project\Building;
use RealPadConnector\CMS\Project\Floor;
use RealPadConnector\CMS\Project\Flat;

class Export extends AbstractExport implements \Countable,\Iterator {

    /**
     * @var Project[]|Building[][]|Floor[][][]|Flat[][][][]
     */
    protected $projects = array();

    /**
     * @param \SimpleXMLElement $element
     * @return Export
     */
    public static function createFromXML(\SimpleXMLElement $element)
    {
        /** @var Export $export */
        $export = parent::createFromXML($element);

        if(isset($element->project)){
            foreach($element->project as $project_element){
                $project = Project::createFromXML($project_element);
                $export->addProject($project);
            }
        }

        return $export;
    }

    /**
     * @param Project $project
     */
    function addProject(Project $project)
    {
        $this->projects[$project->getID()] = $project;
    }

    /**
     * @param int $ID
     * @return bool
     */
    function hasProject($ID)
    {
        return isset($this->projects[$ID]);
    }

    /**
     * @param int $ID
     */
    function removeProject($ID)
    {
        if(isset($this->projects[$ID])){
            unset($this->projects[$ID]);
        }
    }

    /**
     * @param int $ID
     * @return null|Project
     */
    function getProject($ID)
    {
        return isset($this->projects[$ID])
                ? $this->projects[$ID]
                : null;
    }

    /**
     * @return Project[]
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * @param Project[] $projects
     */
    public function setProjects(array $projects)
    {
        $this->projects = array();
        foreach($projects as $project){
            $this->addProject($project);
        }
    }

    /**
     * @return Project|bool
     */
    public function current()
    {
        return current($this->projects);
    }

    public function next()
    {
        next($this->projects);
    }


    /**
     * @return int|null
     */
    public function key()
    {
        return key($this->projects);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return key($this->projects) !== null;
    }

    public function rewind()
    {
        reset($this->projects);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->projects);
    }
}