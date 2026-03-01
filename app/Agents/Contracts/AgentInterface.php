<?php

namespace App\Agents\Contracts;

interface AgentInterface
{
    public static function key(): string;

    public function label(): string;

    /**
     * @return array<int, string>
     */
    public function responsibilities(): array;

    /**
     * @return array<int, string>
     */
    public function skills(): array;

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    public function run(array $payload = []): array;
}
