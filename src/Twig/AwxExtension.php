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
    
    public function awxlink($jobid, $awx_url)
    {
        return sprintf("%s/#/jobs/playbook/%d/output/", $awx_url, $jobid);
    }
}
