<?php

namespace Cloudflare\API\Configurations;

class FirewallRuleOptions implements Configurations
{
    protected $configs = [
        'paused' => false,
        'action' => 'block'
    ];

    public function getArray(): array
    {
        return $this->configs;
    }

    public function setPaused(bool $paused)
    {
        $this->configs['paused'] = $paused;
    }

    public function setActionBlock()
    {
        $this->configs['action'] = 'block';
    }

    public function setActionAllow()
    {
        $this->configs['action'] = 'allow';
    }

    public function setActionChallenge()
    {
        $this->configs['action'] = 'challenge';
    }

    public function setActionJsChallenge()
    {
        $this->configs['action'] = 'js_challenge';
    }

    public function setActionLog()
    {
        $this->configs['action'] = 'log';
    }
}
