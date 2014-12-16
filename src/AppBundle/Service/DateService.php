<?php
namespace AppBundle\Service;

class DateService
{

    /**
     * @param \DateTime $date
     * @return string
     */
    public function getDate(\DateTime $date)
    {
        return $date->format('D d F Y');
    }

}
