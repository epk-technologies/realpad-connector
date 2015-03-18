<?php
namespace RealPadConnector\CMS\ListProjects;

use RealPadConnector\CMS\AbstractExport;

class Export extends AbstractExport {

    /**
     * @var ProjectSimple[]
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
        foreach($export->project as $project_element){
            $project = ProjectSimple::createFromXML($project_element);
            $export->addProject($project);
        }
        return $export;
    }

    /**
     * @param ProjectSimple $project
     */
    function addProject(ProjectSimple $project)
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
     * @return null|ProjectSimple
     */
    function getProject($ID)
    {
        return isset($this->projects[$ID])
                ? $this->projects[$ID]
                : null;
    }

    /**
     * @return ProjectSimple[]
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * @param ProjectSimple[] $projects
     */
    public function setProjects(array $projects)
    {
        $this->projects = array();
        foreach($projects as $project){
            $this->addProject($project);
        }
    }


}