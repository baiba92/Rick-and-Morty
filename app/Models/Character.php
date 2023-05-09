<?php declare(strict_types=1);

namespace App\Models;

class Character
{
    private int $id;
    private string $name;
    private string $status;
    private string $species;
    private Location $location;
    private string $image;
    private array $episodeIds;
    private ?Episode $firstEpisode;


    public function __construct
    (
        int      $id,
        string   $name,
        string   $status,
        string   $species,
        Location   $location,
        string   $image,
        array    $episodeIds,
        ?Episode $firstEpisode = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
        $this->species = $species;
        $this->location = $location;
        $this->image = $image;
        $this->episodeIds = $episodeIds;
        $this->firstEpisode = $firstEpisode;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function species(): string
    {
        return $this->species;
    }

    public function location(): Location
    {
        return $this->location;
    }

    public function image(): string
    {
        return $this->image;
    }

    public function episodeIds(): array
    {
        return $this->episodeIds;
    }

    public function firstEpisode(): ?Episode
    {
        return $this->firstEpisode;
    }
}