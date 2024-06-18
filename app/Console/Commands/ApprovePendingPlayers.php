<?php

namespace App\Console\Commands;

use App\Models\Player;
use Illuminate\Console\Command;

class ApprovePendingPlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:approve-pending-players';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Approve all pending players for currently active seasons.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Player::query()->isPending()->map(function (Player $player) {
            if ($player->season->is_active and $player->created_at->diffInDays(now()) >= 3) {
                $player->approved_at = now();
                $player->save();

                return $player->refresh();
            }

            return $player;
        })->each(function (Player $player) {
            if ($player->isApproved()) {
                $this->info("Player {$player->user->name} has been approved for {$player->season->name}.");
            } else {
                $this->error("Player {$player->user->name} could not be approved for {$player->season->name}.");
            }
        });
    }
}
