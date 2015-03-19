<?php
namespace RealPadConnector\CRM;

use RealPadConnector\Object;
use RealPadConnector\Utils;

class Lead extends Object {

    /**
     * @var int
     */
    protected $ID = 0;

    /**
     * @var array
     */
    protected $parameters = array(
        'name' => '',
        'surname' => '',
        'email' => '',
        'phone' => '',
        'note' => '',
        'referral' => '',
        'campaign' => ''
    );

    /**
     * @return string
     */
    function getName()
    {
        return (string)$this['name'];
    }

    /**
     * @param string $name
     */
    function setName($name)
    {
        $this['name'] = trim($name);
    }

    /**
     * @return string
     */
    function getSurname()
    {
        return (string)$this['surname'];
    }

    /**
     * @param string $surname
     */
    function setSurname($surname)
    {
        $this['surname'] = trim($surname);
    }

    /**
     * @return string
     */
    function getEmail()
    {
        return (string)$this['email'];
    }

    /**
     * @param string $email
     */
    function setEmail($email)
    {
        $this['email'] = trim($email);
    }

    /**
     * @return string
     */
    function getPhone()
    {
        return (string)$this['phone'];
    }

    /**
     * @param string $phone
     */
    function setPhone($phone)
    {
        $this['phone'] = trim($phone);
    }

    /**
     * @return string
     */
    function getNote()
    {
        return (string)$this['note'];
    }

    /**
     * @param string $note
     */
    function setNote($note)
    {
        $this['note'] = trim($note);
    }

    /**
     * @return string
     */
    function getReferral()
    {
        return (int)$this['referral'];
    }

    /**
     * @param int $referral
     */
    function setReferral($referral)
    {
        $this['referral'] = $referral ? (int)$referral : '';
    }

    /**
     * @return string
     */
    function getCampaign()
    {
        return (string)$this['campaign'];
    }

    /**
     * @param string $campaign
     */
    function setCampaign($campaign)
    {
        $this['campaign'] = trim($campaign);
    }

    /**
     * @param array $errors [reference][optional]
     * @return bool
     */
    function validate(array &$errors = null)
    {
        $errors = array();
        if($this->getName() === ''){
            $errors[] = 'missing_name';
        }

        if($this->getSurname() === ''){
            $errors[] = 'missing_surname';
        }

        if($this->getEmail() === '' && $this->getPhone() === ''){
            $errors[] = 'missing_email_or_phone';
        }

        return !$errors;
    }

    /**
     * @return int
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * @param int $ID
     */
    public function setID($ID)
    {
        $this->ID = (int)$ID;
    }


}