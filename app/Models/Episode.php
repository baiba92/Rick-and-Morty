<?php declare(strict_types=1);

namespace App\Models;

class Episode
{
    private int $id;
    private string $name;
    private string $airDate;
    private string $seasonId;
    private array $characterIds;

    public function __construct
    (
        int    $id,
        string $name,
        string $airDate,
        string $seasonId,
        array  $characterIds
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->airDate = $airDate;
        $this->seasonId = $seasonId;
        $this->characterIds = $characterIds;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function airDate(): string
    {
        return $this->airDate;
    }

    public function seasonId(): string
    {
        return $this->seasonId;
    }

    public function characterIds(): array
    {
        return $this->characterIds;
    }
}