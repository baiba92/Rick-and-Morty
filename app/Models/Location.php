<?php declare(strict_types=1);

namespace App\Models;

class Location
{
    private int $id;
    private string $name;
    private array $residentIds;

    public function __construct
    (
        int    $id,
        string $name,
        array  $residentIds
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->residentIds = $residentIds;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function residentIds(): array
    {
        return $this->residentIds;
    }
}