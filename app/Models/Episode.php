<?php declare(strict_types=1);

namespace App\Models;

class Episode
{
    private int $id;
    private ?string $name;
    private ?string $airDate;
    private ?string $seasonId;
    private ?array $characters;

    public function __construct
    (
        int    $id,
        string $name = null,
        string $airDate = null,
        string $seasonId = null,
        array  $characters = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->airDate = $airDate;
        $this->seasonId = $seasonId;
        $this->characters = $characters;
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

    public function characters(): array
    {
        return $this->characters;
    }
}