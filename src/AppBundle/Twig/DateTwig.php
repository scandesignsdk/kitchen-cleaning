<?php
namespace AppBundle\Twig;

use AppBundle\Service\DateService;

class DateTwig extends \Twig_Extension
{
    /**
     * @var DateService
     */
    private $date;

    public function __construct(DateService $date)
    {
        $this->date = $date;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('kitchendate', [$this, 'getKitchenDate'])
        ];
    }

    public function getKitchenDate(\DateTime $date)
    {
        return $this->date->getDate($date);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'app.kitchendate';
    }
}
