<?php declare(strict_types=1);

namespace App\Models;

class Character
{
    private int $id;
    private string $name;
    private string $status;
    private string $species;
    private string $location;
    private string $image;
    private array $episodes;


    public function __construct
    (
        int    $id,
        string $name,
        string $status,
        string $species,
        string $location,
        string $image,
        array  $episodes
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
        $this->species = $species;
        $this->location = $location;
        $this->image = $image;
        $this->episodes = $episodes;
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

    public function location(): string
    {
        return $this->location;
    }

    public function image(): string
    {
        return $this->image;
    }

    public function firstEpisode(): string
    {
        return substr($this->episodes[0]->url, 40);
    }

    public function episodes(): array
    {
        return $this->episodes;
    }
}