<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AwxExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('awxlink', [$this, 'awxlink']),
        ];
    }
    
    public function awxlink($jobid)
    {
        return sprintf("http://awx.lepesant.com/#/jobs/playbook/%d/output/", $jobid);
    }
}
