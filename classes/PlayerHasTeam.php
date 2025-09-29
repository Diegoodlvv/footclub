<?php



class PlayerHasTeam
{
    public array $roles = [
        "Attaquant",
        "Milieu",
        "Defenseur",
        "Gardien"
    ];
    public string $role;
    public Team $team;
    public Player $player;



    public function __construct(Team $team, Player $player, string $role)
    {
        $this->team = $team;
        $this->player = $player;
        $this->role = $role;
    }

    public function verifRole(): void
    {

        if (!in_array($this->role, $this->roles)) {
            echo "Ce role n'existe pas";
        }
    }
}
