<?php

namespace App\Agents;

use App\Agents\Contracts\AgentInterface;
use InvalidArgumentException;

class AgentRegistry
{
    /**
     * @var array<string, AgentInterface>
     */
    private array $agents;

    public function __construct(
        ContentAgent $contentAgent,
        CourseAgent $courseAgent,
        MonetizationAgent $monetizationAgent,
        AnalyticsAgent $analyticsAgent,
        GrowthAgent $growthAgent
    ) {
        $this->agents = [
            ContentAgent::key() => $contentAgent,
            CourseAgent::key() => $courseAgent,
            MonetizationAgent::key() => $monetizationAgent,
            AnalyticsAgent::key() => $analyticsAgent,
            GrowthAgent::key() => $growthAgent,
        ];
    }

    /**
     * @return array<string, AgentInterface>
     */
    public function all(): array
    {
        return $this->agents;
    }

    /**
     * @return array<int, string>
     */
    public function keys(): array
    {
        return array_keys($this->agents);
    }

    public function get(string $key): AgentInterface
    {
        if (! isset($this->agents[$key])) {
            throw new InvalidArgumentException("Agent [$key] is not registered.");
        }

        return $this->agents[$key];
    }
}
